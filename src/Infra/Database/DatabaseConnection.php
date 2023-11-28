<?php

namespace Crellan\App\Infra\Database;

class DatabaseConnection
{
    private $host = "localhost";
    private $dbname = "dri_cms";
    private $username = "root";
    private $password = "";
    /** @var \PDO $connection */
    public $connection;

    public function __construct()
    {
    }

    public function connect()
    {
        try {
            $this->connection = new \PDO("mysql:host=" . $this->host . ";port=3360;dbname=" . $this->dbname, $this->username, $this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function close()
    {
        $this->connection = null;
    }
}
