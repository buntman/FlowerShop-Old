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
        $this->render("inventory", ['stocks' => $stocks->fetchProducts(), 'initial_item' => $stocks->fetchFirstProduct(), 'total_products' => $stocks->numberOfProducts()]);
    }

    public function displayDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $stocks = new inventoryService($this->db->getConnection());
        $result = $stocks->fetchProductDetails($id);
        echo json_encode($result);
    }


    public function removeProduct()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $stocks = new inventoryService($this->db->getConnection());
        $stocks->deleteProduct($id);
        echo json_encode(["success" => true, "message" => "Deleted Successfully"]);
    }

    public function getFirstProduct()
    {
        header("Content-Type: application/json");
        $stocks = new inventoryService($this->db->getConnection());
        $product = $stocks->fetchFirstProduct();
        echo json_encode(["success" => true, "product" => $product]);
    }


    public function editProductDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $stocks = new inventoryService($this->db->getConnection());
        $id = $data['currentProductId'];
        $name = $data['name'];
        $stock = $data['stock'];
        $description = $data['description'];
        $price = $data['price'];
        $stocks->updateProductDetails($id, $name, $stock, $description, $price);
        echo json_encode(["success" => true, "message" => "Updated Successfully!"]);
    }
}
