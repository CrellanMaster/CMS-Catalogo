<?php

namespace Crellan\App\Core\Entities;

use Crellan\App\Infra\Database\DatabaseConnection;

abstract class BaseEntity
{
    public function __construct()
    {
    }

    public $table;
    public $baseIgnoreAttributes = ['id', 'table', 'baseIgnoreAttributes'];
    public $id;
    public $created_at;
    public $updated_at;


    public function create()
    {
    }

    public function save()
    {
    }

    public static function getConstructArgs()
    {
    }

    public static function getNamespace()
    {
    }
}
