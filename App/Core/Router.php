<?php
namespace App\Core;

use App\Core\Exceptions\NotFoundException;

// Kelas Router bertugas mencocokkan URL (route) dengan controller atau view yang sesuai.
// Dia juga ngatur proses render halaman (layout + view) dan middleware tiap controller.
class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    // Namespace default untuk controller (biar cukup nulis "SiteController" tanpa path lengkap)
    private string $controllerNamespace = 'App\\Controllers\\';

    public function __construct(Request $request, Response $response) {
        $this->request  = $request;
        $this->response = $response;
    }

    // Daftar route GET
    public function get(string $path, callable|array|string $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    // Daftar route POST
    public function post(string $path, callable|array|string $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    // Fungsi utama router: mencocokkan URL yang sedang diakses dengan route yang terdaftar
    public function resolve(): string {
        $path   = $this->request->getPath();     // contoh: /login
        $method = $this->request->method();      // contoh: post

        $callback = $this->routes[$method][$path] ?? null;

        // Kalau route tidak ditemukan, tampilkan 404
        if ($callback === null) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        // Kalau callback-nya string, artinya langsung render view
        // contoh: $router->get('/', 'home/index');
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // Kalau callback-nya berupa [ControllerClass, 'method']
        if (is_array($callback)) {
            [$controllerClass, $action] = $callback;

            // Validasi nama method (tidak boleh mengandung '/')
            if (is_string($action) && str_contains($action, '/')) {
                $this->response->setStatusCode(500);
                return "Invalid action name '{$action}'. Use a single method name like 'index'.";
            }

            // Kalau class belum pakai namespace, tambahkan prefix default
            if (is_string($controllerClass) && !str_contains($controllerClass, '\\')) {
                $controllerClass = $this->controllerNamespace . $controllerClass;
            }

            // Kalau class controller tidak ditemukan
            if (!class_exists($controllerClass)) {
                $this->response->setStatusCode(500);
                return "Controller class not found: {$controllerClass}";
            }

            // Buat instance controller
            $controller = new $controllerClass();
            App::$app->controller = $controller;
            App::$app->controller->action = $action;

            // Jalankan semua middleware milik controller
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }

            // Pastikan method-nya ada di controller
            if (!method_exists($controller, $action)) {
                $this->response->setStatusCode(500);
                return "Controller action not found: {$controllerClass}::{$action}";
            }

            // Jalankan method di controller
            $result = call_user_func([$controller, $action], $this->request, $this->response);

            // Kalau hasilnya berupa string (biasanya view), kembalikan ke browser
            return is_string($result) ? $result : '';
        }

        // Kalau callback berupa closure (fungsi anonim)
        if (is_callable($callback)) {
            return call_user_func($callback, $this->request, $this->response);
        }

        // Kalau tipe callback tidak dikenal
        $this->response->setStatusCode(500);
        return 'Invalid route callback';
    }

    // Render view lengkap dengan layout (layout + content view)
    public function renderView(string $view, array $data = []): string {
        $layoutsContent = $this->layoutContent();
        $viewContent    = $this->renderOnlyView($view, $data);
        return str_replace('{{content}}', $viewContent, $layoutsContent);
    }

    // Render konten view tanpa mengganti layout
    public function renderContent(string $viewContent): string {
        $layoutsContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutsContent);
    }

    // Mengambil isi file layout (main.php, auth.php, dll.)
    protected function layoutContent(): string {
        $controller = App::$app->controller ?? null;
        $layout = 'main';

        // Kalau controller punya layout khusus, pakai itu
        if ($controller && property_exists($controller, 'layout') && !empty($controller->layout)) {
            $layout = $controller->layout;
        }

        ob_start();
        include_once App::$ROOT_DIR . "/App/Views/layouts/{$layout}.php";
        return ob_get_clean();
    }

    // Render file view tertentu dan ambil output-nya sebagai string
    protected function renderOnlyView(string $view, array $data): string {
        // Ubah setiap item array $data menjadi variabel
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once App::$ROOT_DIR . "/App/Views/{$view}.php";
        return ob_get_clean();
    }
}
