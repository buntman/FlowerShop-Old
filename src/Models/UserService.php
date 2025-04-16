<?php

namespace App\Models;

class UserService
{
    private $data;
    private $connect;
    private $errors = [];

    public function __construct($postData, $connection)
    {
        $this->data = $postData;
        $this->connect = $connection;
    }

    public function authenticateLogin(): bool
    {
        return $this->authenticateUser();
    }

    private function authenticateUser(): bool
    {
        $email = $this->data['email'];
        $password = $this->data['password'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $email);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];
        if (!$row) {
            $this->errors['password'] = "Invalid input. Please try again.";
        }
        if ($password != $db_password) {
            $this->errors['password'] = "Invalid input. Please try again.";
        }
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
