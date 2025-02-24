<?php

namespace App\Middleware;

class Admin
{
    public function handle()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /inventory");
            exit();
        }
    }
}
?>

