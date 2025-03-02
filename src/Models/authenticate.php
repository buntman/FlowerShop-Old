<?php

namespace App\Models;

use App\Config\database;

class authenticate
{
    private $data;
    private $connect;
    private $errors = [];

    public function __construct($postData, database $db)
    {
        $this->data = $postData;
        $this->connect = $db->getConnection();
    }

    public function authenticateRegistration(): bool
    {
        return $this->authenticateUsername();
    }


    public function authenticateLogin(): bool
    {
        return $this->authenticatePassword();
    }



    private function authenticateUsername(): bool
    {
        $username = $this->data['username'];
        $sql = "SELECT * FROM employees WHERE username = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $username);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $this->errors['username'] = "Username is already taken.";
        }
        return empty($this->errors);
    }


    private function authenticatePassword(): bool
    {
        $username = $this->data['username'];
        $password = $this->data['password'];
        $sql = "SELECT * FROM employees WHERE username = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $username);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        if (!$row) {
            $this->errors['password'] = "Invalid input. Please try again.";
        }
        if (!password_verify($password, $hashed_password)) {
            $this->errors['password'] = "Invalid input. Please try again.";
        }
        return empty($this->errors);
    }


    public function getErrors(): array
    {
        return $this->errors;
    }

}
