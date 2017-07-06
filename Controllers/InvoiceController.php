<?php
namespace App\Controllers;

use App\Models\Invoice;
use App\Database\ConnectionManager;

class InvoiceController
{
    public $connManager = null;

    public function __construct()
    {
        global $connManager;
        $connManager = new ConnectionManager;
    }

    public function getInvoices($searchText)
    {
        global $connManager;
        $link = $connManager->createLink();

        $handle = $link->prepare("SELECT * FROM lpa_invoices WHERE
                                  lpa_inv_no LIKE :search
                                OR
                                  lpa_inv_client_name LIKE :search");

        $handle->execute(array(':search' => "%$searchText%"));

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        $invoices = array();

        foreach ($result as $i) {
            $invoices[] = new Invoice(array(
              "number"      => $i->lpa_inv_no,
              "date"        => $i->lpa_inv_date,
              "clientName"  => $i->lpa_inv_client_name,
              "amount"      => $i->lpa_inv_amount
            ));
        }

        return $invoices;
    }
}
