<?php

require('../../app-lib.php');

allowCORS();

allowPostOnly();

use App\WebApiControllers\CustomerController;

$customerController = new CustomerController;

$requestJson = json_decode(file_get_contents('php://input'));

$result = $customerController->login(
    $requestJson->login,
    $requestJson->password
);

header('Content-Type: application/json');

if($result > 0) {
    echo json_encode(array(
        'authenticated' => true,
        'customerId' => $result
    ));
} else {
    echo json_encode(array(
        'authenticated' => false
    ));
}