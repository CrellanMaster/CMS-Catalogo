<?php

namespace Crellan\App\Infra\Database;

class DatabaseConnection
{
    private $host = "localhost";
    private $dbname = "dri_cms";
    private $username = "root";
    private $password = "";
    /** @var \PDO $connection */
    private $connection;

    public function __construct()
    {
    }

    public function connect()
    {
        try {
            $this->connection = new \PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
