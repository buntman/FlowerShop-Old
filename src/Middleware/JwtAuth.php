<?php

namespace App\Middleware;

class JwtAuth
{
    public function handle()
    {
        if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            header('HTTP/1.0 400 Bad Request');
            echo "Access Denied: Authorization token is missing or invalid. Please provide a valid token to access this resource.";
            exit;
        }
    }
}
