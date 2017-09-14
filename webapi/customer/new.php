<?php

require('../../app-lib.php');

allowPostOnly();

use App\WebApiControllers\CustomerController;

$customerController = new CustomerController;

$requestJson = json_decode(file_get_contents('php://input'));

$result = $customerController->newCustomer($requestJson);

header('Content-Type: application/json');

if($result) {
    echo json_encode(array(
        'wasSuccessfull' => true,
        'message' => 'Customer created.'
    ));
} else {
    echo json_encode(array(
        'wasSuccessfull' => false,
        'message' => 'Customer can not be created.'
    ));
}
