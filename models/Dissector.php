<?php

class Dissector
{
    private $conn;
    private $table = 'Dissectors';

    public $id;
    public $userId;
    public $user;
    public $name;
    public $description;
    public $code;
    public $createdAt;
    public $updatedAt;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function executeQuery($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getAll()
    {
        return $this->executeQuery('
            SELECT d.id,
                d.userId,
                u.userName,
                d.name,
                d.description,
                d.code,
                d.createdAt,
                d.updatedAt
            FROM ' . $this->table . ' AS d
            JOIN Users AS u 
            ON d.userId = u.id
            ORDER BY d.createdAt DESC;
        ');
    }

    public function getById($id)
    {
        return $this->executeQuery('
            SELECT d.id,
                d.userId,
                u.userName,
                d.name,
                d.description,
                d.code,
                d.createdAt,
                d.updatedAt
            FROM ' . $this->table . ' AS d
            WHERE d.id = ' . $id . '
            JOIN Users AS u 
            ON d.userId = u.id
            ORDER BY d.createdAt DESC;
        ');
    }
}
