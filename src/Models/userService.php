<?php

namespace App\Models;

use App\Config\database;

class userService
{
    private $data;
    private $connect;


    public function __construct($postData, database $db)
    {
        $this->data = $postData;
        $this->connect = $db->getConnection();
    }


    public function save()
    {
        $this->saveUser();
    }


    private function saveUser()
    {
        $username = $this->data['username'];
        $password = $this->data['password'];
        $encrypted_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Employees(username, password) VALUES(?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ss', $username, $encrypted_pass);
        mysqli_stmt_execute($sql_statement);
    }


    public function findByUsername()
    {
        $username = $this->data['username'];
        $sql = "SELECT * FROM Employees WHERE username = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $username);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        return mysqli_fetch_assoc($result);
    }
}






