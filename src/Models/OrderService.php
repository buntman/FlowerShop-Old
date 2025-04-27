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
}
