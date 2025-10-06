<?php

namespace App\Core;

use App\Core\Middlewares\BaseMiddleware;

// Kelas utama aplikasi, jadi “pusat koordinasi” antara request, response, router, dan komponen lain.
class App {

    // Menyimpan path root project (misalnya: C:\xampp\htdocs\project)
    public static string $ROOT_DIR;

    // Nama class user (biasanya model User)
    public string $userClass;

    // Komponen utama aplikasi
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;

    // Instance global App
    public static App $app;

    // Controller yang sedang aktif dijalankan
    public ?Controller $controller = null;

    // Data user yang sedang login (null kalau belum login)
    public ?DbModel $user;

    // Daftar middleware global (yang jalan di semua route)
    protected array $globalMiddlewares = [];

    // Konstruktor utama: inisialisasi semua komponen inti
    public function __construct($rootPath, array $config) {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        // Buat objek request, response, session, dan router
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        // Hubungkan ke database (pakai konfigurasi dari config.php)
        $this->db = new Database($config['db']);

        // Cek apakah ada user yang tersimpan di session (berarti sudah login)
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    // Method untuk login user (set user ke session)
    public function login(DbModel $user) {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    // Method logout (hapus data user dari session)
    public function logout(): void {
        $this->user = null;
        $this->session->remove('user');
    }

    // Mengecek apakah user saat ini masih guest (belum login)
    public static function isGuest() {
        return !self::$app->user;
    }

    // Menambahkan middleware global (jalan di semua request)
    public function addGlobalMiddleware(BaseMiddleware $middleware) {
        $this->globalMiddlewares[] = $middleware;
    }

    // Menentukan title halaman yang tampil di <title>
    public function getTitle(): string {
        // Kalau controller punya title sendiri, pakai itu
        if ($this->controller && method_exists($this->controller, 'getTitle')) {
            $title = $this->controller->getTitle();
            if (!empty($title)) {
                return $title;
            }
        }

        // Kalau gak ada, sesuaikan dengan status kode responsenya
        return match ($this->response->getStatusCode()) {
            403 => '403 Forbidden | Library Booking App',
            404 => '404 Not Found | Library Booking App',
            default => 'Library Booking App',
        };
    }

    // Method utama untuk menjalankan aplikasi
    public function run() {
        try {
            // Jalankan semua middleware global sebelum routing
            foreach ($this->globalMiddlewares as $middleware) {
                $middleware->execute();
            }

            // Proses route yang cocok dan tampilkan hasilnya
            echo $this->router->resolve();

        } catch (\Exception $e) {
            $code = (int)($e->getCode() ?: 500);
            $this->response->setStatusCode($code);

            // // Tambahkan ini untuk debug sementara:
            // echo "<pre style='background:#f9f9f9;border:1px solid #ccc;padding:1em'>";
            // echo htmlspecialchars($e->getMessage()) . "\n\n";
            // echo htmlspecialchars($e->getTraceAsString());
            // echo "</pre>";
            // exit;

            $errorView = match ($code) { 403 => 'errors/403', 404 => 'errors/404', default => 'errors/500' };
            echo $this->router->renderView($errorView, ['exception' => $e]);
        }
    }
}
