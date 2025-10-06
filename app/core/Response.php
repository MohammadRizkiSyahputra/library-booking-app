<?php
namespace App\Core;

// Kelas ini ngatur segala hal yang berhubungan dengan HTTP Response.
// Contohnya: set status code, redirect halaman, dan baca status saat ini.
class Response {

    // Mengatur status code untuk response (misal 200, 404, 500, dll.)
    // Biasanya dipakai saat error handling atau render halaman tertentu.
    public function setStatusCode(int|string $code): void {
        http_response_code((int)$code);
    }

    // Mengambil status code saat ini dari response
    // Contoh: kalau sebelumnya set 404, fungsi ini bakal return 404
    public function getStatusCode(): int {
        return http_response_code();
    }

    // Mengarahkan (redirect) user ke URL tertentu
    // Biasanya dipakai setelah login, logout, atau submit form berhasil
    public function redirect(string $url): void {
        // Kalau masih ada output di buffer, bersihkan dulu biar gak ganggu header
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Kirim header redirect ke browser dengan kode HTTP 302 (redirect sementara)
        header('Location: ' . $url, true, 302);

        // Flush output buffer dan hentikan eksekusi script supaya redirect langsung jalan
        flush();
        exit;
    }
}
