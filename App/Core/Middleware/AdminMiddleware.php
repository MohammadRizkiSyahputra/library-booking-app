<?php

namespace App\Core\Middleware;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\App;

class AdminMiddleware extends Middleware
{
    public function handle(Request $request, Response $response): bool
    {
        $user = App::$app->user;
        
        if (!$user || $user->role !== 'admin') {
            App::$app->session->setFlash('error', 'Access denied. Admin only.');
            $response->redirect('/dashboard');
            return false;
        }
        
        return true;
    }
}
