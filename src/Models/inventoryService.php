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
        $sql = "SELECT * FROM flower";
        $result = mysqli_query($this->connect, $sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
}
