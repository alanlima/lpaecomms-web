<?php
  $authChk = true;
  require('app-lib.php');
  use App\Controllers\StockController;

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if (!$action) {
      isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if (!$txtSearch) {
      isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);

  $stockController = new StockController;
?>

<div class="row">
  <div class="col-lg-12">
    <div class="page-header">
      <h1>Stock Management <small></small></h1>
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
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
          <input type="hidden" name="a" value="listStock">

          <div class="form-group input-group">
            <input type="text" class="form-control"
              name="txtSearch" id="txtSearch" placeholder="Type to search" />
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit" id="btnSearch">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
          <?php if($action == "listStock" || isset($_REQUEST['refresh'])) : ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <td></td>
                  <td>Code</td>
                  <td>Name</td>
                  <td>Description</td>
                  <td>On Hand</td>
                  <td>Price</td>
                </tr>
              </thead>
              <tbody>
                <?php
                  $stockList = $stockController->getByFilter($txtSearch);
                  foreach ($stockList as $s) : ?>
                  <tr class="hl" onclick="loadStockItem(<?= $s->id ?>,'Edit')">
                    <td style="cursor: pointer;">
                      <img src="<?= $s->productImage; ?>" alt="Product Image" style="max-width: 100px; max-height: 100px" />
                    </td>
                    <td style="cursor: pointer;">
                      <?= $s->id; ?>
                    </td>
                    <td style="cursor: pointer;">
                        <?= $s->productName; ?>
                    </td>
                    <td style="cursor: pointer;">
                        <?= $s->productDescription; ?>
                    </td>
                    <td style="cursor: pointer;">
                        <?= $s->onHand; ?>
                    </td>
                    <td style="cursor: pointer;">
                      <?= $s->price; ?>
                    </td>
                  </tr>
                <?php endforeach;
                  if (count($stockList) == 0) : ?>
                  <tr>
                    <td colspan="5" style="text-align: center">
                      No Records Found for: <b><?= $txtSearch; ?></b>
                    </td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        <?php endif ?>
        </form>
      </div>
      <div class="panel-footer">
        <div class="text-right">
          <button class="btn btn-default" id="btnAddRec">New Stock</button>
        </div>
      </div>
    </div>
  </div>
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
