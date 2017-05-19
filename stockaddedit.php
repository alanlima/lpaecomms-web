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
?>

<div class="row">
  <div class="col-lg-12">
    <div class="page-header">
      <h1>Stock Record Management <small><?= $action; ?></small></h1>
    </div>
  </div>
</div>
<form>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <!-- <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div> -->
      <div class="panel-body">
        <div class="form-group">
          <label for="txtStockID">Id:</label>
          <input type="text" class="form-control" readonly name="txtStockID" placeholder="Stock ID" value="<?= $stock->id; ?>">
        </div>

        <div class="form-group">
          <label for="txtStockName">Name:</label>
          <input type="text" class="form-control" name="txtStockName" placeholder="Stock Name" value="<?= $stock->productName?>">
        </div>

        <div class="form-group">
          <label for="txtStockDesc">Description:</label>
          <textarea class="form-control" row="3" name="txtStockDesc" placeholder="Stock Description"><?= $stock->productDescription ?></textarea>
        </div>

        <div class="form-group">
          <label for="txtStockOnHand">On Hand:</label>
          <input type="text" class="form-control" name="txtStockOnHand" placeholder="Stock On Hand" value="<?= $stock->onHand; ?>">
        </div>

        <div class="form-group">
          <label for="txtStockPrice">Price:</label>
          <input type="text" class="form-control" name="txtStockPrice" placeholder="Stock Price" value="<?= $stock->price ?>">
        </div>

        <div class="form-group">
          <label for="txtImage">Image:</label>
          <input type="file" id="txtImage" name="txtImage" onchange="encodeImageFileAsURL();">
          <input type="hidden" id="txtImageBase64" name="txtImageBase64" />
        </div>

        <div class="form-group">
          <label for="txtStatus">Status:</label>

            <label class="radio-inline" for="txtStockStatusActive">
              <input name="txtStatus" id="txtStockStatusActive" type="radio" value="a"> Active</label>

            <label class="radio-inline" for="txtStockStatusInactive">
              <input name="txtStatus" id="txtStockStatusInactive" type="radio" value="i"> Inactive</label>
        </div>
      </div>
      <div class="panel-footer">


                <?php if ($action == "Edit") {
              ?>
                <button type="button" class="btn btn-danger" onclick="delRec(<?= $stock->id; ?>);">Delete</button>
                <?php
          } ?>

        <div class="pull-right" style="display: inline-block;">
          <button type="button" class="btn btn-default" onclick="navMan('stock.php')">Cancel</button>
          <button type="button" class="btn btn-primary" id="btnStockSave">Save</button>
        </div>


      </div>
    </div>
  </div>
</div>
</form>
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
      var confirm = window.confirm("Do you want to delete this item?");
      if(!confirm) return;
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
