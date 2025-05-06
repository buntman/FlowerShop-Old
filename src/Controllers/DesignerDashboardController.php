<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Models\OrderService;

class DesignerDashboardController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getDashboard()
    {
        $order_service = new OrderService($this->db->getConnection());
        $this->render("designer-dashboard", ["orders" => $order_service->fetchPendingOrders()]);
    }

    public function updatePendingOrderStatus()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $order_service = new OrderService($this->db->getConnection());
        $order_service->updatePendingOrderStatus($data->id);
        echo json_encode(["success" => true]);
    }

    public function fetchCompleteOrders()
    {
        header("Content-Type: application/json");
        $order_service = new OrderService($this->db->getConnection());
        $orders = $order_service->fetchCompleteOrders();
        echo json_encode($orders);
    }
}
