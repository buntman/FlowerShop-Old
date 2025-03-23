<?php

namespace App\Models;

class productService
{
    private $data;
    private $connect;
    private $name;
    private $stock;
    private $description;
    private $price;
    private $image_directory;
    private $product_type;
    private $admin_id;


    public function __construct($postData, $connection, $relative_path)
    {
        $this->data = $postData;
        $this->connect = $connection;
        $this->image_directory = $relative_path;
        $this->initializeProperties();
    }


    private function initializeProperties()
    {
        $this->name = $this->data['name'];
        $this->stock = $this->data['stock'];
        $this->description = $this->data['description'];
        $this->price = $this->data['price'];
        $this->product_type = $this->data['product_type'];
        $this->admin_id = $_SESSION['user_id'];
    }


    public function saveProduct()
    {
        if ($_SESSION['user_role'] != 'ADMIN') {
            http_response_code(403);
            exit("Unauthorized Action");
        }

        $sql = "INSERT INTO products(name,description, stock_quantity, price, image_path, product_type, admin_id) VALUES(?,?,?,?,?,?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ssidssi', $this->name, $this->description, $this->stock, $this->price, $this->image_directory, $this->product_type, $this->admin_id);
        mysqli_stmt_execute($sql_statement);
    }


}
