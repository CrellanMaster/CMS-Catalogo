<?php

namespace Crellan\App\App\Controllers;

use Crellan\App\Infra\Database\DatabaseConnection;

abstract class BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = new DatabaseConnection();
        $this->db->connect();
    }
}
