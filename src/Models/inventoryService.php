<?php

namespace App\Models;

use App\Config\database;

class inventoryService
{
    private $connect;


    public function __construct(database $db)
    {
        $this->connect = $db->getConnection();
    }


    public function display()
    {
        return $this->queryFlowers();
    }


    private function queryFlowers()
    {
        $admin_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM flower where admin_id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $admin_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
}
