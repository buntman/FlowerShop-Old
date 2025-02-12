<?php

namespace App\Controllers;

use App\Controllers\Controller;

class InventoryController extends Controller
{
    public function inventory()
    {
        $this->render("inventory");
    }
}
