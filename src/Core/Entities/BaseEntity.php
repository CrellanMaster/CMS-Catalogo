<?php

namespace Crellan\App\Core\Entities;

abstract class BaseEntity
{
    public function __construct()
    {
    }
    protected $id;
    protected $created_at;
    protected $updated_at;
}
