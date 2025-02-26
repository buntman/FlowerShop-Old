<?php

namespace App\Controllers;

class ImageController
{
    private $data;
    private $target_file;
    private $file_size;
    private $image_file_type;
    private $errors = [];

    public function __construct($files)
    {
        $this->data = $files;
    }

    public function uploadFile()
    {
        return $this->imageUpload();
    }


    public function validateFile(): bool
    {
        if (!$this->fileExists() or !$this->fileSize() or !$this->fileType()) {
            return false;
        }
        return true;
    }

    private function imageUpload()
    {
        $file_name = basename($this->data['image']['name']);
        $temp_name = $this->data['image']['tmp_name'];
        $this->file_size = $this->data['image']['size'];
        $target_dir = "/../../public/images/inventory-items/";
        $this->target_file = $target_dir . basename($file_name);
        $this->image_file_type = strtolower(pathinfo($this->target_file, PATHINFO_EXTENSION));
        move_uploaded_file($temp_name, $this->target_file);
    }

    private function fileExists(): bool
    {
        if (file_exists($this->target_file)) {
            $this->errors["file_exist"] = "Sorry, file already exists";
        }
        return empty($this->errors);
    }


    private function fileSize(): bool
    {
        if ($this->file_size > 500000) {
            $this->errors["file_size"] = "Sorry, file is too large";
        }
        return empty($this->errors);
    }

    private function fileType(): bool
    {
        $valid_file =  ["png", "jpg", "jpeg", "gif"];
        if (!in_array($valid_file, $valid_file)) {
            $this->errors["file_type"] = "Sorry, only JPG, JPEG, PNG, and GIF are supported.";
        }
        return empty($this->errors);
    }


    public function getErrors(): array
    {
        return $this->errors;
    }
}
