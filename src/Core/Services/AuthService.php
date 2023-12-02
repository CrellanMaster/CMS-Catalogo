<?php

namespace Crellan\App\Core\Services;

use Crellan\App\App\Models\Admin\UserModel;
use Crellan\App\Infra\Database\DatabaseConnection;
use Crellan\App\Core\Entities\Admin\User;
use Crellan\App\Core\Enums\AuthMessageEnum;
use Crellan\App\Core\Exceptions\AuthException;

class AuthService
{

    private $db;
    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }
    public function AuthUser($email, $passkey)
    {
        $dataResult = $this->getUserByEmail($email);
        try {
            if ($dataResult->authenticate) {
                if (password_verify($passkey, $dataResult->user->passkey)) {
                    return (object)["authenticate" => true, "user" => $dataResult->user];
                } else {
                    throw new AuthException(AuthMessageEnum::ERR_FAILED_LOGIN);
                }
            } else {
                throw new AuthException(AuthMessageEnum::ERR_FAILED_LOGIN);
            }
        } catch (AuthException $e) {
            return (object)["authenticate" => false, "message" => $e->getMessage()];
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
            $user = new UserModel();
            $dataResult = $user->getUserByEmail($email);
            if (!property_exists($dataResult, "error") && $dataResult->rowCount > 0) {
                return  (object)["authenticate" => true, "user" => $dataResult->user];
            } else {
                throw new AuthException(AuthMessageEnum::ERR_FAILED_LOGIN);
            }
        } catch (AuthException $e) {
            return (object) ["authenticate" => false, "message" => $e->getMessage()];
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
            header("Location: /admin/login/");
        }

        if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] != true) {
            session_unset();
            session_destroy();
            header("Location: /admin/login/");
        };
    }
}
