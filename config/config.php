<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

return [
    'database' => [
        'host' => $_ENV['DB_HOST'],
        'username' => $_ENV['DB_NAME'],
        'password' => $_ENV['DB_PASS'],
        'db' => $_ENV['DB_USER'],
    ],
];
