<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\InventoryController;
use App\Middleware\Auth;
use App\Middleware\Admin;

$router = new Router();
$router->get('/login', LoginController::class, 'login', Admin::class);
$router->get('/register', RegisterController::class, 'register', Admin::class);
$router->get('/inventory', InventoryController::class, 'inventory', Auth::class);
$router->post('/login', LoginController::class, 'userLogin');
$router->post('/register', RegisterController::class, 'userRegister');
$router->get('/logout', LoginController::class, 'logout');
$router->dispatch();
