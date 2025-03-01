<?php

namespace App\Validations;

class FormValidator
{
    private $data;
    private $loginFields = ['username', 'password'];
    private $registerFields = ['first_name', 'last_name', 'email', 'contact_number', 'username', 'password'];
    private $errors = [];

    public function __construct($post)
    {
        $this->data = $post;
    }

    public function validateRegister(): bool
    {
        if (!$this->validateRegisterFields() or !$this->validateUsername() or !$this->validatePassword()) {
            return false;
        }
        return true;
    }

    public function validateLogin(): bool
    {
        return $this->validateLoginFields();
    }


    private function validateLoginFields(): bool
    {
        foreach ($this->loginFields as $field) {
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


    private function validateRegisterFields(): bool
    {
        foreach ($this->registerFields as $field) {
            if (empty($this->data[$field])) {
                switch ($field) {
                    case 'first_name':
                        $this->errors['first_name'] = "{$field} is required.";
                        break;
                    case 'last_name':
                        $this->errors['last_name'] = "{$field} is required.";
                        break;
                    case 'email':
                        $this->errors['email'] = "{$field} is required.";
                        break;
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


    private function validateFirstName(): bool
    {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $this->data['first_name'])) {
            $this->errors['first_name'] = "Only letters and white space allowed";
        }
    }

    private function validateLastName(): bool
    {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $this->data['last_name'])) {
            $this->errors['last_name'] = "Only letters and white space allowed";
        }
    }

    private function validateEmail(): bool
    {
        if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format";
        }
        return empty($this->errors);
    }

    private function validateUsername(): bool
    {
        if (!preg_match("/^[a-zA-Z]*$/", $this->data['username'])) {
            $this->errors['username'] = "Only letters are allowed.";
        } elseif (strlen($this->data['username']) < 6 || strlen($this->data['username']) > 12) {
            $this->errors['username'] = "Username must be 6-12 characters long.";
        }
        return empty($this->errors);
    }

    private function validatePassword(): bool
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


    public function getErrors(): array
    {
        return $this->errors;
    }
}
