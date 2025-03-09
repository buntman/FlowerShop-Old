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
        $this->render("inventory", ['stocks' => $stocks->fetchProducts()]);
    }

    public function displayDetails() {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $name = $data->product_name;
        $stocks = new inventoryService($this->db->getConnection());
        $result = $stocks->fetchProductDetails($name);
        echo json_encode($result);
    }


    public function removeProduct() {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $name = $data->product_name;
        $stocks = new inventoryService($this->db->getConnection());
        $stocks->deleteProduct($name);
        echo json_encode(["success" => true, "message" => "Deleted Successfully"]);
    }
}
