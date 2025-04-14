<?php

namespace App\Models;

class GalleryService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function getBouquets()
    {
        $sql = "SELECT * FROM products where product_type = 'bouquet'";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
}
