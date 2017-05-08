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
  <?php build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Sales Management Search</div>

    <!-- Search Section Start -->
      <form name="frmSearchInvoice" method="post"
            id="frmSearchInvoice"
            action="<?= $_SERVER['PHP_SELF']; ?>">
        <div class="displayPane">
          <div class="displayPaneCaption">Search:</div>
          <div>
            <input name="txtSearch" id="txtSearch" placeholder="Search Invoice"
            style="width: calc(100% - 115px)" value="<?= $txtSearch; ?>">
            <button type="submit" id="btnSearch">Search</button>
            <!-- <button type="button" id="btnAddRec">Add</button> -->
          </div>
        </div>
        <input type="hidden" name="a" value="listSales">
      </form>
      <!-- Search Section End -->

      <!-- Search Section List Start -->
        <div>
          <table class="table-list">
            <thead>
              <tr>
                <td>Number</td>
                <td>Date</td>
                <td>Customer Name</td>
                <td>Amount</td>
              </tr>
            </thead
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

             <tbody>
          </table>
        </div>

        <div class="invoice-amount">
          <span>
            <b>Total Invoice Amount:</b>
            <?= money_format('$ %i', $invoiceAmounts); ?>
          </span>
        </div>
  </div>
  <script>
  setTimeout(function(){
    $('#txtSearch').select().focus();
  }, 1);
  </script>
<?php
build_footer();
?>
