<?php

  $authChk = true;
  $invoiceAmounts = 0;
  require('app-lib.php');
  use App\Controllers\InvoiceController;

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if (!$action) {
      isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if (!$txtSearch) {
      isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);

  $invoiceController = new InvoiceController;
?>

<div class="row">
  <div class="col-lg-12">
    <div class="page-header">
      <h1>Sales Management <small></small></h1>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
        <form class="" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
          <input type="hidden" name="a" value="listSales">

          <div class="form-group input-group">
            <input type="text" class="form-control"
                name="txtSearch" id="txtSearch" placeholder="Search Invoice" value="<?= $txtSearch; ?>">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit" id="btnSearch">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Date</th>
                  <th>Customer Name</th>
                  <th>Amount </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($invoiceController->getInvoices($txtSearch) as $inv) : ?>
                  <?php $invoiceAmounts += $inv->amount; ?>
                  <tr>
                    <td>
                      <?= $inv->number; ?>
                    </td>
                    <td>
                      <?= date_format(new DateTime($inv->date), "d/m/Y"); ?>
                    </td>
                    <td>
                      <?= $inv->clientName; ?>
                    </td>
                    <td>
                      <?= money_format('$ %i', $inv->amount); ?>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>


        </form>
      </div>
      <div class="panel-footer">
        <div class="invoice-amount">
          <span>
            <b>Total Invoice Amount:</b>
            <?= money_format('$ %i', $invoiceAmounts); ?>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Search Section Start -->
    
      <!-- Search Section End -->

      <!-- Search Section List Start -->

  <script>
  setTimeout(function(){
    $('#txtSearch').select().focus();
  }, 1);
  </script>
<?php
build_footer();
?>
