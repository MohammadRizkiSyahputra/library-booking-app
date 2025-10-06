<?php

class m0003_add_verification_columns {
    public function up() {
        $db = \App\Core\App::$app->db->pdo;
        $db->exec("
            ALTER TABLE users
            ADD COLUMN verification_code VARCHAR(255) NULL AFTER password,
            ADD COLUMN verification_expires_at DATETIME NULL AFTER verification_code,
            ADD COLUMN kubaca_image VARCHAR(255) NULL AFTER verification_expires_at,
            ADD COLUMN verified_at DATETIME NULL AFTER kubaca_image;
        "); 
    }

    public function down() {
        $db = \App\Core\App::$app->db->pdo;
        $db->exec("
            ALTER TABLE users
            DROP COLUMN verification_code,
            DROP COLUMN verification_expires_at,
            DROP COLUMN kubaca_image,
            DROP COLUMN verified_at;
        ");
    }
}
