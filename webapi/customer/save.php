<?php

require('../../app-lib.php');

allowPostOnly();

use App\WebApiControllers\CustomerController;

$customerController = new CustomerController;

$requestJson = json_decode(file_get_contents('php://input'));

$result = $customerController->save($requestJson);

header('Content-Type: application/json');

echo json_encode(array(
    'wasSuccessfull' => true,
    'message' => 'Customer saved'
));