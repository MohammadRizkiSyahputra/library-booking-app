<?php

class m0002_added_status_to_users_table {
    public function up() {
        $db = \App\Core\App::$app->db;
        $sql = "ALTER TABLE users 
                ADD COLUMN status TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active, 2=suspend, 3=deleted' 
                AFTER password;";
        $db->pdo->exec($sql);
    }

    public function down() {
        $db = \App\Core\App::$app->db;
        $sql = "ALTER TABLE users DROP COLUMN status;";
        $db->pdo->exec($sql);
    }
}
