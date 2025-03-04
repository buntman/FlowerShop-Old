<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\inventoryService;
use App\Config\database;

class InventoryController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function inventory()
    {
        $stocks = new inventoryService($this->db->getConnection());
        $this->render("inventory", ['stocks' => $stocks->display()]);
    }
}
