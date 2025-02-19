<?php

namespace App\Validations;

class FormValidator
{
    private $data;
    private $requireFields = ['username', 'password'];
    private $errors = [];

    public function __construct($post)
    {
        $this->data = $post;
    }

    public function sanitize() :array
    {
        foreach ($this->data as $key => $data) {
            $this->data[$key] = htmlspecialchars(stripslashes(trim($data)));
        }
        return $this->data;
    }

    public function validateRegister():bool
    {
        if(!$this->validateRequiredFields() or !$this->validateUsername() or !$this->validatePassword()) {
            return false;
        }
        return true;
    }

    public function validateLogin():bool
    {
        return $this->validateRequiredFields();
    }


    private function validateRequiredFields():bool
    {
        foreach ($this->requireFields as $field) {
            if (empty($this->data[$field])) {
                switch ($field) {
                    case 'username':
                        $this->errors['username'] = "{$field} is required.";
                        break;
                    case 'password':
                        $this->errors['password'] = "{$field} is required.";
                        break;
                }
            }
        }
        return empty($this->errors);
    }

    private function validateUsername():bool
    {
        if (!preg_match("/^[a-zA-Z]*$/", $this->data['username'])) {
            $this->errors['username'] = "Only letters are allowed.";
        } elseif (strlen($this->data['username']) < 6 || strlen($this->data['username']) > 12) {
            $this->errors['username'] = "Username must be 6-12 characters long.";
        }
        return empty($this->errors);
    }

    private function validatePassword():bool
    {
        if (!preg_match('/([a-z]{1,})/', $this->data['password'])) {
            $this->errors['password'] = "Password must have one lowercase letter.";
        } elseif (!preg_match('/([A-Z]{1,})/', $this->data['password'])) {
            $this->errors['password'] = "Password must have one uppercase letter.";
        } elseif (!preg_match('/([\d]{1,})/', $this->data['password'])) {
            $this->errors['password'] = "Password must have one digit.";
        } elseif (strlen($this->data['password']) < 8 || strlen($this->data['password']) > 16) {
            $this->errors['password'] = "Password must be 8-16 characters long.";
        }
        return empty($this->errors);
    }


    public function getErrors():array
    {
        return $this->errors;
    }
}
