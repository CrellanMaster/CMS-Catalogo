<?php

namespace Crellan\App\App\Models;

use Crellan\App\Infra\Database\DatabaseConnection;

abstract class BaseModel
{
    public function __construct()
    {
        $this->db = new DatabaseConnection();
    }

    protected $db;

    public function create($user)
    {
        $user->created_at = (new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s');
        $user->updated_at = (new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s');
        $this->db->connect();
        $attributes = get_class_vars(get_class($user));
        $attributes = array_diff_key($attributes, array_flip($user->baseIgnoreAttributes));
        $query = "INSERT INTO {$user->table} ( ";
        foreach ($attributes as $key => $attribute) {
            if (array_key_last($attributes) == $key) {
                $query .= " {$key} )";
            } else {
                $query .= " {$key} ,";
            }
        }
        $query .= " VALUES (";
        foreach ($attributes as $key => $attribute) {
            if (array_key_last($attributes) == $key) {
                $query .= " :{$key} )";
            } else {
                $query .= " :{$key} ,";
            }
        }
        $stmt = $this->db->connection->prepare($query);
        foreach ($attributes as $key => $attribute) {
            $stmt->bindValue($key, $user->{$key});
        }
        $stmt->execute();
        $this->db->close();
    }

    public function save($user)
    {
        $this->db->connect();
        $attributes = get_class_vars(get_class($user));
        $attributes = array_diff_key($attributes, array_flip($user->baseIgnoreAttributes));
        $query = "UPDATE {$user->table} SET ";
        foreach ($attributes as $key => $attribute) {
            if (array_key_last($attributes) == $key) {
                $query .= "{$key} = :{$key} ";
            } else {
                $query .= "{$key} = :{$key} , ";
            }
        }
        $query .= "WHERE id = :id";
        $stmt = $this->db->connection->prepare($query);
        foreach ($attributes as $key => $attribute) {
            $stmt->bindValue(":{$key}", $this->{$key});
        }
        $stmt->bindValue(":id", $user->id);
        $stmt->execute();
        $this->db->close();
    }
}
