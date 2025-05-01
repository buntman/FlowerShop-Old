<?php

namespace App\Models;

class OrderService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function fetchItemsToCheckOut($user_id)
    {
        $sql = "SELECT p.name AS product_name,
        c.quantity,
        c.price * c.quantity AS subprice
        FROM cart c
        INNER JOIN
        products p ON c.product_id = p.id
        WHERE c.status = 'active' and c.user_id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function addOrderDetails($order_details, $user_id)
    {
        $sql = "INSERT INTO orders(user_id, payment_method, total_price, pickup_date, pickup_time) VALUES(?,?,?,?,?)";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'isdss', $user_id, $order_details->payment_method, $order_details->total_price, $order_details->pickup_date, $order_details->pickup_time);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($this->connect);
    }

    public function addOrderItems($order_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO order_items(order_id, product_id, quantity) VALUES(?,?,?)";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $order_id, $product_id, $quantity);
        mysqli_stmt_execute($stmt);
    }
}
