<?php

class Routes
{
    private static function isAuthorized()
    {
        session_start();
        return $_SESSION['userId'] ? true : false;
    }

    public static function authorizedRoute()
    {
        if (!Routes::isAuthorized()) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Authorized only route'
            ));
            die();
        }
    }

    public static function unauthorizedRoute()
    {
        if (Routes::isAuthorized()) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Unauthorized only route'
            ));
            die();
        }
    }
}
