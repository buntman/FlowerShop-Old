<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\IndexController;
use App\Controllers\LoginController;


$router = new Router();
$router->get('/login', IndexController::class, 'login');
$router->post('/login', LoginController::class, 'userLogin');
$router->dispatch();

?>
