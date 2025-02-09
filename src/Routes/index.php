<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;


$router = new Router();
$router->get('/login', HomeController::class, 'login');
$router->post('/login', UserController::class, 'userLogin');
$router->dispatch();

?>
