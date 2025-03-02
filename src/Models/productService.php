<?php

namespace App\Models;

use App\Config\database;

class productService
{
    private $data;
    private $connect;
    private $flower_name;
    private $flower_stock;
    private $flower_description;
    private $flower_price;
    private $image_directory;
    private $admin_id;


    public function __construct($postData, database $db, $relative_path)
    {
        $this->data = $postData;
        $this->connect = $db->getConnection();
        $this->image_directory = $relative_path;
        $this->initializeProperties();
    }


    private function initializeProperties()
    {
        $this->flower_name = $this->data['name'];
        $this->flower_stock = $this->data['stock'];
        $this->flower_description = $this->data['description'];
        $this->flower_price = $this->data['price'];
        $this->admin_id = $_SESSION['user_id'];
    }


    public function saveProduct()
    {
        if($_SESSION['user_role'] != 'ADMIN') {
            http_response_code(403);
            exit("Unauthorized Action");
        }

        $sql = "INSERT INTO flower(flower_name,description, stock_quantity, price, image_path, admin_id) VALUES(?,?,?,?,?,?)"; //link user using findUsername function
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement,'ssidsi', $this->flower_name, $this->flower_description, $this->flower_stock, $this->flower_price, $this->image_directory, $this->admin_id);
        mysqli_stmt_execute($sql_statement);
    }


}
