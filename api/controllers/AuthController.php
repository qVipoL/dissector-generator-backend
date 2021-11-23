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

    public function register()
    {
    }

    public function login()
    {
    }

    public function logout()
    {
    }
}
