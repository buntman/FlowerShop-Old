<?php

namespace App\Models;

class UserService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }
}
