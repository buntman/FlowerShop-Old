<?php

namespace App\Middleware;

class Admin
{
    public function handle()
    {
        if (isset($_SESSION['user_id']) and $_SESSION['user_role'] == 'ADMIN') {
            header("Location: /inventory");
            exit();
        }
    }
}
?>

