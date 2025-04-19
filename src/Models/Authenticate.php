<?php

namespace App\Models;

class Authenticate
{
    private $data;
    private $connect;
    private $errors = [];

    public function __construct($postData, $connection)
    {
        $this->data = $postData;
        $this->connect = $connection;
    }

    public function authenticateUserLogin(): bool
    {
        return $this->authenticateUserPassword();
    }

    public function authenticateUserRegistration(): bool
    {
        return $this->authenticateUserEmail();
    }

    public function authenticateEmployeeRegistration(): bool
    {
        return $this->authenticateEmployeeUsername();
    }

    public function authenticateEmployeeLogin(): bool
    {
        return $this->authenticateEmployeePassword();
    }


    private function authenticateEmployeeUsername(): bool
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


    private function authenticateEmployeePassword(): bool
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

    private function authenticateUserEmail(): bool
    {
        $email = $this->data['email'];
        $sql = "SELECT * FROM users where email = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $email);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $this->errors['email'] = "Email is already taken.";
        }
        return empty($this->errors);
    }

    private function authenticateUserPassword(): bool
    {
        $email = $this->data['email'];
        $password = $this->data['password'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $email);
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
