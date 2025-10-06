<?php

class m0001_initial {
    public function up() {
        $db = \app\core\App::$app->db;
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            nim CHAR(10) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $db->pdo->exec($sql);
    }

    public function down() {
        $db = \app\core\App::$app->db;
        $sql = "DROP TABLE users;";
        $db->pdo->exec($sql);
    }
}