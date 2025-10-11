<?php
namespace App\Models;

use App\Core\DbModel;

class User extends DbModel
{
    public string $nama = '';
    public ?string $nim = null;
    public ?string $nip = null;
    public string $email = '';
    public string $password = '';
    public string $confirm_password = '';
    public string $role = 'mahasiswa';
    public ?string $kubaca_img = null;
    public int $peringatan = 0;
    public string $status = 'pending';
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        $rules = [
            'nama' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 24]],
            'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'role' => [self::RULE_REQUIRED],
        ];

        if ($this->role === 'mahasiswa') {
            $rules['nim'] = [
                self::RULE_REQUIRED,
                self::RULE_NUMBER,
                [self::RULE_MIN, 'min' => 10],
                [self::RULE_MAX, 'max' => 10],
                [self::RULE_UNIQUE, 'class' => self::class]
            ];
        } elseif ($this->role === 'dosen') {
            $rules['nip'] = [
                self::RULE_REQUIRED,
                self::RULE_NUMBER,
                [self::RULE_MIN, 'min' => 18],
                [self::RULE_MAX, 'max' => 18],
                [self::RULE_UNIQUE, 'class' => self::class]
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return ['nama', 'nim', 'nip', 'email', 'password', 'role', 'kubaca_img', 'peringatan', 'status'];
    }

    public function save(): bool
    {
        $this->status = 'pending';
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function getDisplayName(): string
    {
        return $this->nama;
    }
}
