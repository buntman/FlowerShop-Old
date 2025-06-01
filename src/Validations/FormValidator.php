<?php

namespace App\Validations;

class FormValidator
{
    private $data;
    private $EmployeeLoginFields = ['username', 'password'];
    private $EmployeeRegisterFields = ['first_name', 'last_name', 'email', 'contact_number', 'username', 'password'];
    private $userLoginFields = ['email', 'password'];
    private $userRegisterFields = ['email', 'password', 'confirm_password'];
    private $editProfileFields = ['name', 'contact_number'];
    private $errors = [];

    public function __construct($post)
    {
        $this->data = $post;
    }

    public function validateUserLogin(): bool
    {
        return $this->validateUserLoginFields();
    }

    public function validateUserRegister(): bool
    {
        if (!$this->validateUserRegisterFields() or !$this->validateEmail() or !$this->validatePassword()) {
            return false;
        }
        return true;
    }

    public function validateEmployeeRegister(): bool
    {
        if (!$this->validateEmployeeRegisterFields() or !$this->validateEmail() or !$this->validateUsername() or !$this->validatePassword()) {
            return false;
        }
        return true;
    }

    public function validateEmployeeLogin(): bool
    {
        return $this->validateEmployeeLoginFields();
    }

    public function validateUserProfile(): bool
    {
        if (!$this->validateProfileFields() or !$this->validateProfileName() or !$this->validateProfileContactNumber()) {
            return false;
        }
        return true;
    }

    private function validateProfileFields(): bool
    {
        foreach ($this->editProfileFields as $field) {
            if (empty($this->data[$field])) {
                switch ($field) {
                    case 'name':
                        $this->errors['error'] = "Invalid input. Please try again.";
                        break;
                    case 'contact_number':
                        $this->errors['error'] = "Invalid input. Please try again.";
                        break;
                }
            }
        }
        return empty($this->errors);
    }

    private function validateProfileName(): bool
    {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $this->data['name'])) {
            $this->errors['error'] = "Invalid input. Please try again.";
        }
        return empty($this->errors);
    }

    private function validateProfileContactNumber(): bool
    {
        if (!preg_match('/^\d{11}$/', $this->data['contact_number'])) {
            $this->errors['error'] = "Invalid input. Please enter exactly 11 digits.";
        }
        return empty($this->errors);
    }

    private function validateEmployeeLoginFields(): bool
    {
        foreach ($this->EmployeeLoginFields as $field) {
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


    private function validateEmployeeRegisterFields(): bool
    {
        foreach ($this->EmployeeRegisterFields as $field) {
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
        return empty($this->errors);
    }

    private function validateLastName(): bool
    {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $this->data['last_name'])) {
            $this->errors['last_name'] = "Only letters and white space allowed";
        }
        return empty($this->errors);
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
        } elseif (isset($this->data['confirm_password']) && $this->data['password'] != $this->data['confirm_password']) { //for mobile side
            $this->errors['password'] = "Passwords does not match.";
        }
        return empty($this->errors);
    }

    private function validateUserLoginFields(): bool
    {
        foreach ($this->userLoginFields as $field) {
            if (empty($this->data[$field])) {
                switch ($field) {
                    case 'email':
                        $this->errors['email'] = "{$field} is required.";
                        break;
                    case 'password':
                        $this->errors['password'] = "{$field} is required.";
                        break;
                }
            }
        }
        return empty($this->errors);
    }

    private function validateUserRegisterFields(): bool
    {
        foreach ($this->userRegisterFields as $field) {
            if (empty($this->data[$field])) {
                switch ($field) {
                    case 'email':
                        $this->errors['email'] = "{$field} is required.";
                        break;
                    case 'password':
                        $this->errors['password'] = "{$field} is required.";
                        break;
                    case 'confirm_password':
                        $this->errors['confirm_password'] = "{$field} is required.";
                        break;
                }
            }
        }
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
