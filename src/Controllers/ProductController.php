<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\ImageController;
use App\Models\ProductService;
use App\Config\database;

class ProductController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function productCard()
    {
        $this->render("product");
    }

    public function createProduct()
    {
        $data = $_POST;
        $file = $_FILES;
        $upload = new ImageController($file);
        if (!$upload->validateFile()) {
            $this->render("add", ['errors' => $upload->getErrors()]);
            return;
        }
        $upload->uploadFile();
        $image_dir = $upload->getTargetDirectory();
        $product = new ProductService($data, $this->db->getConnection(), $image_dir);
        $product->saveProduct();
        header("Location: /admin-inventory");
        exit();
    }
}
