<?php

namespace Crellan\App\App\Models\Admin;

use Crellan\App\App\Models\BaseModel;
use Crellan\App\Core\Entities\Admin\User;
use Crellan\App\Core\Enums\AuthMessageEnum;
use Crellan\App\Core\Exceptions\AuthException;
use PDO;

class UserModel extends BaseModel
{

    public function getUserByEmail($email)
    {
        try {
            $this->db->connect();
            $query = "SELECT * FROM users WHERE email=:email";
            $stmt = $this->db->connection->prepare($query);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            $this->db->close();
            if ($stmt->rowCount() > 0) {
                return (object)["rowCount" => $stmt->rowCount(), "user" => $stmt->fetchObject(User::getNamespace(), User::getConstructArgs())];
            } else {
                return (object)["rowCount" => 0, "user" => null];
            }
        } catch (\PDOException $e) {
            return (object) ["error" => true, "message" => $e->getMessage()];
        }
    }

    public function getUserByToken($token)
    {
        try {
            $this->db->connect();
            $query = "SELECT * FROM users WHERE token=:token";
            $stmt = $this->db->connection->prepare($query);
            $stmt->bindParam("token", $token);
            $stmt->execute();
            $this->db->close();
            if ($stmt->rowCount() > 0) {
                return (object)["rowCount" => $stmt->rowCount(), "user" => $stmt->fetchObject(User::getNamespace(), User::getConstructArgs())];
            } else {
                return (object)["rowCount" => 0, "user" => null];
            }
        } catch (\PDOException $e) {
            return (object) ["error" => true, "message" => $e->getMessage()];
        }
    }
}
