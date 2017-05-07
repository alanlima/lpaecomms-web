<?php
namespace App\Controllers;

use App\Models\Invoice;
use App\Database\ConnectionManager;

class InvoiceController {


  public $connManager = null;

  function __construct(){
    global $connManager;
    $connManager = new ConnectionManager;
  }

  public function getInvoices($searchText){
    global $connManager;
    $connManager->open();
    $query = "SELECT
                *
              FROM lpa_invoices
              WHERE
                lpa_inv_no LIKE '%$searchText%'
              OR
                lpa_inv_client_name LIKE '%$searchText%'";



    $result = $connManager->query($query);
    $invoices = array();
    while($row = $result->fetch_assoc()){
      $inv = new Invoice;
      $inv->Number = $row["lpa_inv_no"];
      $inv->Date = $row["lpa_inv_date"];
      $inv->ClientName = $row["lpa_inv_client_name"];
      $inv->Amount = $row["lpa_inv_amount"];

      $invoices[] = $inv;
    }

    return $invoices;
  }
}
 ?>
