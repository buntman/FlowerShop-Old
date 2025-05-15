<?php

namespace App\Models;

use Hashids\Hashids;

class ReportsService
{
    private $connect;
    private $hash_id;

    public function __construct($connection)
    {
        $this->connect = $connection;
        $this->hash_id = new Hashids('', 5);
    }


    public function fetchReports()
    {
        $sql = "SELECT * FROM reports";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($rows as &$row) {
            $row['order_id'] = $this->hash_id->encode($row['order_id']);
        }
        unset($row);
        return $rows;
    }
}
