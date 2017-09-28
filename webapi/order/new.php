<?php

require('../../app-lib.php');

allowCORS();

allowPostOnly();

use App\WebApiControllers\OrderController;

$orderController = new OrderController;

$requestJson = json_decode(file_get_contents('php://input'));

$invoiceId = $orderController->create($requestJson);

header('Content-Type: application/json');

if($invoiceId > 0) {
    echo json_encode(array(
        'wasSuccessfull' => true,
        'message' => 'Invoice created',
        'invoiceId' => $invoiceId
    ));
} else {
    echo json_encode(array(
        'wasSuccessfull' => false,
        'message' => 'Fail to create the invoice'
    ));
}
