<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\LoginController;


$router = new Router();
$router->get('/login', LoginController::class, 'login');
$router->post('/login', LoginController::class, 'userLogin');
$router->dispatch();

?>
