<?php

namespace App\Middleware;

class Auth
{
    public function handle()
    {
        if (!isset($_SESSION['user_id']) or $_SESSION['user_role'] != 'ADMIN') {
            header("Location: /login");
            exit();
        }
    }
}
