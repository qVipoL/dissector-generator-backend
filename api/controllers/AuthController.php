<?php

include_once dirname(__FILE__) . '/../../config/Database.php';
include_once dirname(__FILE__) .  '/../../models/Auth.php';

class AuthController
{
    private $auth;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->auth = new Auth($db);
    }

    public function login()
    {
        try {
            $data = json_decode(file_get_contents("php://input"));

            $user = $this->auth->login($data);

            session_start();
            $_SESSION['userId'] = $user->id;

            echo json_encode(array(
                'success' => true,
                'message' => 'Login successful'
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }

    public function logout()
    {
        session_destroy();

        echo json_encode(array(
            'success' => false,
            'message' => 'Logout successful'
        ));
    }

    public function register()
    {
        try {
            $data = json_decode(file_get_contents("php://input"));

            $this->auth->register($data);

            echo json_encode(array(
                'success' => true,
                'message' => 'Registration successful'
            ));
        } catch (Exception $err) {
            echo json_encode(array(
                'success' => false,
                'message' => $err->getMessage()
            ));
        }
    }
}
