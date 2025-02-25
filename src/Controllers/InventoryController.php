<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\inventoryService;
use App\Config\database;

class InventoryController extends Controller
{
    public function inventory()
    {
        $db = new database();
        $stocks = new inventoryService($db);
        $this->render("inventory", ['stocks' => $stocks->display()]);
    }
}
