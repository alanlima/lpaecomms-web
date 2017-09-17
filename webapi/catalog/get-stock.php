<?php

    require('../../app-lib.php');

    allowGetOnly();
    allowCORS();

    use App\WebApiControllers\StockController;

    $stockController = new StockController;
   
    ob_clean();
    
    header('Content-type: application/json');

    echo json_encode($stockController->getAvailableStock());