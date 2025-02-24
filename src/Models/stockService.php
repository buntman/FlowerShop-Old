<?php

namespace App\Models;

use App\Config\database;

class stockService
{
    private $connect;


    public function __construct(database $db)
    {
        $this->connect = $db->getConnection();
    }


    public function display()
    {
        return $this->queryStocks();
    }


    private function queryStocks()
    {
        $sql = "SELECT * FROM Bouquet";
        $result = mysqli_query($this->connect, $sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
}
