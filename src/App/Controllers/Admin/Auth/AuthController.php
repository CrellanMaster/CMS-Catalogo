<?php

namespace Crellan\App\App\Controllers\Admin\Auth;

use Crellan\App\Core\Services\AuthService;
use Crellan\App\Infra\Database\DatabaseConnection;

class AuthController
{
    private $db;
    public function __construct()
    {
        $this->db = new DatabaseConnection();
        $this->db->connect();
    }

    public function index()
    {
        $auth = new AuthService($this->db);
        $user = $auth->getUserByEmail("email2@email.com.br");
        var_dump($user);
        $user->email = "email@email.com.br";
        $user->username = "fracassado";
        $user->save();
        $this->db->close();
    }
}
