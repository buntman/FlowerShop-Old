<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\ImageController;
use App\Models\productService;
use App\Config\database;

class ProductController extends Controller
{
    public function add()
    {
        $this->render("add");
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
        $db = new database();
        $product = new productService($data, $db, $image_dir);
        $product->saveProduct();
        header("Location: /inventory");
        exit();
    }

    public function cancel()
    {
        header("Location: /inventory");
        exit();
    }
}
