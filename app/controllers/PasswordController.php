<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\App;
use App\Models\RegisterModel;
use App\Models\ForgotPasswordModel;
use App\Models\ResetPasswordModel;
use App\Services\EmailService;

class PasswordController extends Controller
{
    public function forgot(Request $request, Response $response)
    {
        $this->setLayout('auth');
        $this->setTitle('Forgot Password | Library Booking App');

        $model = new ForgotPasswordModel();

        if ($request->isPost()) {
            $model->loadData($request->getBody());

            // Validate input (email required & valid)
            if (!$model->validate()) {
                return $this->render('forgot/index', ['model' => $model]);
            }

            // Find user using RegisterModel
            $user = RegisterModel::findOne(['email' => trim($model->email)]);
            if (!$user) {
                App::$app->session->setFlash('error', 'Email not found.');
                return $this->render('forgot/index', ['model' => $model]);
            }

            // Send OTP code for reset
            EmailService::sendVerificationCode($user, 'reset_password');

            App::$app->session->set('reset_user_id', $user->id);
            App::$app->session->setFlash('success', 'A reset code has been sent to your email.');
            $response->redirect('/reset');
            return;
        }

        return $this->render('forgot/index', ['model' => $model]);
    }

    public function reset(Request $request, Response $response)
    {
        $this->setLayout('auth');
        $this->setTitle('Reset Password | Library Booking App');

        $model = new ResetPasswordModel();

        $userId = App::$app->session->get('reset_user_id');
        if (!$userId) {
            App::$app->session->setFlash('error', 'Session expired. Please request a new reset.');
            $response->redirect('/forgot');
            return;
        }

        $user = RegisterModel::findOne(['id' => $userId]);
        if (!$user) {
            App::$app->session->setFlash('error', 'User not found.');
            $response->redirect('/forgot');
            return;
        }

        if ($request->isPost()) {
            $model->loadData($request->getBody());

            // Validate fields before further checking
            if (!$model->validate()) {
                return $this->render('reset/index', ['model' => $model]);
            }

            // Verify code from email
            if (!EmailService::verifyCode($user, trim($model->code))) {
                App::$app->session->setFlash('error', 'Invalid or expired code.');
                return $this->render('reset/index', ['model' => $model]);
            }

            // Hash new password & update
            $hash = password_hash($model->password, PASSWORD_DEFAULT);
            $stmt = App::$app->db->prepare("UPDATE users SET password = :pass WHERE id = :id");
            $stmt->bindValue(':pass', $hash);
            $stmt->bindValue(':id', $user->id);
            $stmt->execute();

            // Clear verification code
            EmailService::clearCode($user);

            App::$app->session->remove('reset_user_id');
            App::$app->session->setFlash('success', 'Password reset successful! You can now log in.');
            $response->redirect('/login');
            return;
        }

        return $this->render('reset/index', ['model' => $model]);
    }
}
