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

    public function save()
    {
        $this->saveUser();
    }

    private function saveUser()
    {
        $email = $this->data['email'];
        $password = $this->data['password'];
        $encrypted_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(email, password) VALUES(?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ss', $email, $encrypted_pass);
        mysqli_stmt_execute($sql_statement);
    }

    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users where email = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $email);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $user = mysqli_fetch_assoc($result);
        return $user;
    }
}
