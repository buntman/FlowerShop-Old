<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Config\JwtConfig;
use App\Models\OrderService;
use App\Models\InventoryService;

class OrderController extends Controller
{
    private $order_service;
    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializaOrderService();
    }

    private function initializaOrderService()
    {
        $this->order_service = new OrderService($this->db->getConnection());
    }

    public function fetchItemsToCheckOut()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $items = $this->order_service->fetchItemsToCheckOut($user_id);
        echo json_encode($items);
    }

    public function addOrderDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        if (!$json) {
            echo json_encode(["success" => false, "message" => "Missing json body!"]);
            return;
        }
        $data = json_decode($json, false);
        if (empty($data->payment_method)) {
            echo json_encode(["success" => false, "message" => "Missing payment method!"]);
            return;
        }
        if (empty($data->total_price)) {
            echo json_encode(["success" => false, "message" => "Missing total price!"]);
            return;
        }
        if (empty($data->pickup_date)) {
            echo json_encode(["success" => false, "message" => "Missing pickup date!"]);
            return;
        }
        if (empty($data->pickup_time)) {
            echo json_encode(["success" => false, "message" => "Missing pickup time!"]);
            return;
        }
        $user_id = JwtConfig::getInstance()->getUserId();
        $order_id = $this->order_service->addOrderDetails($data, $user_id);
        if (!isset($data->items) || !is_array($data->items)) {
            echo json_encode(["success" => false, "message" => "Missing or invalid items field!"]);
            return;
        }
        $items = $data->items;
        $inventory_service = new InventoryService($this->db->getConnection());
        foreach ($items as $item) {
            $product = $inventory_service->findProductByName($item->product_name);
            $this->order_service->addOrderItems($order_id, $product['id'], $item->quantity);
        }
        echo json_encode(["success" => true, "message" => "Ordered successfully!"]);
    }

    public function fetchOrderDetails()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $order_details = $this->order_service->fetchOrderDetailsOfUser($user_id);
        echo json_encode($order_details);
    }


    public function updatePickedUpOrderStatus()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $this->order_service->updatePickedUpOrderStatus($data->order_id);
    }
}
