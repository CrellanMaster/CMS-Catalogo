<?php

namespace Crellan\App\Core\Entities\Admin;

use Crellan\App\Core\Entities\BaseEntity;

class User extends BaseEntity
{
    protected $table = "users";
    public $username;
    public $passkey;
    public $email;
    public $ip;
    public $token;
    public $last_login;
}
