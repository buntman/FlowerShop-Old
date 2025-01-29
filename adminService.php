<?php

class adminService
{
    private $connect;


    public function __construct($connect)
    {
        $this->connect = $connect;
    }


    public function display()
    {
        return $this->queryBouquet();
    }


    private function queryBouquet()
    {
        $sql = "SELECT * FROM Bouquet";
        $result = mysqli_query($this->connect, $sql);
        $rows= mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
}


