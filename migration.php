<?php
use App\Core\App;
use App\Core\Database;
use App\Models\RegisterModel;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
    'userClass' => RegisterModel::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
    ];

$app = new App(__DIR__, $config);
$app->db->applyMigrations();
