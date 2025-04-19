<?php

namespace App\Models;

class CartService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function addProductToCart($product, $user_id): bool
    {
        $check_query = "SELECT * FROM cart where product_id = ?";
        $check_query_statement_prepare = mysqli_prepare($this->connect, $check_query);
        mysqli_stmt_bind_param($check_query_statement_prepare, 'i', $product['id']);
        mysqli_stmt_execute($check_query_statement_prepare);
        $result = mysqli_stmt_get_result($check_query_statement_prepare);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            return false;
        }
        $sql = "INSERT INTO cart(user_id, product_id,price) VALUES(?,?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'iid', $user_id, $product['id'], $product['price']);
        mysqli_stmt_execute($sql_statement);
        return true;
    }

    public function getProductsFromCart($user_id)
    {
        $sql = "SELECT p.name AS product_name,
                p.image_path,
                c.quantity,
                c.price,
                c.id AS cart_id
                FROM cart c
                INNER JOIN
                products p ON c.product_id = p.id
                WHERE
                c.status = 'active' and c.user_id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $user_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function calculateTotalPrice($user_id)
    {
        $sql = "SELECT SUM(c.price * c.quantity) AS total_price FROM cart c WHERE c.status = 'active' and user_id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $user_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $cart_price = mysqli_fetch_assoc($result);
        return $cart_price;
    }

    public function deleteCartById($cart_id)
    {
        $sql = "DELETE FROM cart where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $cart_id);
        mysqli_stmt_execute($sql_statement);
    }

    public function updateItemQuantity($cart_id, $quantity)
    {
        $sql = "UPDATE cart SET quantity = ? where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ii', $quantity, $cart_id);
        mysqli_stmt_execute($sql_statement);
    }
}
