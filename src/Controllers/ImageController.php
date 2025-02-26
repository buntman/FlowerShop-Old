<?php

namespace App\Controllers;

class ImageController
{
    private $data;

    public function __construct($files)
    {
        $this->data = $files;
    }

    public function uploadFile()
    {
        return $this->imageUpload();
    }

    private function imageUpload()
    {
        $file_name = $this->data['image']['name'];
        $temp_name = $this->data['image']['tmp_name'];
        $target_dir = "/home/rgm/phpC/webProjects/FlowerShop/public/images/inventory-items/";
        $target_file = $target_dir . basename($file_name);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($temp_name, $target_file);
    }
}
