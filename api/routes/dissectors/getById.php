<?php

header('Access-Control-Allow_origin: *');
header('Content-Type: application/json');

include_once dirname(__FILE__) . '/../../controllers/DissectorController.php';
include_once dirname(__FILE__) . '/../../../util/Routes.php';

Routes::authorizedRoute();

$controller = new DissectorController();
$controller->getById();
