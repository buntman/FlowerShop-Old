<?php

namespace App\Routes;

use App\Routes\Router;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\InventoryController;
use App\Controllers\ProductController;
use App\Controllers\ReportsController;
use App\Controllers\AccountManagementController;
use App\Controllers\DashboardController;
use App\Controllers\NotificationController;
use App\Middleware\AuthenticateUser;
use App\Middleware\RedirectIfAuthenticated;
use App\Config\database;

$db = new database();

$router = new Router($db);

$router->get('/login', LoginController::class, 'login', RedirectIfAuthenticated::class);
$router->get('/register', RegisterController::class, 'register', RedirectIfAuthenticated::class);

$router->post('/login', LoginController::class, 'userLogin');
$router->post('/register', RegisterController::class, 'userRegister');

$router->post('/logout', LoginController::class, 'logout');

//inventory routes
$router->get('/admin-inventory', InventoryController::class, 'inventory', AuthenticateUser::class);
$router->post('/admin-inventory', InventoryController::class, 'getFirstProduct', AuthenticateUser::class);
$router->get('/admin-inventory/products', ProductController::class, 'productCard', AuthenticateUser::class);
$router->post('/admin-inventory/products', ProductController::class, 'createProduct');
$router->post('/admin-inventory/item-details', InventoryController::class, 'getProductDetails');
$router->post('/admin-inventory/edit/item', InventoryController::class, 'getProductDetails');
$router->post('/admin-inventory/edit/update-item', InventoryController::class, 'updateProductDetails');
$router->post('/admin-inventory/delete', InventoryController::class, 'deleteProduct');

//account-management routes
$router->get('/admin-manage-account', AccountManagementController::class, 'getAccountManagement');
$router->get('/admin-reports', ReportsController::class, 'getReports');

//designer routes
$router->get('/designer-dashboard', DashboardController::class, 'getDashboard');
$router->get('/designer-notification', NotificationController::class, 'getNotification');


$router->dispatch();
