<?php

namespace Crellan\App\Core\Entities\Admin;

use Crellan\App\Core\Entities\BaseEntity;
use Crellan\App\Core\Enums\AuthMessageEnum;
use Crellan\App\Core\Exceptions\AuthException;
use Crellan\App\App\Models\Admin\UserModel;
use Crellan\App\Core\Services\AuthService;

class User extends BaseEntity
{
    public function __construct($username, $password, $email, $ip, $role)
    {
        $this->username = $username;
        $this->passkey = $password;
        $this->email = $email;
        $this->ip = $ip;
        $this->token = hash("sha256", $this->username . $this->email . $this->ip);
        $this->role = $role;
    }

    public $table = "users";
    public $baseIgnoreAttributes = ['id', 'table', 'last_login', 'baseIgnoreAttributes'];
    public $username;
    public $passkey;
    public $email;
    public $ip;
    public $token;
    public $last_login;
    public $role;

    public function create()
    {
        try {
            $userModel = new UserModel();
            $dataResult = $userModel->getUserByEmail($this->email);
            if (property_exists($dataResult, "error")) {
                throw new \PDOException($dataResult->message);
            } else if ($dataResult->rowCount != 0) {
                return (object) ["error" => true, "message" => AuthMessageEnum::ERR_REGISTER_USER_EMAIL];
            }
            $userModel->create($this);
        } catch (\PDOException $e) {
            return (object)["error" => true, "message" => $e->getMessage()];
        }
    }
    public static function getConstructArgs()
    {
        return ['username', 'password', 'email', 'ip', 'role'];
    }

    public static function getNamespace()
    {
        return "Crellan\App\Core\Entities\Admin";
    }
}
