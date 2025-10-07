<?php

namespace App\Core\Exceptions;

use Exception;

// Kelas ini dipakai buat nangani error ketika user
// mencoba akses halaman yang gak punya izin (unauthorized)
class ForbiddenException extends Exception
{
    // Pesan default yang bakal muncul kalau error ini dilempar
    protected $message = 'You are not authorized to access this page.';

    // Kode HTTP 403 artinya "Forbidden" (akses ditolak)
    protected $code = 403;
}
