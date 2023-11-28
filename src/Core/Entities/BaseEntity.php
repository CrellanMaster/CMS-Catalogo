<?php

namespace Crellan\App\Core\Entities;

use Crellan\App\Infra\Database\DatabaseConnection;

abstract class BaseEntity
{
    public function __construct()
    {
        $this->db = new DatabaseConnection();
    }

    protected $table;
    protected $db;
    protected $id;
    protected $created_at;
    protected $updated_at;

    public function save()
    {
        $this->db->connect();
        $attributes = get_class_vars($this::class);
        $ignoreAttributes = ['id', 'table', 'db'];
        $attributes = array_diff_key($attributes, array_flip($ignoreAttributes));
        $query = "UPDATE {$this->table} SET ";
        foreach ($attributes as $key => $attribute) {
            if (array_key_last($attributes) == $key) {
                $query .= "{$key} = :{$key} ";
            } else {
                $query .= "{$key} = :{$key} , ";
            }
        }
        $query .= "WHERE id = :id";
        var_dump($query);
        $stmt = $this->db->connection->prepare($query);
        foreach ($attributes as $key => $attribute) {
            $stmt->bindValue(":{$key}", $this->{$key});
        }
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();
        $this->db->close();
    }
}
