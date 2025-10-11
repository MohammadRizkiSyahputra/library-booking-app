<?php
declare(strict_types=1);

use App\Models\User;

return [
    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'Library Booking App',
        'env' => $_ENV['APP_ENV'] ?? 'development',
        'debug' => filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN),
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Asia/Jakarta',
        'log_level' => $_ENV['APP_LOG_LEVEL'] ?? 'debug',
        'session_lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 7200),
    ],

    'userClass' => User::class,

    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'name' => $_ENV['DB_NAME'] ?? 'library_booking_app',
        'user' => $_ENV['DB_USER'] ?? 'root',
        'pass' => $_ENV['DB_PASS'] ?? '',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    ],

    'mail' => [
        'host' => $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com',
        'port' => (int)($_ENV['MAIL_PORT'] ?? 587),
        'username' => $_ENV['MAIL_USERNAME'] ?? '',
        'password' => $_ENV['MAIL_PASSWORD'] ?? '',
        'encryption' => $_ENV['MAIL_ENCRYPTION'] ?? 'tls',
        'from_email' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@librarybooking.local',
        'from_name' => $_ENV['MAIL_FROM_NAME'] ?? 'Library Booking App',
    ],
];
