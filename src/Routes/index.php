<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\InventoryController;

$router = new Router();
$router->get('/login', LoginController::class, 'login');
$router->get('/register', RegisterController::class, 'register');
$router->get('/inventory', InventoryController::class, 'inventory');
$router->post('/login', LoginController::class, 'userLogin');
$router->post('/register', RegisterController::class, 'userRegister');
$router->dispatch();
