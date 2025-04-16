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
use App\Controllers\PendingController;
use App\Controllers\UserLoginController;
use App\Controllers\GalleryController;
use App\Controllers\HomeController;
use App\Middleware\AuthenticateAdmin;
use App\Middleware\AuthenticateDesigner;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\JwtAuth;
use App\Config\database;

$db = new database();

$router = new Router($db);

$router->get('/login', LoginController::class, 'login', RedirectIfAuthenticated::class);
$router->get('/register', RegisterController::class, 'register', RedirectIfAuthenticated::class);
$router->post('/user-login', UserLoginController::class, 'userLogin');


$router->post('/login', LoginController::class, 'employeeLogin');
$router->post('/register', RegisterController::class, 'employeeRegister');

$router->post('/logout', LoginController::class, 'logout');

//inventory routes
$router->get('/admin-inventory', InventoryController::class, 'inventory', AuthenticateAdmin::class);
$router->post('/admin-inventory', InventoryController::class, 'getFirstProduct', AuthenticateAdmin::class);
$router->get('/admin-inventory/products', ProductController::class, 'productCard', AuthenticateAdmin::class);
$router->post('/admin-inventory/products', ProductController::class, 'createProduct');
$router->post('/admin-inventory/item-details', InventoryController::class, 'getProductDetails');
$router->post('/admin-inventory/edit/item', InventoryController::class, 'getProductDetails');
$router->post('/admin-inventory/edit/update-item', InventoryController::class, 'updateProductDetails');
$router->post('/admin-inventory/delete', InventoryController::class, 'deleteProduct');

//account-management routes
$router->get('/admin-manage-account', AccountManagementController::class, 'getAccountManagement', AuthenticateAdmin::class);
$router->post('/admin-manage-account/delete-account', AccountManagementController::class, 'deleteAccount');
$router->post('/admin-manage-account/edit-status/activate', AccountManagementController::class, 'activateAccount');
$router->post('/admin-manage-account/edit-status/deactivate', AccountManagementController::class, 'deactivateAccount');
$router->post('/admin-manage-account/edit-status/update', AccountManagementController::class, 'getStatus');

//reports
$router->get('/admin-reports', ReportsController::class, 'getReports', AuthenticateAdmin::class);

//designer routes
$router->get('/designer-dashboard', DashboardController::class, 'getDashboard', AuthenticateDesigner::class);
$router->get('/designer-notification', NotificationController::class, 'getNotification', AuthenticateDesigner::class);

$router->get('/pending-request', PendingController::class, 'getPendingPage');
$router->get('/gallery', GalleryController::class, 'getBouquets', JwtAuth::class);
$router->get('/home', HomeController::class, 'getBouquets', JwtAuth::class);


$router->dispatch();
