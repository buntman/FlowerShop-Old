<?php

class authenticate
{
    private $data;
    private $connect;

    public function __construct($postData, $connect)
    {
        $this->data = $postData;
        $this->connect = $connect;
    }

    public function authenticateRegistration()
    {
        $this->authenticateUsername();
    }


    public function authenticateLogin()
    {
        $this->authenticatePassword();
    }



    private function authenticateUsername()
    {
        $username = $this->data['username'];
        $sql = "SELECT * FROM Employees WHERE username = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $username);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            throw new Exception("Username is already taken.");
        }
    }


    private function authenticatePassword()
    {
        $username = $this->data['username'];
        $password = $this->data['password'];
        $sql = "SELECT * FROM Employees WHERE username = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $username);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (!$row) {
            throw new Exception("Invalid input. Please try again.");
        }

        if (password_verify($password, $hashed_password)) {
            header("Location: home.php");
        } else {
            throw new Exception("Invalid input. Please try again.");
        }
    }

}
