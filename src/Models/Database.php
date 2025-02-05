<?php

namespace App\Models;

class Database
{
    private $connection;


    private function __construct()
    {
        $db_config = require '../../config/config.php';
        $host = $db_config['database']['host'];
        $user = $db_config['database']['username'];
        $password = $db_config['database']['password'];
        $db = $db_config['database']['db'];
        try {
            $this->connection = new mysqli($host, $user, $password, $db);
            if ($this->connection->connect_error) {
                throw new Exception("Failed to connect to mysql!". $this->connection->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            if ($this->connection && !$this->connection->connect_error) {
                $this->connection->close();
            }
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
