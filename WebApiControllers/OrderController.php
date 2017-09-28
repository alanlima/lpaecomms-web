<?php

namespace App\WebApiControllers;

use App\Database\ConnectionManager;

class OrderController {
    private $connManager;

    public function __construct(){
        global $connManager;
        $connManager = new ConnectionManager;
    }

    function create($orderDetail) {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('INSERT INTO lpa_invoices (
                                    lpa_inv_date,
                                    lpa_inv_client_ID,
                                    lpa_inv_client_name,
                                    lpa_inv_client_address,
                                    lpa_inv_amount,
                                    lpa_inv_status)
                                 VALUES (
                                    :inv_date,
                                    :client_id,
                                    :client_name,
                                    :client_address,
                                    :amount,
                                    :status
                                 )');

        $invoiceId = 0;
        
        try {
            $link->beginTransaction();

            $handle->execute(array(
                ':inv_date' => date('Y-m-d'),
                ':client_id' => $orderDetail->customerId,
                ':client_name' => $orderDetail->customerName,
                ':client_address' => $orderDetail->customerAddress,
                ':amount' => $orderDetail->totalAmount,
                ':status' => 'P'
            ));

            $invoiceId = $link->lastInsertId();

            $link->commit();
            
        } catch(PDOException $e) {
            $link->rollback();
        }

        if($invoiceId > 0){
            $this->saveItems($invoiceId, $orderDetail->items);

            return $invoiceId;
        }

        return -1;
    }

    function saveItems($invoiceId, $items) {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare("
            INSERT INTO lpa_invoice_items
                (
                    lpa_invitem_inv_no,
                    lpa_invitem_stock_ID,
                    lpa_invitem_stock_name,
                    lpa_invitem_qty,
                    lpa_invitem_stock_price,
                    lpa_invitem_stock_amount,
                    lpa_inv_status
                )
            VALUES
                (
                    :invoice_id,
                    :stock_id,
                    :stock_name,
                    :quantity,
                    :price,
                    :amount,
                    :status
                )
        ");

        foreach($items as $item) {
            $handle->execute(array(
                ':invoice_id' => $invoiceId,
                ':stock_id' => $item->productId,
                ':stock_name' => $item->productName,
                ':quantity' => $item->quantity,
                ':price' => $item->amount,
                ':amount' => $item->total,
                ':status' => 'P'
            ));
        }
    }

}