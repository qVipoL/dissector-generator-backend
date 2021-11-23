<?php

class Dissector
{
    private $conn;
    private $table = 'Dissectors';

    public $id;
    public $userId;
    public $userName;
    public $name;
    public $description;
    public $code;
    public $createdAt;
    public $updatedAt;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function executeQuery($query, $param = null)
    {
        $stmt = $this->conn->prepare($query);

        if ($param != null)
            $stmt->bindParam(1, $param);

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
        $result = $this->executeQuery('
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
            WHERE d.id = ?
            ORDER BY d.createdAt DESC
            LIMIT 0,1;
        ', $id);

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if (!$row) throw new Exception('Dissector not found');

        $this->id = $id;
        $this->userId = $row['userId'];
        $this->userName = $row['userName'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->code = $row['code'];
        $this->createdAt = $row['createdAt'];
        $this->updatedAt = $row['updatedAt'];

        return $this;
    }
}
