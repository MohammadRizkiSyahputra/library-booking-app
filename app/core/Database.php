<?php
namespace App\Core;

use PDO;

// Kelas ini mengatur semua hal yang berhubungan dengan koneksi dan migrasi database
class Database {
    // Properti utama yang menyimpan instance koneksi PDO
    public PDO $pdo;

    // Konstruktor: langsung bikin koneksi ke database saat class diinisialisasi
    public function __construct(array $config) {
        // Ambil data konfigurasi dari parameter (biasanya dari config.php atau .env)
        $dsn = $config['dsn'] ?? '';      // Contoh: mysql:host=localhost;port=3306;dbname=library_booking_app
        $user = $config['user'] ?? '';    // Username database
        $pass = $config['password'] ?? ''; // Password database

        // Buat koneksi PDO
        $this->pdo = new PDO($dsn, $user, $pass);

        // Atur supaya PDO menampilkan error berupa exception (lebih mudah di-debug)
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Jalankan semua migration yang belum diterapkan ke database
    public function applyMigrations() {
        $this->createMigrationTable(); // Pastikan tabel migrations ada
        $appliedMigration = $this->getAppliedMigration(); // Ambil daftar migration yang sudah pernah diterapkan

        $newMigrations = [];
        // Baca semua file di folder /migrations
        $files = scandir(App::$ROOT_DIR.'/migrations');
        // Bandingkan file migration yang ada dengan yang sudah disimpan di DB
        $toApplyMigrations = array_diff($files, $appliedMigration);

        // Loop tiap migration yang belum pernah dijalankan
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue; // Lewati simbol folder
            }

            // Load file migration
            require_once App::$ROOT_DIR.'/migrations/'.$migration;
            // Ambil nama class dari nama file (tanpa .php)
            $className = pathinfo($migration, PATHINFO_FILENAME);
            // Buat objek dari class migration tersebut
            $instance = new $className();

            // Jalankan fungsi up() dari migration
            $this->log("Applying Migration $migration");
            $instance->up();
            $this->log("Applied Migration $migration");

            // Simpan nama migration yang baru dijalankan
            $newMigrations[] = $migration;
        }

        // Kalau ada migration baru, simpan ke tabel migrations
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            // Kalau tidak ada migration baru
            $this->log("All migrations are applied");
        }
    }

    // Membuat tabel migrations (kalau belum ada)
    // Tabel ini menyimpan daftar migration yang sudah dijalankan
    public function createMigrationTable() {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;");
    }

    // Mengambil daftar nama migration yang sudah pernah diterapkan
    public function getAppliedMigration() {
        $statement = $this->pdo->prepare("SELECT migration from migrations");
        $statement->execute();
        // Ambil hasilnya dalam bentuk array kolom tunggal
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    // Menyimpan nama-nama migration baru yang berhasil dijalankan ke tabel migrations
    public function saveMigrations(array $migrations) {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    // Helper untuk menyiapkan query (supaya bisa pakai bindValue, dll.)
    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    // Fungsi untuk menampilkan log di terminal saat migration dijalankan
    protected function log($message) {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
