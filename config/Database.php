<?php

class Database
{
    // Db Params
    private $host = 'localhost';
    private $db_name = 'dissector-generator';
    private $username = 'root';
    private $password = 'password';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            echo 'Connection Error: ' . $err->getMessage();
        }

        return $this->conn;
    }
}
