<?php

namespace App\Controllers;

use App\Controllers\Controller;

class InventoryController extends Controller
{
    public function inventory()
    {
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $this->render("inventory");
    }
}
