<?php
  require('app-lib.php');

  use App\Controllers\StockController;
  use App\Models\Stock;

  $stockController = new StockController;
  $authChk = true;

  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if (!$sid) {
      isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if (!$action) {
      isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }

  $stock = new Stock;
  if ($action == "Edit") {
      $stock = $stockController->getById($sid);
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Stock Record Management (<?= $action; ?>)</div>
    <form name="frmStockRec" id="frmStockRec" method="post">
      <div class="form-group">
        <label for="txtStockID">Id</label>
        <input readonly="readonly" name="txtStockID" id="txtStockID" placeholder="Stock ID" value="<?= $stock->id; ?>" style="width: 100px;" title="Stock ID">
      </div>
      <div class="form-group" style="margin-top: <?php echo $fieldSpacer; ?>">
        <label for="txtStockName">Name:</label>
        <input name="txtStockName" id="txtStockName" placeholder="Stock Name" value="<?= $stock->productName; ?>" style="width: 400px;"  title="Stock Name">
      </div>
      <div class="form-group" style="margin-top: <?php echo $fieldSpacer; ?>">
        <label for="txtStockDesc">Description:</label>
        <textarea name="txtStockDesc" id="txtStockDesc" placeholder="Stock Description" style="width: 400px;height: 80px"  title="Stock Description"><?= $stock->productDescription; ?></textarea>
      </div>
      <div class="form-group" style="margin-top: <?php echo $fieldSpacer; ?>">
        <label for="txtStockOnHand">On Hand:</label>
        <input name="txtStockOnHand" id="txtStockOnHand" placeholder="Stock On-Hand" value="<?= $stock->onHand; ?>" style="width: 90px;text-align: right"  title="Stock On-Hand">
      </div>
      <div class="form-group" style="margin-top: <?php echo $fieldSpacer; ?>">
        <label for="txtStockPrice">Price:</label>
        <input name="txtStockPrice" id="txtStockPrice" placeholder="Stock Price" value="<?= $stock->price; ?>" style="width: 90px;text-align: right"  title="Stock Price">
      </div>
      <div class="form-group">
        <label for="txtImage">Image:</label>
        <input type="file" id="txtImage" name="txtImage" onchange="encodeImageFileAsURL();">
        <input type="hidden" id="txtImageBase64" name="txtImageBase64" />
      </div>
      <div class="form-group" style="margin-top: <?php echo $fieldSpacer; ?>">
        <label for="txtStatus">Status:</label>
        <input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive">Active</label>
        <input name="txtStatus" id="txtStockStatusInactive" type="radio" value="i">
          <label for="txtStockStatusInactive">Inactive</label>
      </div>
    </form>
    <div class="optBar">
      <button type="button" id="btnStockSave">Save</button>
      <button type="button" onclick="navMan('stock.php')">Close</button>
      <?php if ($action == "Edit") {
    ?>
      <button type="button" style="color: darkred; margin-left: 20px">DELETE</button>
      <?php

} ?>
    </div>
  </div>
  <script>
    var stockRecStatus = "<?= $stock->status; ?>";
    if(stockRecStatus == "i") {
      $('#txtStockStatusInactive').prop('checked', true);
    } else {
      $('#txtStockStatusActive').prop('checked', true);
    }
    $("#btnStockSave").click(function(){
        $.post('api/stock-save.php', $("form").serialize())
          .done(function(d){
            alert(d.message);
            if(d.wasSuccessful){
              location.href = 'stock.php?refresh';
            }
          });
    });

    function delRec(ID) {
      $.post('api/stock-delete.php?id=' + ID)
        .done(function(d){
          alert(d.message);
          location.href = 'stock.php?refresh';
        }).fail(function(x, t){
          console.log('fail', x, t);
        });
    }
    setTimeout(function(){
      $("#txtStockName").focus();
    },1);
    function encodeImageFileAsURL() {

    var filesSelected = document.getElementById("txtImage").files;
    if (filesSelected.length > 0) {
      var fileToLoad = filesSelected[0];

      var fileReader = new FileReader();

      fileReader.onload = function(fileLoadedEvent) {
        var srcData = fileLoadedEvent.target.result; // <--- data: base64
        $('#txtImageBase64').val(srcData);
        console.log('image', srcData);
        // //var newImage = document.createElement('img');
        // newImage.src = srcData;
        //
        // document.getElementById("imgTest").innerHTML = newImage.outerHTML;
        // alert("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
        // console.log("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
      }
      fileReader.readAsDataURL(fileToLoad);
    }
  }
  </script>
<?php
build_footer();
?>
