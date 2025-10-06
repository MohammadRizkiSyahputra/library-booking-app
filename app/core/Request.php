<?php

namespace App\Core;

// Kelas ini menangani semua hal yang berhubungan dengan HTTP Request.
// Mulai dari mengambil URL/path, method (GET/POST), sampai data yang dikirim dari form.
class Request {

    // Mengambil path dari URL (misal "/login" atau "/books/detail")
    public function getPath() {
        // Ambil request URI dari server (misal: /login?user=rizki)
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        // Cek apakah ada tanda tanya (parameter query)
        $position = strpos($path, '?');
        // Kalau tidak ada query string, langsung return path-nya
        if ($position === false) {
            return $path;
        }
        // Kalau ada query string, ambil bagian sebelum tanda tanya saja
        return substr($path, 0, $position);
    }

    // Mengambil method HTTP (get, post, put, delete, dll.)
    public function method() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    // Mengecek apakah request-nya pakai GET
    public function isGet() {
        return $this->method() === 'get';
    }

    // Mengecek apakah request-nya pakai POST
    public function isPost() {
        return $this->method() === 'post';
    }

    // Mengambil data dari form (GET/POST) dan men-sanitize isinya
    public function getBody() {
        $body = [];

        // Kalau method GET, ambil data dari $_GET
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                // Bersihkan input agar aman dari XSS
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        // Kalau method POST, ambil data dari $_POST
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                // Bersihkan input agar aman
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
