<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Core\Request;

class SiteController extends Controller {

    // Fungsi ini contoh aja buat nerima data dari form (POST request)
    public function action(Request $request) {
        $body = $request->getBody(); // Ambil semua data yang dikirim dari form
        return 'Handling Submitted Data!'; // Nandain kalau data udah diterima (belum diproses lebih lanjut)
    }

    // Fungsi ini buat nampilin halaman utama setelah login (dashboard)
    public function dashboard() {
        $this->setTitle('Dashboard | Library Booking App'); // Set judul tab browser
        return $this->render('home/dashboard'); // Tampilkan file view "home/dashboard.php"
    }

    // Fungsi ini buat nampilin halaman daftar buku
    public function books() {
        $this->setTitle('Books | Library Booking App'); // Set judul halaman
        return $this->render('books/index'); // Panggil tampilan "books/index.php"
    }

    // Fungsi ini buat nampilin halaman booking (peminjaman ruangan atau buku)
    public function booking() {
        $this->setTitle('Booking | Library Booking App'); // Set judul halaman
        return $this->render('bookings/index'); // Panggil tampilan "bookings/index.php"
    }

    // Fungsi ini buat nampilin halaman "About" (tentang aplikasi)
    public function about() {
        $this->setTitle('About | Library Booking App'); // Set judul halaman
        return $this->render('about/index'); // Panggil tampilan "about/index.php"
    }

}
