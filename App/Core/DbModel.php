<?php

namespace App\Core;

// Kelas dasar untuk model yang langsung berhubungan dengan database
// Semua model yang punya tabel di database (misal User, Book, Room) wajib extends DbModel
abstract class DbModel extends Model {
    public ?int $id = null;
    // Harus didefinisikan di tiap model turunannya:
    // 1. Nama tabel di database
    abstract public static function tableName(): string;

    // 2. Daftar atribut/kolom yang mau disimpan (misal: ['name', 'email', 'password'])
    abstract public function attributes(): array;

    // 3. Kolom primary key (biasanya 'id' atau 'user_id')
    abstract public static function primaryKey(): string;

    // Fungsi untuk menyimpan data baru ke database
    public function save() {
        $tableName = $this->tableName(); // Ambil nama tabel
        $attributes = $this->attributes(); // Ambil kolom yang mau disimpan
        $params = array_map(fn($attr) => ":$attr", $attributes); // Buat parameter bind (misal :name, :email, dst)

        // Buat query SQL untuk INSERT data
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") 
                                    VALUES (" . implode(',', $params) . ")");

        // Binding nilai dari tiap atribut ke parameter SQL
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        // Eksekusi query
        $statement->execute();
        $this->{static::primaryKey()} = (int)App::$app->db->pdo->lastInsertId();
        return true;
    }

    // Fungsi untuk mencari satu record berdasarkan kondisi tertentu
    // Contoh pemakaian: User::findOne(['email' => 'abc@gmail.com'])
    public static function findOne(array $where) {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        // Bentuk SQL seperti: email = :email AND status = :status
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        // Siapkan query
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql LIMIT 1");

        // Binding parameter dengan nilai aktual
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        // Jalankan query
        $statement->execute();

        // Ambil hasil sebagai object dari class model yang memanggilnya (static::class)
        $result = $statement->fetchObject(static::class);

        // Kalau data ada, kembalikan object-nya. Kalau tidak, null.
        return $result ?: null;
    }

    // Fungsi bantu untuk menyiapkan query ke database (pakai koneksi global dari App)
    public static function prepare($sql) {
        return App::$app->db->pdo->prepare($sql);
    }
}
