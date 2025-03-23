<?php

namespace App\Middleware;

class AuthenticateUser
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    }
}
