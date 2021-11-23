<?php

header('Access-Control-Allow_origin: *');
header('Content-Type: application/json');

include_once dirname(__FILE__) . '/../../controllers/DissectorController.php';

$controller = new DissectorController();
$controller->delete();
