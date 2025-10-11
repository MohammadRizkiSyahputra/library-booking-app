<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\App;
use App\Models\User;
use App\Models\VerificationForm;
use App\Core\Services\EmailService;
use App\Core\Services\CacheService;

class VerifyController extends Controller
{
    public function verify(Request $request, Response $response)
    {
        $this->setLayout('auth');
        $this->setTitle('Verify Account | Library Booking App');

        $userId = App::$app->session->get('user_id_pending');
        if (!$userId) {
            App::$app->session->setFlash('error', 'No pending verification. Please register again.');
            $response->redirect('/register');
            return;
        }

        $model = new VerificationForm();

        if ($request->isPost()) {
            $model->loadData($request->getBody());

            if (!$model->validate()) {
                return $this->render('verify/index', ['model' => $model]);
            }

            $code = trim($model->code);
            $cachedHash = CacheService::get('otp_' . $userId);

            if (!$cachedHash) {
                App::$app->session->setFlash('error', 'Verification code expired.');
                return $this->render('verify/index', ['model' => $model]);
            }

            if (!password_verify($code, $cachedHash)) {
                App::$app->session->setFlash('error', 'Invalid verification code.');
                return $this->render('verify/index', ['model' => $model]);
            }

            $user = User::findOne(['id' => $userId]);
            $newStatus = ($user->role === 'dosen') ? 'verified' : 'active';

            $stmt = App::$app->db->prepare("UPDATE users SET status = :status WHERE id = :id");
            $stmt->bindValue(':status', $newStatus);
            $stmt->bindValue(':id', $userId);
            $stmt->execute();

            CacheService::delete('otp_' . $userId);
            App::$app->session->remove('user_id_pending');
            
            if ($user->role === 'dosen') {
                App::$app->session->setFlash('success', 'Account verified! You can now log in.');
            } else {
                App::$app->session->setFlash('success', 'Email verified! You can now log in');
            }
            
            $response->redirect('/login');
            return;
        }

        return $this->render('verify/index', ['model' => $model]);
    }

    public function resend(Request $request, Response $response)
    {
        $userId = App::$app->session->get('user_id_pending');

        if (!$userId) {
            App::$app->session->setFlash('error', 'No pending verification. Please register again.');
            $response->redirect('/register');
            return;
        }

        $user = User::findOne(['id' => $userId]);
        if (!$user) {
            App::$app->session->setFlash('error', 'User not found.');
            $response->redirect('/register');
            return;
        }

        $lastResend = App::$app->session->get('last_resend_time');
        if ($lastResend && (time() - $lastResend < 60)) {
            App::$app->session->setFlash('error', 'Please wait before requesting a new code.');
            $response->redirect('/verify');
            return;
        }

        App::$app->session->set('last_resend_time', time());

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        CacheService::set('otp_' . $user->id, password_hash($otp, PASSWORD_DEFAULT), 900);
        EmailService::sendVerificationCode($user, $otp, 'register');

        App::$app->session->setFlash('success', 'New verification code sent.');
        $response->redirect('/verify');
    }
}