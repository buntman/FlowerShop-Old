<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\ImageController;

class ProductController extends Controller
{
    public function add()
    {
        $this->render("add");
    }

    public function createProduct() {
        $file = $_FILES;
        $upload = new ImageController($file);
        if(!$upload->validateFile()) {
            $this->render("add", ['errors' => $upload->getErrors()]);
            return;
        }
        $upload->uploadFile();
        header("Location: /inventory");
        exit();
    }
}
