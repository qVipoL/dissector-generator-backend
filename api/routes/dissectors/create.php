<?php

header('Access-Control-Allow_origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../controllers/DissectorController.php';

$controller = new DissectorController();
$controller->create();
