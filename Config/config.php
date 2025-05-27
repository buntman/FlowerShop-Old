<?php

namespace App\Config;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();


return [
    'database' => [
        'host' => $_ENV['DB_HOST'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'db' => $_ENV['DB_NAME'],
    ],
    'twig' => [
        'twig_template' => __DIR__. '/../' . $_ENV['TWIG_TEMPLATE_PATH'],
    ],
    'jwt' => [
        'secret_key' => $_ENV['SECRET_KEY'],
    ],
    'paymongo' => [
        'payment_key' => $_ENV['PAYMENT_KEY'],
    ],
];
