<?php

namespace App\Models;

class ManageAccountsService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function getEmployees()
    {
        $sql = "SELECT * FROM employees where role != 'ADMIN'";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function deleteAccount($id)
    {
        $sql = "DELETE FROM employees where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $id);
        mysqli_stmt_execute($sql_statement);
    }
}
