<?php

namespace App\Middleware;

class AuthenticateDesigner
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SESSION['user_role'] != 'DESIGNER') {
            header("Location: /admin-inventory");
            exit();
        }
    }
}
