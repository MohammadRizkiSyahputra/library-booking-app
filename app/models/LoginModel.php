<?php

namespace App\Models;

use App\Core\Model;
use App\Core\App;
use App\Models\RegisterModel;
use PDO;

// Model ini khusus buat menangani proses login user
class LoginModel extends Model {

    // Bisa login pakai email atau NIM
    public string $identifier = ''; 
    public string $password = '';

    // Menyimpan error validasi
    public array $errors = [];

    // Aturan validasi untuk form login
    public function rules(): array {
        return [
            'identifier' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 24]]
        ];
    }

    // Fungsi utama untuk login user
    public function login(): bool {
        // Coba cari user berdasarkan email dulu
        $user = RegisterModel::findOne(['email' => $this->identifier]);

        // Kalau tidak ditemukan, coba cari pakai NIM
        if (!$user) {
            $user = RegisterModel::findOne(['nim' => $this->identifier]);
        }

        // Kalau user tetap tidak ditemukan
        if (!$user) {
            $this->addError('identifier', 'User not found');
            return false;
        }

        // Verifikasi password yang diinput dengan yang ada di database
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        // Kalau password benar, simpan data user ke session (login sukses)
        return App::$app->login($user);
    }
}
