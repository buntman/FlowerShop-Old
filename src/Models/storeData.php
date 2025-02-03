<?php

class store
{
    private $data;
    private $connect;


    public function __construct($postData, $connect)
    {
        $this->data = $postData;
        $this->connect = $connect;
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

        if (mysqli_stmt_execute($sql_statement)) {
            header("Location: home.php");
        }
    }







}
