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
        if ($user) {
            if ($user->passkey == $passkey) {
                return $user;
            } else {
                return false;
            }
        }
    }

    public function GenerateSession($user)
    {
        /** @var User $user */
        session_start();
        $_SESSION["user_name"] = $user->username;
        $_SESSION["user_email"] = $user->email;
        $_SESSION["user_role"] = $user->role;
        $_SESSION["authenticated"] = true;
        $_SESSION["expire_time"] = 1800;
        $_SESSION["last_activity"] = time();
        header("Location: /admin/panel/ ");
    }

    public function getUserByEmail($email)
    {
        try {
            $query = "SELECT * FROM users WHERE email=:email";
            $stmt = $this->db->connection->prepare($query);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $result = $stmt->fetchObject("Crellan\App\Core\Entities\Admin\User");
            } else {
                throw new \Exception("Usuário não encontrado");
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function verifySessionToLogin()
    {
        if (session_status() != PHP_SESSION_NONE) {
            session_unset();
            session_destroy();
        }
    }


    public function checkSession()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['last_activity']) && isset($_SESSION["expire_time"]) && ((time() - $_SESSION["last_activity"]) > $_SESSION["expire_time"])) {
            session_unset();
            session_destroy();
        }
    }
}
