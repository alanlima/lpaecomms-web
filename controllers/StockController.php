<?php
namespace App\Controllers;

use App\Database\ConnectionManager;
use App\Models\Stock;

class StockController{
  private $connManager;

  function __construct(){
    global $connManager;
    $connManager = new ConnectionManager();
  }

  function getByFilter($filter){
    global $connManager;

    $link = $connManager->createLink();

    $handle = $link->prepare("SELECT * FROM lpa_stock WHERE
                              lpa_stock_status <> 'i' AND
                              (lpa_stock_ID LIKE :filter
                                OR lpa_stock_name LIKE :filter)");

    $handle->execute(array(':filter' => "%$filter%"));

    $result = $handle->fetchAll(\PDO::FETCH_OBJ);

    $stocks = array();

    foreach ($result as $s) {
      $stocks[] = new Stock(array(
        'id' => $s->lpa_stock_ID,
        'productName' => $s->lpa_stock_name,
        'productDescription' => $s->lpa_stock_desc,
        'onHand' => $s->lpa_stock_onhand,
        'price' => $s->lpa_stock_price,
        'status' => $s->lpa_stock_status
      ));
    }

    return $stocks;
  }

  function getById($id){
    global $connManager;

    $link = $connManager->createLink();

    $link->prepare('SELECT * FROM lpa_stock WHERE lpa_stock_ID = :id LIMIT 1');

    $handle = $link->execute(array(':id' => $id));

    if( $handle->rowCount > 0 ){
      $s = $handle->fetch(\PDO::FETCH_OBJ);
      return new Stock(array(
        'id' => $s->lpa_stock_ID,
        'productName' => $s->lpa_stock_name,
        'productDescription' => $s->lpa_stock_desc,
        'onHand' => $s->lpa_stock_onhand,
        'price' => $s->lpa_stock_price,
        'status' => $s->lpa_stock_status
      ));
    } else {
      return null;
    }
  }

  function update($id, $stock){
    global $connManager;

    $link = $connManager->createLink();

    $link->prepare('UPDATE lpa_stock SET
                     lpa_stock_desc = :productDescription
                    ,lpa_stock_onhand = :onHand
                    ,lpa_stock_price = :price
                    ,lpa_stock_status = :status
                    ,lpa_stock_name = :productName
                    WHERE lpa_stock_ID = :id');

    $rowCount = $link.execute($stock);

    return $rowCount > 0;
  }
}
 ?>
