<?php

require('../../app-lib.php');

allowPostOnly();

use App\WebApiControllers\CustomerController;

$customerController = new CustomerController;

$requestJson = json_decode(file_get_contents('php://input'));

$result = $customerController->login(
    $requestJson->login,
    $requestJson->password
);

header('Content-Type: application/json');

if($result) {
    echo json_encode(array(
        'authenticated' => true
    ));
} else {
    echo json_encode(array(
        'authenticated' => false
    ));
}