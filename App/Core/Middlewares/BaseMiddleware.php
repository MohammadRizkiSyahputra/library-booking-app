<?php

namespace App\Core\Middlewares;

// Kelas dasar (abstract) untuk semua middleware di aplikasi
abstract class BaseMiddleware
{
    // Setiap middleware wajib punya method execute()
    // Method ini berisi logika yang akan dijalankan sebelum controller dijalankan
    abstract public function execute(): void;
}
