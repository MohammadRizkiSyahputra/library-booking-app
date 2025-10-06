<?php

namespace App\Core\Middlewares;

use App\Core\App;
use App\Core\Exceptions\ForbiddenException;

// Middleware ini berfungsi untuk membatasi akses halaman tertentu
// agar hanya bisa diakses oleh user yang sudah login.
class AuthMiddleware extends BaseMiddleware
{
    // Menyimpan daftar path (route) yang butuh autentikasi
    private array $protectedPaths = [];

    // Konstruktor menerima daftar path yang dilindungi
    public function __construct(array $protectedPaths = [])
    {
        $this->protectedPaths = $protectedPaths;
    }

    // Fungsi utama untuk menjalankan pemeriksaan middleware
    public function execute(): void
    {
        // Jika user sudah login, tidak perlu dicek lagi
        if (!App::isGuest()) {
            return;
        }

        // Ambil path yang sedang diakses
        $currentPath = App::$app->request->getPath();

        // Cek apakah path sekarang termasuk dalam daftar yang dilindungi
        foreach ($this->protectedPaths as $path) {
            // Jika path cocok atau dimulai dengan path yang dilindungi
            if ($currentPath === $path || str_starts_with($currentPath, $path)) {
                // Lempar error 403 (Forbidden)
                throw new ForbiddenException();
            }
        }
    }
}
