<?php

namespace App\Models;

class Database
{
    private $connection;


    public function __construct()
    {
        $db_config = require '/home/rgm/phpC/webProjects/FlowerShop/config/config.php';
        $host = $db_config['database']['host'];
        $user = $db_config['database']['username'];
        $password = $db_config['database']['password'];
        $db = $db_config['database']['db'];
        try {
            $this->connection = new \mysqli($host, $user, $password, $db);
            if ($this->connection->connect_error) {
                throw new \Exception("Failed to connect to mysql!". $this->connection->connect_error);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
