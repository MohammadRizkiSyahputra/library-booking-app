<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Core\Database;

$config = [
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'name' => $_ENV['DB_NAME'] ?? 'library_booking_app',
        'user' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? '',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4'
    ]
];

$db = new Database($config['db']);

echo "Seeding database...\n\n";

// Insert admin user
echo "Checking admin user...\n";
$check = $db->prepare("SELECT id FROM users WHERE email = ?");
$check->execute(['admin@pnj.ac.id']);
if (!$check->fetch()) {
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (nama, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['Admin User', 'admin@pnj.ac.id', $adminPassword, 'admin', 'verified']);
    echo "✓ Admin user created\n";
} else {
    echo "✓ Admin user already exists\n";
}
echo "  Email: admin@pnj.ac.id\n";
echo "  Password: admin123\n\n";

// Insert mahasiswa user
echo "Checking mahasiswa user...\n";
$check = $db->prepare("SELECT id FROM users WHERE email = ?");
$check->execute(['mahasiswa@stu.pnj.ac.id']);
if (!$check->fetch()) {
    $userPassword = password_hash('test1234', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (nama, nim, email, password, role, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Test Mahasiswa', '1234567890', 'mahasiswa@stu.pnj.ac.id', $userPassword, 'mahasiswa', 'verified']);
    echo "✓ Mahasiswa user created\n";
} else {
    echo "✓ Mahasiswa user already exists\n";
}
echo "  Email: mahasiswa@stu.pnj.ac.id\n";
echo "  NIM: 1234567890\n";
echo "  Password: test1234\n\n";

// Insert dosen user
echo "Checking dosen user...\n";
$check = $db->prepare("SELECT id FROM users WHERE email = ?");
$check->execute(['dosen@tik.pnj.ac.id']);
if (!$check->fetch()) {
    $userPassword = password_hash('test1234', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (nama, nip, email, password, role, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Test Dosen', '123456789012345678', 'dosen@tik.pnj.ac.id', $userPassword, 'dosen', 'verified']);
    echo "✓ Dosen user created\n";
} else {
    echo "✓ Dosen user already exists\n";
}
echo "  Email: dosen@tik.pnj.ac.id\n";
echo "  NIP: 123456789012345678\n";
echo "  Password: test1234\n\n";

echo "Seeding complete!\n";
