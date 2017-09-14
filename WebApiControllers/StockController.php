<?php
namespace App\WebApiControllers;

use App\Database\ConnectionManager;

class StockController
{
    private $connManager;

    public function __construct()
    {
        global $connManager;
        $connManager = new ConnectionManager();
    }


    function getAvailableStock(){
        global $connManager;
        
        $link = $connManager->createLink();
    
        $handle = $link->prepare("SELECT 
                                    lpa_stock_ID, 
                                    lpa_stock_name,
                                    lpa_stock_desc,
                                    lpa_stock_price,
                                    lpa_stock_image
                                FROM lpa_stock
                                WHERE 
                                    lpa_stock_onhand > 0
                                AND lpa_stock_status = 'a'
        ");
        
        $handle->execute();
    
        $return = $handle->fetchAll(\PDO::FETCH_OBJ);
        
        $stock = array();
    
        foreach($return as $s){
            $stock[] = array(
                'id' => $s->lpa_stock_ID,
                'name' => $s->lpa_stock_name,
                'description' => $s->lpa_stock_desc,
                'price' => $s->lpa_stock_price,
                'image' => $s->lpa_stock_image
            );
        }
            
        return $stock;
    }
}