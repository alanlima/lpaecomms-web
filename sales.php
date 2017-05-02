<?PHP

  $authChk = true;
  $invoiceAmounts = 0;
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);
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
      <?PHP if($action == "listSales") { ?>
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
            <?PHP
              openDB();
              $query = "SELECT
                          *
                        FROM lpa_invoices
                        WHERE
                          lpa_inv_no LIKE '%$txtSearch%'
                        OR
                          lpa_inv_client_name LIKE '%$txtSearch%'";
              $result = $db->query($query);
              $row_cnt = $result->num_rows;

              if($row_cnt > 0){
                while ($row = $result->fetch_assoc()) {
                  $invoiceAmounts += $row['lpa_inv_amount'];
                  ?>
                  <tr>
                    <td>
                      <?PHP echo $row['lpa_inv_no']; ?>
                    </td>
                    <td>
                      <?php echo date_format(new DateTime($row['lpa_inv_date']), "d/m/Y"); ?>
                    </td>
                    <td>
                      <?php echo $row['lpa_inv_client_name']; ?>
                    </td>
                    <td>
                      <?php echo $row['lpa_inv_amount']; ?>
                    </td>
                  </tr>
              <?php  }
            } else { ?>
              <tr>
                <td colspan="4" style="text-align: center">
                  No Records Found for: <b><?PHP echo $txtSearch; ?></b>
                </td>
              </tr>
              <?php } ?>
             <tbody>
          </table>
        </div>
        <?PHP } ?>
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
