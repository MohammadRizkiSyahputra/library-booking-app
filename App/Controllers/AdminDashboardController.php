<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware\AdminMiddleware;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware());
    }

    public function index()
    {
        $this->setTitle('Admin Dashboard | Library Booking App');
        $this->setLayout('main');
        return $this->render('admin/dashboard', [
            'stats' => [],
            'roomUsage' => [],
            'bookings' => []
        ]);
    }
}
