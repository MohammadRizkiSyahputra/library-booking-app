<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Middleware\AdminMiddleware;

class AdminRoomController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware());
    }

    public function index()
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }

    public function create(Request $request, Response $response)
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }

    public function edit(Request $request, Response $response)
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }

    public function delete(Request $request, Response $response)
    {
        echo "Fitur ini akan diimplementasi nanti terima kasih :)";
        exit;
    }
}
