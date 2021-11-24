<?php

class Model
{
    protected $conn;
    protected $table;

    public function __construct($db, $table)
    {
        $this->conn = $db;
        $this->table = $table;
    }

    protected function executeQuery($query, $queryParams = null)
    {
        $stmt = $this->conn->prepare($query);

        if ($queryParams != null)
            foreach ($queryParams as $queryParam)
                $stmt->bindParam($queryParam->param, $queryParam->value);

        if (!$stmt->execute()) return false;

        return $stmt;
    }
}
