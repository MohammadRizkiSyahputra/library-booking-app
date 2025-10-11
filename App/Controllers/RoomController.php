<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Middleware\AuthMiddleware;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index()
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }

    public function view(Request $request)
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }
}
