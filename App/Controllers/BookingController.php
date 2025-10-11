<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Middleware\AuthMiddleware;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function create(Request $request, Response $response)
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }

    public function myBookings()
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }
}
