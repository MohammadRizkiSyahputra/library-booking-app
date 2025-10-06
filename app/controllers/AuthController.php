<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\RegisterModel;
use App\Models\LoginModel;
use App\Core\App;
use App\Core\Response;
use App\Services\EmailService;

class AuthController extends Controller {

    // Buat nampilin halaman login dan juga proses login user
    public function login(Request $request, Response $response) {
        $loginModel = new LoginModel(); // // Bikin objek dari model login

        // Kalau user ngeklik tombol login (method POST)
        if ($request->isPost()) {
            // Ambil data dari form dan masukin ke model
            $loginModel->loadData($request->getBody());

        // Validasi data dan coba login
        if($loginModel->validate() && $loginModel->login()) {
            // Kalau sukses login, langsung arahkan ke mana? dashboard
            App::$app->session->setFlash('success', 'Success Login!');
            $response->redirect('/dashboard');
            return;
        }
        
        // Kalau gagal login, tetap tampilkan halaman login tapi bawa pesan error
        return $this->render('login/index', [
                'model' => $loginModel
            ]);
        }

        // Tampilkan halaman login
        $this->setLayout('auth'); // Pake layout auth
        $this->setTitle('Login | Library Booking App'); // Set judul halaman
        return $this->render('login/index', [
                'model' => $loginModel
        ]);
    }

    // Buat nampilin halaman register 
    public function register(Request $request, Response $response){
    $user = new RegisterModel();

    if ($request->isPost()) {
        $user->loadData($request->getBody());

        if ($user->validate() && $user->save()) {
            App::$app->session->set('user_id_pending', $user->id);
            session_write_close();

            EmailService::sendVerificationCode($user, 'register');

            App::$app->session->setFlash('success', 'Registration successful! Please verify your email.');
            $response->redirect('/verify');
            return;
        }

        return $this->render('register/index', ['model' => $user]);
    }

    $this->setTitle('Register | Library Booking App');
    $this->setLayout('auth');
    return $this->render('register/index', ['model' => $user]);
    }

    // Fungsi ini buat logout user dari aplikasi
    public function logout(Request $request, Response $response) {
        App::$app->logout(); // Hapus session user yang lagi login
        $response->redirect('/'); // Balikin ke halaman utama (login)
    }

    private function sendVerificationCode(RegisterModel $user): void
{
    $otpPlain = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $otpHash  = password_hash($otpPlain, PASSWORD_DEFAULT);
    $expires  = date('Y-m-d H:i:s', time() + 15 * 60);

    // Update DB
    $stmt = App::$app->db->prepare("
        UPDATE users 
        SET verification_code = :code, verification_expires_at = :exp 
        WHERE id = :id
    ");
    $stmt->bindValue(':code', $otpHash);
    $stmt->bindValue(':exp',  $expires);
    $stmt->bindValue(':id',   $user->id);
    $stmt->execute();

    // Send email
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($_ENV['MAIL_USER'], 'Library Booking App');
        $mail->addAddress($user->email, $user->name);
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $mail->Body = "
            <p>Hai <b>{$user->name}</b>,</p>
            <p>Kode verifikasi akun kamu adalah:</p>
            <h2 style='letter-spacing:2px;'>{$otpPlain}</h2>
            <p>Kode berlaku 15 menit, jangan dibagikan ke siapa pun.</p>
            <br><small>Library Booking App PNJ</small>
        ";
        $mail->send();
    } catch (\Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
    }
}
}