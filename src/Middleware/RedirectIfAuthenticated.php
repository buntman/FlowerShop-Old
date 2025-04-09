<?php

namespace App\Middleware;

class RedirectIfAuthenticated
{
    public function handle()
    {

        if (isset($_SESSION['user_id']) and $_SESSION['user_role'] == 'ADMIN') {
            header("Location: /admin-inventory");
            exit();
        }

        if (isset($_SESSION['user_id']) and $_SESSION['user_role'] == 'DESIGNER') {
            header("Location: /designer-dashboard");
            exit();
        }
    }
}
