<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\App;
use App\Models\User;
use App\Models\LoginForm;
use App\Core\Services\EmailService;
use App\Core\Services\CacheService;
use App\Core\Services\Logger;
use App\Core\Middleware\GuestMiddleware;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new GuestMiddleware(['logout']));
    }

    public function login(Request $request, Response $response)
    {
        $loginModel = new LoginForm();

        $this->setLayout('auth');
        $this->setTitle('Login | Library Booking App');

        if ($request->isPost()) {
            if (!\App\Core\Csrf::validateToken($_POST['csrf_token'] ?? '')) {
                App::$app->session->setFlash('error', 'Invalid CSRF token.');
                return $this->render('login/index', ['model' => $loginModel]);
            }

            $loginModel->loadData($request->getBody());
            $loginModel->remember = isset($_POST['remember']);

            if ($loginModel->validate() && $loginModel->login()) {
                Logger::auth('logged in', App::$app->user->id);
                App::$app->session->setFlash('success', 'Login successful!');
                $response->redirect('/dashboard');
                return;
            }

            return $this->render('login/index', ['model' => $loginModel]);
        }

        return $this->render('login/index', ['model' => $loginModel]);
    }

    public function register(Request $request, Response $response)
    {
        $this->setTitle('Register | Library Booking App');
        $this->setLayout('auth');
        return $this->render('register/index');
    }

    public function registerMahasiswa(Request $request, Response $response)
    {
        $user = new User();
        $user->role = 'mahasiswa';

        $this->setTitle('Register Mahasiswa | Library Booking App');
        $this->setLayout('auth');

        if ($request->isPost()) {
            if (!\App\Core\Csrf::validateToken($_POST['csrf_token'] ?? '')) {
                App::$app->session->setFlash('error', 'Invalid CSRF token.');
                return $this->render('register/mahasiswa', ['model' => $user]);
            }

            $user->loadData($request->getBody());
            $user->role = 'mahasiswa';

            if ($user->validate() && $user->save()) {
                $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                CacheService::set('otp_' . $user->id, password_hash($otp, PASSWORD_DEFAULT), 900);
                
                App::$app->session->set('user_id_pending', $user->id);
                EmailService::sendVerificationCode($user, $otp, 'register');

                Logger::auth('registered', $user->id, "Email: {$user->email}, Role: mahasiswa");
                App::$app->session->setFlash('success', 'Registration successful! Check your email for verification code.');
                $response->redirect('/verify');
                return;
            }

            return $this->render('register/mahasiswa', ['model' => $user]);
        }

        return $this->render('register/mahasiswa', ['model' => $user]);
    }

    public function registerDosen(Request $request, Response $response)
    {
        $user = new User();
        $user->role = 'dosen';

        $this->setTitle('Register Dosen | Library Booking App');
        $this->setLayout('auth');

        if ($request->isPost()) {
            if (!\App\Core\Csrf::validateToken($_POST['csrf_token'] ?? '')) {
                App::$app->session->setFlash('error', 'Invalid CSRF token.');
                return $this->render('register/dosen', ['model' => $user]);
            }

            $user->loadData($request->getBody());
            $user->role = 'dosen';

            if ($user->validate() && $user->save()) {
                $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                CacheService::set('otp_' . $user->id, password_hash($otp, PASSWORD_DEFAULT), 900);
                
                App::$app->session->set('user_id_pending', $user->id);
                EmailService::sendVerificationCode($user, $otp, 'register');

                Logger::auth('registered', $user->id, "Email: {$user->email}, Role: dosen");
                App::$app->session->setFlash('success', 'Registration successful! Check your email for verification code.');
                $response->redirect('/verify');
                return;
            }

            return $this->render('register/dosen', ['model' => $user]);
        }

        return $this->render('register/dosen', ['model' => $user]);
    }

    public function logout(Request $request, Response $response)
    {
        $userId = App::$app->user ? App::$app->user->id : null;
        App::$app->logout();
        
        if ($userId) {
            Logger::auth('logged out', $userId);
        }
        
        $response->redirect('/');
    }
}