<?php

namespace App\Core;

// Kelas dasar untuk semua controller di aplikasi
// Controller ini jadi "otak" yang ngatur antara user request, model, dan view.
abstract class Controller
{
    // Layout default yang dipakai (biasanya file di views/layouts/)
    public string $layout = 'main';

    // Nama action (fungsi yang sedang dijalankan di controller)
    public string $action = '';

    // Judul halaman (buat tag <title> di layout)
    public ?string $title = null;

    // Daftar middleware yang terpasang di controller ini
    protected array $middlewares = [];

    // Ganti layout yang digunakan (misal auth, admin, dll.)
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    // Render view sesuai nama file dan data (params)
    // Contoh: render('home/index', ['user' => $user])
    public function render(string $view, array $params = []): string
    {
        return App::$app->router->renderView($view, $params);
    }

    // Daftarkan middleware baru ke controller ini
    // Contoh: $this->registerMiddleware(new AuthMiddleware(['profile']))
    public function registerMiddleware($middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    // Ambil semua middleware yang sudah didaftarkan
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    // Set judul halaman untuk <title> di layout
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    // Ambil judul halaman yang sudah di-set
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
