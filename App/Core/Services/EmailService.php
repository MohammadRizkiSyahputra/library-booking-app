<?php

namespace App\Core\Services;

use App\Core\App;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class EmailService
{   

    private static function configureMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'] ?? $_ENV['MAIL_USER'] ?? '';
        $mail->Password = $_ENV['MAIL_PASSWORD'] ?? $_ENV['MAIL_PASS'] ?? '';
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? 'tls';
        $mail->Port = (int)($_ENV['MAIL_PORT'] ?? 587);
        $mail->isHTML(true);
        return $mail;
    }

    public static function send(string $to, string $toName, string $subject, string $body, bool $ccSelf = false): bool
    {
        try {
            $mail = self::configureMailer();
            $fromEmail = $_ENV['MAIL_FROM_ADDRESS'] ?? $_ENV['MAIL_USERNAME'] ?? $_ENV['MAIL_USER'] ?? 'noreply@librarybooking.local';
            $fromName = $_ENV['MAIL_FROM_NAME'] ?? 'Library Booking App';
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($to, $toName);
            if ($ccSelf) $mail->addCC($to);

            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (MailException $e) {
            error_log('Email error: ' . $e->getMessage());
            return false;
        }
    }

    public static function sendVerificationCode(User $user, string $otp, string $purpose = 'register'): bool
    {
        $isDevelopment = ($_ENV['APP_ENV'] ?? 'production') === 'development';
        
        if ($isDevelopment) {
            \App\Core\App::$app->session->set('dev_otp_display', [
                'otp' => $otp,
                'user' => $user->nama,
                'email' => $user->email,
                'purpose' => $purpose
            ]);
            return true;
        }

        $subject = $purpose === 'reset_password'
            ? 'Password Reset Request | Library Booking App'
            : 'Account Verification Code | Library Booking App';

        $intro = $purpose === 'reset_password'
            ? 'Kami menerima permintaan untuk mereset kata sandi akun kamu.'
            : 'Selamat datang! Berikut adalah kode verifikasi akun kamu.';

        $note = $purpose === 'reset_password'
            ? 'Jika kamu tidak meminta pengaturan ulang kata sandi, abaikan email ini.'
            : 'Jangan bagikan kode ini kepada siapa pun demi keamanan akunmu.';

        $body = "
            <p>Hai <strong>{$user->nama}</strong>,</p>
            <p>{$intro}</p>
            <p>Kode verifikasi: <strong>{$otp}</strong></p>
            <p>Kode ini berlaku selama 15 menit.</p>
            <p>{$note}</p>
            <p>Library Booking App PNJ</p>
        ";

        return self::send($user->email, $user->nama, $subject, $body);
    }

    public static function sendKubacaVerified(User $user): bool
    {
        $isDevelopment = ($_ENV['APP_ENV'] ?? 'production') === 'development';
        
        if ($isDevelopment) {
            \App\Core\App::$app->session->setFlash('dev_email', 'KuBaca verified email would be sent to: ' . $user->email);
            return true;
        }

        $subject = 'KuBaca Verified | Library Booking App';
        $body = "
            <p>Hai <strong>{$user->nama}</strong>,</p>
            <p>Selamat! KuBaca kamu telah diverifikasi oleh admin.</p>
            <p>Akun kamu sekarang sudah fully verified dan bisa menggunakan semua fitur Library Booking App.</p>
            <p>Terima kasih,<br>Library Booking App PNJ</p>
        ";

        return self::send($user->email, $user->nama, $subject, $body);
    }

}
