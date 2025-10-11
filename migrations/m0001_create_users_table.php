<?php

class m0001_create_users_table
{
    public function up()
    {
        $db = \App\Core\App::$app->db;
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            nim CHAR(10) NULL,
            nip CHAR(18) NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('mahasiswa', 'dosen', 'admin') NOT NULL DEFAULT 'mahasiswa',
            kubaca_img VARCHAR(255) NULL,
            peringatan TINYINT UNSIGNED NOT NULL DEFAULT 0,
            status ENUM('pending', 'active', 'verified', 'suspended') NOT NULL DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_email (email),
            INDEX idx_nim (nim),
            INDEX idx_nip (nip),
            INDEX idx_role (role),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = \App\Core\App::$app->db;
        $sql = "DROP TABLE IF EXISTS users;";
        $db->pdo->exec($sql);
    }
}
