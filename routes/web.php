<?php

namespace App\Routes;

use App\Controllers\SiteController;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Controllers\VerifyController;
use App\Controllers\PasswordController;

$app->router->get('/', [AuthController::class, 'login']);
$app->router->get('/dashboard', [SiteController::class, 'dashboard']);
$app->router->get('/books', [SiteController::class, 'books']);
$app->router->get('/bookings', [SiteController::class, 'booking']);
$app->router->get('/about', [SiteController::class, 'about']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/profile', [ProfileController::class, 'index']);
$app->router->get('/verify', [VerifyController::class, 'verify']);
$app->router->get('/resend', [VerifyController::class, 'resend']);
$app->router->get('/forgot', [PasswordController::class, 'forgot']);
$app->router->get('/reset', [PasswordController::class, 'reset']);

$app->router->post('/reset', [PasswordController::class, 'reset']);
$app->router->post('/forgot', [PasswordController::class, 'forgot']);
$app->router->post('/resend', [VerifyController::class, 'resend']);
$app->router->post('/verify', [VerifyController::class, 'verify']);
$app->router->post('/upload-kubaca', [ProfileController::class, 'uploadKubaca']);
$app->router->post('/logout', [AuthController::class, 'logout']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/register', [AuthController::class, 'register']);