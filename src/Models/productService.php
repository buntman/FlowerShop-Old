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
    }


    public function saveProduct()
    {
        $sql = "INSERT INTO Flower(flowerName,description, stock_quantity, price, image_path) VALUES(?,?,?,?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement,'ssids', $this->flower_name, $this->flower_description, $this->flower_stock, $this->flower_price, $this->image_directory);
        mysqli_stmt_execute($sql_statement);
    }


}
