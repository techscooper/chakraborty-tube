<?php
include '../config.php';
if($ckadmin==0){
  header('location:../login');
}
else{
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Product List || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php'); ?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php'); ?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Product List</h1></div>
            <div class="right">
              <a href="inventory-add.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Add Product</span>
                <span class="btn-inner--hidden"><i class="fa fa-plus"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Category</label>
                      <select class="form-control" id="category_id" name="category_id" onchange="show_list_div()">
                        <option value="">-- All --</option>
                        <?php
                        $getCategory=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1 ORDER BY `category_name`");
                        while($rowCategory=mysqli_fetch_array($getCategory)){
                          $categoryUnqID=$rowCategory['unq_id'];
                          $categoryName=$rowCategory['category_name'];
                          ?><option value="<?php echo $categoryUnqID;?>"><?php echo $categoryName; ?></option><?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label>Keyword Search</label>
                      <input type="text" name="allsrc" id="allsrc" value="" class="form-control" onkeyup="show_list_div()" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="body">
                  <div id="list_div"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript">
      $(document).ready(function(){ show_list_div(); });
      function show_list_div(){
        var category_id=$('#category_id').val();
        var allsrc = encodeURIComponent($('#allsrc').val());
        $("#list_div").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
        setTimeout(function(){ $("#list_div").load("jquery-pages/show-inventory-list.php?category_id="+category_id+"&allsrc="+allsrc).fadeIn("fast") }, 100);
      }
      function inventoryUpdate(inventoryUnqID){
        $('#div_lightbox').load("lightbox/inventory-update.php?inventoryUnqID="+inventoryUnqID).fadeIn("fast");
        $('#modal-report').modal('show');
      }
    </script>
  </body>
</html>
<?php
}
?>