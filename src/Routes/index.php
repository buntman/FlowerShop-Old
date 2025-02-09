<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;

$router = new Router();
$router->get('/login', LoginController::class, 'login');
$router->get('/register', RegisterController::class, 'register');
$router->post('/login', LoginController::class, 'userLogin');
$router->dispatch();
