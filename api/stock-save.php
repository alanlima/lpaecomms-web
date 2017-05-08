<?php
require('../app-lib.php');

use App\Controllers\StockController;
use App\Models\Stock;

$stockController = new StockController;
$stock = new Stock;

isset($_POST['txtStockID'])? $stock->id = $_POST['txtStockID'] : $stock->id = "";
isset($_POST['txtStockName'])? $stock->productName = $_POST['txtStockName'] : $stock->productName = "";
isset($_POST['txtStockDesc'])? $stock->productDescription = $_POST['txtStockDesc'] : $stock->productDescription = "";
isset($_POST['txtStockOnHand'])? $stock->onHand = $_POST['txtStockOnHand'] : $stock->onHand = "0";
//isset($_POST['txtStockImage'])? $stockImage = $_POST['txtStockImage'] : $stockImage = "";
isset($_POST['txtStockPrice'])? $stock->price = $_POST['txtStockPrice'] : $stock->price = "0.00";
isset($_POST['txtStatus'])? $stock->status = $_POST['txtStatus'] : $stock->status = "";

$wasSuccessful = $stock->id != "" ?
                  $stockController->update($stock->id, $stock) :
                  $stockController->insert($stock);
                  
ob_clean(); // clean the output buffer

header('Content-type: application/json');
echo json_encode(array(
  'wasSuccessful' => $wasSuccessful,
  'message' => $wasSuccessful ? 'Stock successfully save.' : 'Fail on save the stock.'
));
