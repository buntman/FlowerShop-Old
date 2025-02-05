<?php

namespace App\Routes;
use App\Controllers\HomeController;
use App\Router;

require '../src/Models/Database.php';

$router = new Router();
$router->get('/', HomeController::class, 'login');
$router->get('/login', HomeController::class, 'login');
$router->dispatch();

?>
