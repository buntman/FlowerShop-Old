<?php

namespace App\Validations;

class formValidator
{
    private $data;
    private $requireFields = ['username', 'password'];

    public function __construct($userData)
    {
        $this->data = $userData;
    }

    public function sanitize($arrayData)
    {
        foreach ($arrayData as $key => $data) {
            $arrayData[$key] = htmlspecialchars(stripslashes(trim($data)));
        }
        return $arrayData;
    }

    public function validateRegister()
    {
        $this->validateRequiredFields();
        $this->validateUsername();
        $this->validatePassword();
    }

    public function validateLogin()
    {
        $this->validateRequiredFields();
    }


    private function validateRequiredFields()
    {
        foreach ($this->requireFields as $field) {
            if (empty($this->data[$field])) {
                throw new Exception("{$field} is required.");
            }
        }
    }

    private function validateUsername()
    {
        if (!preg_match("/^[a-zA-Z]*$/", $this->data['username'])) {
            throw new Exception("Only letters are allowed.");
        } elseif (strlen($this->data['username']) < 6 || strlen($this->data['username']) > 12) {
            throw new Exception("Username must be 6-12 characters long.");
        }
    }

    private function validatePassword()
    {
        if (!preg_match('/([a-z]{1,})/', $this->data['password'])) {
            throw new Exception("Password must have one lowercase letter.");
        } elseif (!preg_match('/([A-Z]{1,})/', $this->data['password'])) {
            throw new Exception("Password must have one uppercase letter.");
        } elseif (!preg_match('/([\d]{1,})/', $this->data['password'])) {
            throw new Exception("Password must have one digit.");
        } elseif (strlen($this->data['password']) < 8 || strlen($this->data['password']) > 16) {
            throw new Exception("Password must be 8-16 characters long.");
        }
    }
}
