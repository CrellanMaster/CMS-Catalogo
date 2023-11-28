<?php

namespace Crellan\App\Core\Services;

use Crellan\App\Infra\Database\DatabaseConnection;
use Crellan\App\Core\Entities\Admin\User;

class AuthService
{

    private $db;
    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }
    public function AuthUser($email, $passkey)
    {
        $user = $this->getUserByEmail($email);
        password_verify($passkey, $user->password);
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email=:email";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        return $result = $stmt->fetchObject("Crellan\App\Core\Entities\Admin\User");
    }
}
