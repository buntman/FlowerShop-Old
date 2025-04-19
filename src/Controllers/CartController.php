<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\CartService;
use App\Models\InventoryService;
use App\Config\database;
use App\Config\JwtConfig;
use Exception;

class CartController extends Controller
{
    private $cart_service;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initiliazeCartService();
    }

    private function initiliazeCartService()
    {
        $this->cart_service = new CartService($this->db->getConnection());
    }

    public function addProductToCart()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $product_name = $data->name;
        $inventory = new InventoryService($this->db->getConnection());
        $product = $inventory->findProductByName($product_name);
        $user_id = JwtConfig::getInstance()->getUserId();
        if (!$this->cart_service->addProductToCart($product, $user_id)) {
            echo json_encode(['success' => false, 'message' => 'Item is already in cart.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Item successfully added to cart.']);
        }
    }

    public function getProductsFromCart()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $cart_items = $this->cart_service->getProductsFromCart($user_id);
        foreach ($cart_items as &$item) {
            $item['image_path'] = "http://10.0.2.2:8080" . $item['image_path'];
        }
        unset($item);
        echo json_encode($cart_items);
    }

    public function getTotalPrice()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $cart_price = $this->cart_service->calculateTotalPrice($user_id);
        echo json_encode($cart_price);
    }

    public function deleteCartById()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $cart_id = $data->cart_id;
        $this->cart_service->deleteCartById($cart_id);
    }

    public function updateItemQuantity()
    {
        header("Content-Type: application/json");
        try {
            $json = file_get_contents('php://input');
            if (!$json) {
                throw new Exception("Json has no values!");
            }
            $data = json_decode($json, false);
            if (empty($data->cart_id) or empty($data->quantity)) {
                throw new Exception("Cart id and quantity is not found!");
            }
            $this->cart_service->updateItemQuantity($data->cart_id, $data->quantity);
        } catch (Exception $e) {
            error_log(print_r($e->getMessage(), true));
        }
    }
}
