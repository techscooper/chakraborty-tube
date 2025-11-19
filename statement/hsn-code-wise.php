<?php
include '../config.php';
if ($ckadmin==0){
  header('location:../login');
}
else{
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>HSN Code Wise || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>HSN Code Wise</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Product</label>
                        <select class="form-control form-control-sm" name="product_id" id="product_id">
                          <option value="">-- All --</option>
                          <?php
                          $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 ORDER BY `product_name`");
                          while($rowProduct=mysqli_fetch_array($getProduct)){
                            $productUnqID=$rowProduct['unq_id'];
                            $productName=$rowProduct['product_name'];
                            $hsnCode=$rowProduct['hsn_code'];
                            ?><option value="<?php echo $productUnqID; ?>"><?php echo "$productName [$hsnCode]"; ?></option><?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label>From</label>
                      <input type="date" name="fdt" id="fdt" value="<?php echo date('Y-m-01'); ?>" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                      <label>To</label>
                      <input type="date" name="tdt" id="tdt" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2" style="padding-top:29px;">
                      <a href="javascript:void(0);" class="btn btn-sm btn-info" onclick="getListShow()">Show</a>
                      <!-- <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="getListExport()">Export Excel</a> -->
                    </div>
                  </div>
                  <div id="divList"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript">
    $(document).ready(function(){ getListShow(); });
    function getListShow(){
      var product_id=$('#product_id').val();
      var fdt=encodeURIComponent($('#fdt').val());
      var tdt=encodeURIComponent($('#tdt').val());
      $("#divList").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#divList").load("jquery-pages/load-hsn-code-wise.php?product_id="+product_id+"&fdt="+fdt+"&tdt="+tdt).fadeIn("fast") }, 1000);
    }
    function getListExport(){
      var product_id=$('#product_id').val();
      var fdt=encodeURIComponent($('#fdt').val());
      var tdt=encodeURIComponent($('#tdt').val());
      document.location="export/export-hsn-code-wise.php?product_id="+product_id+"&fdt="+fdt+"&tdt="+tdt;
    }
    </script>
  </body>
</html>
<?php
}
?>