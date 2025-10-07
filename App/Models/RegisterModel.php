<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\DbModel;
use PDO;
use Exception;

// Model ini mewakili tabel "users" di database.
// Semua logika terkait data user (register, status akun, hashing password) ditangani di sini.
class RegisterModel extends DbModel {

    // Daftar status user
    const STATUS_INACTIVE   = 0; // Baru daftar, belum diverifikasi
    const STATUS_ACTIVE     = 1; // Sudah aktif dan bisa login
    const STATUS_SUSPENDED  = 2; // Akun dibekukan
    const STATUS_DELETED    = 3; // Akun dihapus
    const STATUS_VERIFIED   = 4; // Sudah diverifikasi admin (setelah kirim bukti)

    // Properti yang mewakili kolom pada tabel "users"
    public string $name = ''; 
    public string $nim = ''; 
    public string $email = ''; 
    public string $password = ''; 
    public string $confirm_password = '';
    public ?string $created_at = null;
    public int $status = self::STATUS_INACTIVE;
    public ?string $verification_code = null;
    public ?string $verification_expires_at = null;
    public ?string $kubaca_image = null;
    public ?string $verified_at = null;

    // Nama tabel di database
    public static function tableName(): string {
        return 'users';
    }

    // Primary key (biasanya kolom id)
    public static function primaryKey(): string {
        return 'id';
    }

    // Aturan validasi form register
    public function rules(): array {
        return [
            // Nama wajib diisi, minimal 3 karakter, dan unik
            'name' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => 3],
                [self::RULE_UNIQUE, 'class' => self::class]
            ],

            // NIM wajib diisi, harus angka, panjang tepat 10 digit, dan unik
            'nim' => [
                self::RULE_REQUIRED,
                self::RULE_NUMBER,
                [self::RULE_MIN, 'min' => 10],
                [self::RULE_MAX, 'max' => 10],
                [self::RULE_UNIQUE, 'class' => self::class]
            ],

            // Email wajib diisi, harus domain PNJ yang valid (stu.pnj.ac.id atau <jurusan>.pnj.ac.id), dan unik
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],

            // Password wajib diisi, panjang minimal 4 karakter, maksimal 24 karakter
            'password' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => 4],
                [self::RULE_MAX, 'max' => 24]
            ],

            // Konfirmasi password harus sama dengan password
            'confirm_password' => [
                self::RULE_REQUIRED,
                [self::RULE_MATCH, 'match' => 'password']
            ]
        ];
    }

    // Kolom-kolom yang boleh disimpan ke database saat register
    public function attributes(): array {
        return ['name','nim','email','password','status','verification_code','verification_expires_at','kubaca_image','verified_at'];
    }

    // Override fungsi save() dari DbModel
    // Tambahkan hashing password dan status default sebelum simpan
    public function save() {
        // Saat user baru daftar, status = INACTIVE
        $this->status = self::STATUS_INACTIVE;  
        // Hash password biar aman (pakai bcrypt default PHP)
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Panggil save() milik parent (DbModel) untuk insert ke database
        return parent::save();
    }

    // Fungsi helper untuk menampilkan nama user di tampilan
    public function getDisplayName() {
        return $this->name;
    }

    // Fitur tambahan (bisa dipakai nanti untuk verifikasi email dengan kode unik)
    // public function generateVerificationCode(): string {
    //     $this->verification_code = strtoupper(bin2hex(random_bytes(3))); // Contoh hasil: “A9C4E2”
    //     return $this->verification_code;
    // }
}
