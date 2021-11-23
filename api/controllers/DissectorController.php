<?php

include_once '../../../config/Database.php';
include_once '../../../models/Dissector.php';

class DissectorController
{
    private $dissector;

    function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->dissector = new Dissector($db);
    }

    function getAll()
    {
        $response = array();
        $response['dissectors'] = array();

        $result = $this->dissector->getAll();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $dissector_item = array(
                'id' => $id,
                'userId' => $userId,
                'userName' => $userName,
                'name' => $name,
                'code' => $code,
                'fields' => $fields,
                'createdAt' => $createdAt,
                'updatedAt' => $updatedAt
            );

            array_push($response['dissectors'], $dissector_item);
        }

        echo json_encode($response);
    }

    function getById()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : die();

            $result = $this->dissector->getById($id);

            $response = array(
                'id' => $result->id,
                'userId' => $result->userId,
                'userName' => $result->userName,
                'name' => $result->name,
                'description' => $result->description,
                'code' => $result->code,
                'createdAt' => $result->createdAt,
                'updatedAt' => $result->updatedAt
            );

            echo json_encode(array(
                'success' => true,
                'dissector' => $response
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }

    function create()
    {
        try {
            $data = json_decode(file_get_contents("php://input"));

            shell_exec('echo \'' . strip_tags($data->code) . '\' >> ../../assets/in.lua');
            $code = shell_exec('../../assets/diss-gen ../../assets/in.lua');
            shell_exec('rm ../../assets/in.lua');

            $data->$code = $code;
            $this->dissector->create($data);

            echo json_encode(array(
                'success' => true,
                'message' => 'Dissector created successfully'
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }
}
