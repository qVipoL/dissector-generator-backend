<?php

header('Access-Control-Allow_origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once dirname(__FILE__) . '/../../controllers/AuthController.php';
include_once dirname(__FILE__) . '/../../../util/Routes.php';

Routes::unauthorizedRoute();

$controller = new AuthController();
$controller->register();
