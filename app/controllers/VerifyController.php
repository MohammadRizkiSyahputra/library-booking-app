<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\App;
use App\Models\RegisterModel;
use App\Controllers\AuthController;
use App\Services\EmailService;


class VerifyController extends Controller
{
    public function verify(Request $request, Response $response){
    $this->setLayout('auth');
    $this->setTitle('Verify Account | Library Booking App');

    $userId = App::$app->session->get('user_id_pending');
    if (!$userId) {
        App::$app->session->setFlash('error', 'No pending verification session. Please register again.');
        $response->redirect('/register');
        return;
    }

    $model = new \App\Models\VerifyModel();

    if ($request->isPost()) {
        $model->loadData($request->getBody());

        if (!$model->validate()) {
            return $this->render('verify/index', ['model' => $model]);
        }

        $code = strtoupper(trim($model->code));
        $user = RegisterModel::findOne(['id' => $userId]);
        if (!$user) {
            App::$app->session->setFlash('error', 'User not found. Please register again.');
            $response->redirect('/register');
            return;
        }

        if (!$user->verification_expires_at || strtotime($user->verification_expires_at) < time()) {
            App::$app->session->setFlash('error', 'Verification code expired. Please request a new one.');
            $response->redirect('/verify/resend');
            return;
        }

        if (!password_verify($code, (string)$user->verification_code)) {
            App::$app->session->setFlash('error', 'Invalid verification code.');
            return $this->render('verify/index', ['model' => $model]);
        }

        $stmt = App::$app->db->prepare("
            UPDATE users 
            SET status = 1, verification_code = NULL, verification_expires_at = NULL 
            WHERE id = :id
        ");
        $stmt->bindValue(':id', $user->id);
        $stmt->execute();

        App::$app->session->remove('user_id_pending');
        App::$app->session->setFlash('success', 'Account verified. Please log in.');
        $response->redirect('/login');
        return;
    }

    return $this->render('verify/index', ['model' => $model]);
    }

    public function resend(Request $request, Response $response)
    {
        $userId = App::$app->session->get('user_id_pending');

        if (!$userId) {
            App::$app->session->setFlash('error', 'No pending verification session. Please register again.');
            $response->redirect('/register');
            return;
        }

        $user = RegisterModel::findOne(['id' => $userId]);
        if (!$user) {
            App::$app->session->setFlash('error', 'User not found. Please register again.');
            $response->redirect('/register');
            return;
        }

        // Prevent spamming — store resend timestamp in session
        $lastResend = App::$app->session->get('last_resend_time');
        if ($lastResend && (time() - $lastResend < 60)) {
            App::$app->session->setFlash('error', 'Please wait a minute before requesting a new code.');
            $response->redirect('/verify');
            return;
        }

        // ✅ Update resend timestamp
        App::$app->session->set('last_resend_time', time());

        // Generate and send new code
        EmailService::sendVerificationCode($user, 'register');

        App::$app->session->setFlash('success', 'A new verification code has been sent to your email.');
        $response->redirect('/verify');
    }

}