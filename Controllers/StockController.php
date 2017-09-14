<?php
namespace App\Controllers;

use App\Database\ConnectionManager;
use App\Models\Stock;

class StockController
{
    private $connManager;

    public function __construct()
    {
        global $connManager;
        $connManager = new ConnectionManager();
    }

    public function getByFilter($filter)
    {
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
                'status' => $s->lpa_stock_status,
                'productImage' => $s->lpa_stock_image
            ));
        }

        return $stocks;
    }

    public function getById($id)
    {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('SELECT * FROM lpa_stock WHERE lpa_stock_ID = :id LIMIT 1');

        $handle->execute(array(':id' => $id));

        if ($handle->rowCount() > 0) {
            $s = $handle->fetch(\PDO::FETCH_OBJ);
            return new Stock(array(
        'id' => $s->lpa_stock_ID,
        'productName' => $s->lpa_stock_name,
        'productDescription' => $s->lpa_stock_desc,
        'onHand' => $s->lpa_stock_onhand,
        'price' => $s->lpa_stock_price,
        'status' => $s->lpa_stock_status,
        'productImage' => $s->lpa_stock_image
      ));
        } else {
            return null;
        }
    }

    public function update($id, $stock)
    {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('UPDATE lpa_stock SET
                     lpa_stock_desc = :productDescription
                    ,lpa_stock_onhand = :onHand
                    ,lpa_stock_price = :price
                    ,lpa_stock_status = :status
                    ,lpa_stock_name = :productName
                    ,lpa_stock_image = :productImage
                    WHERE lpa_stock_ID = :id');

        $rowCount = $handle->execute((array)$stock);

        return $rowCount > 0;
    }

    public function insert($stock)
    {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('INSERT INTO lpa_stock (lpa_stock_name, lpa_stock_desc
                        ,lpa_stock_onhand, lpa_stock_price
                        ,lpa_stock_status)
                        VALUES (:productName, :productDescription
                        , :onHand, :price, :status)');
        // var_dump($stock);
        // var_dump($handle);
        $rowCount = $handle->execute(array(
          ':productName' => $stock->productName,
          ':productDescription' => $stock->productDescription,
          ':onHand' => $stock->onHand,
          ':price' => $stock->price,
          ':status' => $stock->status
        ));

        return $rowCount > 0;
    }

    function delete($stockId){
      global $connManager;

      $link = $connManager->createLink();

      $handle = $link->prepare("UPDATE lpa_stock SET lpa_stock_status = 'i'
                                  WHERE lpa_stock_ID = :id");

      $handle->execute(array(':id' => $stockId));
    }
}
