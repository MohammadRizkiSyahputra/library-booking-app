<?php

namespace App\Services;

use App\Core\App;
use App\Models\RegisterModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class EmailService
{   

    private static function configureMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->isHTML(true);
        return $mail;
    }

    public static function send(string $to, string $toName, string $subject, string $body, bool $ccSelf = false): bool
    {
        try {
            $mail = self::configureMailer();
            $mail->setFrom($_ENV['MAIL_USER'], 'Library Booking App');
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

    /**
     * Generate OTP, save to DB, and send via email.
     */
    public static function sendVerificationCode(RegisterModel $user, string $purpose = 'register'): bool
    {
        // Generate OTP (6 digits)
        $otpPlain = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpHash  = password_hash($otpPlain, PASSWORD_DEFAULT);
        $expires  = date('Y-m-d H:i:s', time() + 15 * 60); // 15 min expiry

        // Save OTP to DB
        $stmt = App::$app->db->prepare("
            UPDATE users 
            SET verification_code = :code, verification_expires_at = :exp 
            WHERE id = :id
        ");
        $stmt->bindValue(':code', $otpHash);
        $stmt->bindValue(':exp',  $expires);
        $stmt->bindValue(':id',   $user->id);
        $stmt->execute();

        // Customize message per purpose
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
            <div style='font-family:Segoe UI,Arial,sans-serif;background:#f9fafb;padding:20px;border-radius:10px;'>
                <div style='max-width:520px;margin:auto;background:#fff;padding:30px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);'>
                    <h2 style='color:#4f46e5;text-align:center;margin-bottom:15px;'>Library Booking App PNJ</h2>
                    <p>Hai <strong>{$user->name}</strong>,</p>
                    <p>{$intro}</p>
                    <div style='text-align:center;margin:25px 0;'>
                        <div style='display:inline-block;background:#4f46e5;color:#fff;font-size:22px;letter-spacing:3px;
                                    padding:12px 24px;border-radius:8px;font-weight:bold;'>
                            {$otpPlain}
                        </div>
                    </div>
                    <p>Kode ini berlaku selama <strong>15 menit</strong>.</p>
                    <p style='color:#6b7280;font-size:14px;'>{$note}</p>
                    <hr style='border:none;border-top:1px solid #eee;margin:25px 0;'>
                    <p style='font-size:13px;color:#9ca3af;text-align:center;'>© " . date('Y') . " Library Booking App PNJ</p>
                </div>
            </div>
        ";

        return self::send($user->email, $user->name, $subject, $body);
    }

    public static function verifyCode(RegisterModel $user, string $code): bool
    {
        if (!$user->verification_code || !$user->verification_expires_at) {
            return false;
        }

        if (strtotime($user->verification_expires_at) < time()) {
            return false;
        }

        return password_verify($code, (string)$user->verification_code);
    }

    public static function clearCode(RegisterModel $user): void
    {
        $stmt = App::$app->db->prepare("
            UPDATE users 
            SET verification_code = NULL, verification_expires_at = NULL
            WHERE id = :id
        ");
        $stmt->bindValue(':id', $user->id);
        $stmt->execute();
    }
}
