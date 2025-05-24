<?php

namespace App\Models;

class EmployeeService
{
    private $data;
    private $connect;


    public function __construct($connection, $postData = null)
    {
        $this->connect = $connection;
        $this->data = $postData;
    }


    public function save()
    {
        $this->saveUser();
    }


    private function saveUser()
    {
        $first_name = $this->data['first_name'];
        $last_name = $this->data['last_name'];
        $username = $this->data['username'];
        $password = $this->data['password'];
        $email = $this->data['email'];
        $contact_number = $this->data['contact_number'];
        $encrypted_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO employees(first_name, last_name, username, password, email, contact_number) VALUES(?,?,?,?,?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ssssss', $first_name, $last_name, $username, $encrypted_pass, $email, $contact_number);
        mysqli_stmt_execute($sql_statement);
    }


    public function findByUsername()
    {
        $username = $this->data['username'];
        $sql = "SELECT * FROM employees WHERE username = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $username);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        return mysqli_fetch_assoc($result);
    }

    public function fetchEmployeeName()
    {
        $id = $_SESSION['user_id'];
        $sql = "SELECT first_name FROM employees where id = ? LIMIT 1";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $name = mysqli_fetch_assoc($result);
        return $name['first_name'];
    }
}
