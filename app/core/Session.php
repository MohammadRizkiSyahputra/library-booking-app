<?php

namespace App\Core;

// Kelas ini mengatur semua hal yang berhubungan dengan session PHP,
// termasuk menyimpan data user yang login, flash message (pesan sementara), dll.
class Session
{
    // Key khusus untuk menyimpan flash message di session
    protected const FLASH_KEY = 'flash_messages';

    // Konstruktor: dijalankan otomatis saat class Session dibuat
    public function __construct()
    {
        // Pastikan session sudah aktif (kalau belum, aktifkan)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Ambil semua flash message yang tersimpan di session
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        // Tandai setiap flash message untuk dihapus setelah ditampilkan sekali
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        // Simpan kembali status terbaru ke session
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    // Menyimpan flash message baru (biasanya setelah aksi berhasil/gagal)
    // Contoh: $session->setFlash('success', 'Data berhasil disimpan!');
    public function setFlash(string $key, string $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false, // pesan baru, jangan dihapus dulu
            'value' => $message
        ];
    }

    // Mengambil flash message untuk ditampilkan di view
    // Setelah diambil, akan otomatis dihapus di akhir request
    public function getFlash(string $key): string|false
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    // Destructor: otomatis jalan saat object Session dihancurkan (akhir script)
    // Digunakan untuk menghapus flash message yang sudah ditampilkan
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        // Hapus pesan yang sudah ditandai untuk dihapus
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        // Simpan perubahan ke session
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    // Menyimpan data umum ke session (bisa apa saja)
    // Contoh: $session->set('user', $userId);
    public function set($key, $value) 
    {
        $_SESSION[$key] = $value;
    }

    // Mengambil data dari session berdasarkan key
    // Contoh: $userId = $session->get('user');
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    // Menghapus data tertentu dari session
    // Contoh: $session->remove('user');
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}
