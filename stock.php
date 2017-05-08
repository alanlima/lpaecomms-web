<?php
  $authChk = true;
  require('app-lib.php');
  use App\Controllers\StockController;

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if (!$action) {
      isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  // isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  // if (!$txtSearch) {
  //     isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  // }
  build_header($displayName);

  $stockController = new StockController;
?>
  <?php build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Stock Management Search</div>

  <!-- Search Section Start -->
    <form name="frmSearchStock" method="post"
          id="frmSearchStock"
          action="<?= $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <div class="displayPaneCaption">Search:</div>
        <div>
          <input name="txtSearch" id="txtSearch" placeholder="Search Stock"
          style="width: calc(100% - 115px)" value="<?= $txtSearch; ?>">
          <button type="button" id="btnSearch">Search</button>
          <button type="button" id="btnAddRec">Add</button>
        </div>
      </div>
      <input type="hidden" name="a" value="listStock">
    </form>
    <!-- Search Section End -->
    <!-- Search Section List Start -->
    <?php if ($action == "listStock" || isset($_REQUEST['refresh'])) { ?>
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
        <tr style="background: #eeeeee">
          <td style="width: 80px;border-left: #cccccc solid 1px"><b>Code</b></td>
          <td style="border-left: #cccccc solid 1px"><b>Name</b></td>
          <td style="border-left: #cccccc solid 1px"><b>Description</b></td>
          <td style="border-left: #cccccc solid 1px"><b>On Hand</b></td>
          <td style="width: 80px; border-left: #cccccc solid 1px"><b>Price</b></td>
        </tr>

        <?php
          $stockList = $stockController->getByFilter($txtSearch);
          foreach ($stockList as $s) : ?>
          <tr class="hl" onclick="loadStockItem(<?= $s->id ?>,'Edit')">
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
              <?= $s->id; ?>
            </td>
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
                <?= $s->productName; ?>
            </td>
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
                <?= $s->productDescription; ?>
            </td>
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
                <?= $s->onHand; ?>
            </td>
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
              <?= $s->price; ?>
            </td>
          </tr>
        <?php endforeach;
          if (count($stockList) == 0) { ?>
          <tr>
            <td colspan="5" style="text-align: center">
              No Records Found for: <b><?= $txtSearch; ?></b>
            </td>
          </tr>
        <?php
          } ?> <!-- Finish no records found IF  -->
        <?php
      } ?> <!-- Finish action list stock IF -->
    <!-- Search Section List End -->
  </div>
  <script>
    function loadStockItem(ID,MODE) {
      window.location = "stockaddedit.php?sid=" +
      ID + "&a=" + MODE;
    }
    $("#btnSearch").click(function() {
      $("#frmSearchStock").submit();
    });
    $("#btnAddRec").click(function() {
      loadStockItem("","Add");
    });
    setTimeout(function(){
      $("#txtSearch").select().focus();
    },1);
  </script>
<?php
build_footer();
?>
