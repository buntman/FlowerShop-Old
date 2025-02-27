<?php

namespace App\Controllers;

class ImageController
{
    private $data;
    private $target_file;
    private $file_size;
    private $image_file_type;
    private $errors = [];
    private $file_name;
    private $target_dir;
    private $relative_path;

    public function __construct($files)
    {
        $this->data = $files;
        $this->initializeProperties();
    }

    private function initializeProperties()
    {
        $this->file_name = basename($this->data['image']['name']);
        $this->target_dir = __DIR__ . "/../../public/images/inventory-items/";
        $this->target_file = $this->target_dir . basename($this->file_name);
        $this->image_file_type = strtolower(pathinfo($this->target_file, PATHINFO_EXTENSION));
        $this->file_size = $this->data['image']['size'];
        $this->relative_path = "/images/inventory-items/" . $this->file_name;
    }

    public function uploadFile()
    {
        return $this->imageUpload();
    }


    public function validateFile(): bool
    {
        if (!$this->validateFileExists() or !$this->validateFileSize() or !$this->validateFileType()) {
            return false;
        }
        return true;
    }

    private function imageUpload()
    {
        $temp_name = $this->data['image']['tmp_name'];
        move_uploaded_file($temp_name, $this->target_file);
    }

    private function validateFileExists(): bool
    {
        if (file_exists($this->target_file)) {
            $this->errors['file_exists'] = "Sorry, file already exists";
        }
        return empty($this->errors);
    }


    private function validateFileSize(): bool
    {
        if ($this->file_size > 500000) {
            $this->errors['file_size'] = "Sorry, file is too large";
        }
        return empty($this->errors);
    }

    private function validateFileType(): bool
    {
        $valid_file =  ["png", "jpg", "jpeg", "gif"];
        if (!in_array($this->image_file_type, $valid_file)) {
            $this->errors['file_type'] = "Sorry, only JPG, JPEG, PNG, and GIF are supported.";
        }
        return empty($this->errors);
    }

    public function getTargetDirectory()
    {
        return $this->relative_path;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }
}
