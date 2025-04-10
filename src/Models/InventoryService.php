<?php

namespace App\Models;

class InventoryService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function getProducts()
    {
        $admin_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM products where admin_id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $admin_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function getFirstProduct()
    {
        $admin_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM products where admin_id = ? LIMIT 1";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $admin_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $product = mysqli_fetch_assoc($result);
        return $product;
    }

    public function getProductDetails($id)
    {
        $sql = "SELECT * FROM products where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $product = mysqli_fetch_assoc($result);
        return $product;
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $id);
        mysqli_stmt_execute($sql_statement);
    }

    public function updateProductDetails($id, $name, $stock, $description, $price)
    {
        $sql = "UPDATE products SET name = ?, description = ?, stock_quantity = ?, price = ? where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ssiii', $name, $description, $stock, $price, $id);
        mysqli_stmt_execute($sql_statement);
    }

    public function getNumberOfProducts()
    {
        $sql = "SELECT * FROM products";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
}
