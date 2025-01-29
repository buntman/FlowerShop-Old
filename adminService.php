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
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}


