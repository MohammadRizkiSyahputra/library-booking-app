<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load .env kalau kamu pakai dotenv
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USER'];
    $mail->Password   = $_ENV['MAIL_PASS'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($_ENV['MAIL_USER'], 'Library Booking App Test');
    $mail->addAddress($_ENV['MAIL_USER']); // kirim ke diri sendiri dulu

    $mail->isHTML(true);
    $mail->Subject = 'PHPMailer Test (Library Booking App)';
    $mail->Body    = '<h2>✅ Email test berhasil!</h2><p>Kalau kamu lihat email ini, koneksi Gmail SMTP kamu sudah benar.</p>';

    $mail->send();
    echo "✅ Email test berhasil dikirim ke " . $_ENV['MAIL_USER'];
} catch (Exception $e) {
    echo "❌ Gagal mengirim email. Error: {$mail->ErrorInfo}";
}
