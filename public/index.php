<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

use App\Core\App;
use App\Models\RegisterModel;
use App\Core\Middlewares\AuthMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => RegisterModel::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new App(dirname(__DIR__), $config);

$app->addGlobalMiddleware(new AuthMiddleware([
    '/dashboard',
    '/profile',
    '/books',
    '/booking',
    '/about',
    '/contact',
]));

require_once __DIR__ . '/../routes/web.php';

$app->run();
