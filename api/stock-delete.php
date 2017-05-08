<?php
 require('../app-lib.php');

 use App\Controllers\StockController;

 $stockController = new StockController;

 $stockId = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

 ob_clean(); // clean the output buffer

 if ($stockId != "") {
     $stockController->delete($stockId);

     header('Content-Type: application/json');
     echo json_encode(array(
       'wasSuccessful' => true,
       'message' => 'Stock item removed.'
      ));
     exit;
 }

 header('Content-Type: application/json');
 echo(array(
   'wasSuccessful' => false,
   'message' => 'Stock item not found.'
 ));
