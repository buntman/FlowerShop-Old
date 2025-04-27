<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Config\JwtConfig;
use App\Models\OrderService;

class OrderController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }


    public function fetchItemsToCheckOut()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $order_service = new OrderService($this->db->getConnection());
        $items = $order_service->fetchItemsToCheckOut($user_id);
        echo json_encode($items);
    }
}
