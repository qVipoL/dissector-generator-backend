<?php

include_once dirname(__FILE__) . '/../util/QueryParam.php';
include_once dirname(__FILE__) . '/Model.php';

class Auth extends Model
{
    public $id;
    public $userName;
    public $email;
    public $isOwner;
    public $createdAt;

    public function __construct($db)
    {
        parent::__construct($db, 'Users');
    }

    public function login($data)
    {
        $result = $this->executeQuery('
            SELECT id,
                userName,
                email,
                isOwner,
                createdAt
            FROM ' . $this->table . ' AS u
            WHERE email = :email 
            AND   password = :password
            LIMIT 0, 1;
        ', array(
            new QueryParam(':password', $data->password),
            new QueryParam(':email', $data->email)
        ));

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if (!$row) throw new Exception('Invalid email or password');

        $this->id = $row['id'];
        $this->userName = $row['userName'];
        $this->email = $row['email'];
        $this->isOwner = $row['isOwner'];
        $this->createdAt = $row['createdAt'];

        return $this;
    }

    public function register($data)
    {
        $result = $this->executeQuery('
            INSERT INTO ' . $this->table . '
            SET userName = :userName,
                email = :email,
                password = :password;
        ', array(
            new QueryParam(':userName', strip_tags($data->userName)),
            new QueryParam(':email', strip_tags($data->email)),
            new QueryParam(':password', strip_tags($data->password))
        ));

        if ($result == false) throw new Exception('Could not register user');
    }
}
