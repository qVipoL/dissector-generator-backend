<?php

include_once dirname(__FILE__) . '/../util/QueryParam.php';
include_once dirname(__FILE__) . '/Model.php';


class Dissector extends Model
{
    public $id;
    public $userId;
    public $userName;
    public $name;
    public $description;
    public $code;
    public $fields;
    public $createdAt;
    public $updatedAt;

    public function __construct($db)
    {
        parent::__construct($db, 'Dissectors');
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
                d.fields,
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
                d.fields,
                d.createdAt,
                d.updatedAt
            FROM ' . $this->table . ' AS d
            JOIN Users AS u 
            ON d.userId = u.id
            WHERE d.id = :id
            LIMIT 0,1;
        ', array(new QueryParam(':id', $id)));

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if (!$row) throw new Exception('Dissector not found');

        $this->id = $id;
        $this->userId = $row['userId'];
        $this->userName = $row['userName'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->code = $row['code'];
        $this->fields = $row['fields'];
        $this->createdAt = $row['createdAt'];
        $this->updatedAt = $row['updatedAt'];

        return $this;
    }

    public function create($data)
    {
        $result = $this->executeQuery('
            INSERT INTO ' . $this->table . '
            SET userId = :userId,
                name = :name,
                description = :description,
                code = :code,
                fields = :fields;
        ', array(
            new QueryParam(':userId', htmlspecialchars(strip_tags($data->userId))),
            new QueryParam(':name', htmlspecialchars(strip_tags($data->name))),
            new QueryParam(':description', htmlspecialchars(strip_tags($data->description))),
            new QueryParam(':code', $data->code),
            new QueryParam(':fields', json_encode($data->fields))
        ));

        if ($result == false) throw new Exception('Could not save the dissector to db');
    }

    public function update($id, $data)
    {
        $result = $this->executeQuery('
            UPDATE ' . $this->table . '
            SET
                name = :name,
                description = :description,
                code = :code,
                fields = :fields
            WHERE id = :id;
        ', array(
            new QueryParam(':id', $id),
            new QueryParam(':name', htmlspecialchars(strip_tags($data->name))),
            new QueryParam(':description', htmlspecialchars(strip_tags($data->description))),
            new QueryParam(':code', $data->code),
            new QueryParam(':fields', json_encode($data->fields))
        ));

        if ($result == false) throw new Exception('Could not update the dissector');
    }

    public function delete($id)
    {
        $result = $this->executeQuery('
            DELETE FROM ' . $this->table . '
            WHERE id = :id;
        ', array(new QueryParam(':id', $id)));

        if ($result == false) throw new Exception('Could not delete dissector');
    }
}
