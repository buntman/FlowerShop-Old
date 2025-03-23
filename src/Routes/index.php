<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\InventoryController;
use App\Controllers\ProductController;
use App\Middleware\AuthenticateUser;
use App\Middleware\RedirectIfAuthenticated;
use App\Config\database;

$db = new database();

$router = new Router($db);
$router->get('/login', LoginController::class, 'login', RedirectIfAuthenticated::class);
$router->get('/register', RegisterController::class, 'register', RedirectIfAuthenticated::class);
$router->get('/inventory', InventoryController::class, 'inventory', AuthenticateUser::class);
$router->post('/inventory/refresh', InventoryController::class, 'getFirstProduct', AuthenticateUser::class);
$router->get('/inventory/products', ProductController::class, 'productCard', AuthenticateUser::class);
$router->get('/inventory/products/cancel', ProductController::class, 'cancel', AuthenticateUser::class);
$router->post('/inventory/products/add', ProductController::class, 'createProduct');
$router->post('/login', LoginController::class, 'userLogin');
$router->post('/register', RegisterController::class, 'userRegister');
$router->post('/inventory/item', InventoryController::class, 'displayDetails');
$router->post('/inventory/item/edit', InventoryController::class, 'displayDetails');
$router->post('/inventory/item/edit/submit', InventoryController::class, 'editProductDetails');
$router->post('/delete', InventoryController::class, 'removeProduct');
$router->post('/logout', LoginController::class, 'logout');
$router->dispatch();
