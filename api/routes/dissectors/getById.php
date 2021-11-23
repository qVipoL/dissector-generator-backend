<?php

header('Access-Control-Allow_origin: *');
header('Content-Type: application/json');

include_once '../../controllers/DissectorController.php';

$controller = new DissectorController();
$controller->getById();
