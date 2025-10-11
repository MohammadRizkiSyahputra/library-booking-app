<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Core\Middleware\AuthMiddleware;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index()
    {
        $user = App::$app->user;

        if ($user->role === 'mahasiswa' && $user->status === 'active' && !$user->kubaca_img) {
            App::$app->session->setFlash('warning', 'Warning! Your account has not been verified, please upload kubaca image.');
        }

        $this->setTitle('Dashboard | Library Booking App');
        $this->setLayout('main');
        return $this->render('user/dashboard', [
            'user' => $user,
            'stats' => [],
            'bookings' => []
        ]);
    }
}
