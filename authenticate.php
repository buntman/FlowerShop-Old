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

    public function authenticateAccount()
    {
        $this->authenticateUsername();
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

}
