<?PHP

  $authChk = true;
  $invoiceAmounts = 0;
  require('app-lib.php');
  use App\Controllers\InvoiceController;

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);

  $invoiceController = new InvoiceController;
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Sales Management Search</div>

    <!-- Search Section Start -->
      <form name="frmSearchInvoice" method="post"
            id="frmSearchInvoice"
            action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
        <div class="displayPane">
          <div class="displayPaneCaption">Search:</div>
          <div>
            <input name="txtSearch" id="txtSearch" placeholder="Search Invoice"
            style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
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
                <?php $invoiceAmounts += $inv->Amount; ?>
                <tr>
                  <td>
                    <?PHP echo $inv->Number; ?>
                  </td>
                  <td>
                    <?php echo date_format(new DateTime($inv->Date), "d/m/Y"); ?>
                  </td>
                  <td>
                    <?php echo $inv->ClientName; ?>
                  </td>
                  <td>
                    <?php echo money_format('$ %i', $inv->Amount); ?>
                  </td>
                </tr>
              <?php endforeach ?>

             <tbody>
          </table>
        </div>

        <div class="invoice-amount">
          <span>
            <b>Total Invoice Amount:</b>
            <?php echo money_format('$ %i', $invoiceAmounts); ?>
          </span>
        </div>
  </div>
  <script>
  setTimeout(function(){
    $('#txtSearch').select().focus();
  }, 1);
  </script>
<?PHP
build_footer();
?>
