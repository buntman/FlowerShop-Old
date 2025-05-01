<?php

namespace App\Middleware;

class AuthenticateAdmin
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /employee/login");
            exit();
        }

        if ($_SESSION['user_role'] != 'ADMIN') {
            header("Location: /designer/dashboard");
            exit();
        }
    }
}
