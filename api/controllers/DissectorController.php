<?php

include_once dirname(__FILE__) . '/../../config/Database.php';
include_once dirname(__FILE__) .  '/../../models/Dissector.php';

class DissectorController
{
    private $dissector;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->dissector = new Dissector($db);
    }

    public function getAll()
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

    public function getById()
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
                'fields' => $result->fields,
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

    public function convert()
    {
        try {
            $data = json_decode(file_get_contents("php://input"));

            shell_exec('echo \'' . strip_tags($data->code) . '\' >> ../../assets/in.lua');
            $luaCode = shell_exec('../../assets/diss-gen ../../assets/in.lua');
            shell_exec('rm ../../assets/in.lua');

            echo json_encode(array(
                'success' => true,
                'luaCode' => $luaCode
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }

    public function create()
    {
        try {
            $data = json_decode(file_get_contents("php://input"));

            $data->userId = $_SESSION['userId'];
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

    public function update()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : die();
            $data = json_decode(file_get_contents("php://input"));
            $userId = $_SESSION['userId'];

            shell_exec('echo \'' . strip_tags($data->code) . '\' >> ../../assets/in.lua');
            $code = shell_exec('../../assets/diss-gen ../../assets/in.lua');
            shell_exec('rm ../../assets/in.lua');

            $data->code = $code;
            $this->dissector->update($userId, $id, $data);

            echo json_encode(array(
                'success' => true,
                'message' => 'Dissector updated successfully'
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }

    public function delete()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : die();
            $userId = $_SESSION['userId'];

            $this->dissector->delete($userId, $id);

            echo json_encode(array(
                'success' => true,
                'message' => 'Dissector delete successfully'
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }
}
