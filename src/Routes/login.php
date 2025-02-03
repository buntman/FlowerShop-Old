<?php

use App\Controllers\LoginController;
use App\Router;


$router = new Router();
$router->get('/', LoginController::class, 'login');
$router->get('/login', LoginController::class, 'login');
$router->dispatch();

?>
