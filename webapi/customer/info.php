<?php

    require('../../app-lib.php');

    allowCORS();

    allowPostOnly();

    use App\WebApiControllers\CustomerController;

    $customerController = new CustomerController;

    $requestJson = json_decode(file_get_contents('php://input'));

    header('Content-type: application/json');
    
    echo json_encode($customerController->info($requestJson->id));

