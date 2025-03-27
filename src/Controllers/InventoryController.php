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
        $inventoryService = new inventoryService($this->db->getConnection());
        $this->render("admin-inventory", ['stocks' => $inventoryService->getProducts(), 'initial_item' => $inventoryService->getFirstProduct(), 'total_products' => $inventoryService->getNumberOfProducts()]);
    }

    public function getProductDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $inventoryService = new inventoryService($this->db->getConnection());
        $result = $inventoryService->getProductDetails($id);
        echo json_encode($result);
    }


    public function deleteProduct()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $inventoryService = new inventoryService($this->db->getConnection());
        $inventoryService->deleteProduct($id);
        echo json_encode(["success" => true, "message" => "Deleted Successfully"]);
    }

    public function getFirstProduct()
    {
        header("Content-Type: application/json");
        $inventoryService = new inventoryService($this->db->getConnection());
        $product = $inventoryService->getFirstProduct();
        echo json_encode(["success" => true, "product" => $product]);
    }


    public function updateProductDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $inventoryService = new inventoryService($this->db->getConnection());
        $id = $data['currentProductId'];
        $name = $data['name'];
        $stock = $data['stock'];
        $description = $data['description'];
        $price = $data['price'];
        $inventoryService->updateProductDetails($id, $name, $stock, $description, $price);
        echo json_encode(["success" => true, "message" => "Updated Successfully!"]);
    }
}
