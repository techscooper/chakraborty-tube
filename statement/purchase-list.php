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
    <title>Purchase List || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Purchase List</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="body">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Supplier</label>
                        <select class="form-control form-control-sm" name="supplier_id" id="supplier_id">
                          <option value="">-- All --</option>
                          <?php
                          $getSupplier=mysqli_query($conn,"SELECT * FROM `supplier_tbl` WHERE `stat`=1 ORDER BY `supplier_nm`");
                          while ($rowSupplier=mysqli_fetch_array($getSupplier)){
                            $supplierUnqID=$rowSupplier['unq_id'];
                            $supplier_nm=$rowSupplier['supplier_nm'];
                            $mobile_no=$rowSupplier['mobile_no'];
                            ?><option value="<?php echo $supplierUnqID;?>"><?php echo "$supplier_nm ($mobile_no)";?></option><?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>From</label>
                      <input type="date" name="fdt" id="fdt" value="<?php echo date('Y-m-01'); ?>" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                      <label>To</label>
                      <input type="date" name="tdt" id="tdt" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3" style="padding-top:29px;">
                      <a href="javascript:void(0);" class="btn btn-sm btn-success" onclick="show_list_div()">Show</a>
                      <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="purchaseExport()">Export</a>
                    </div>
                  </div>
                </div>
                <div class="col-12">
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
      var supplier_id = $('#supplier_id').val();
      var fdt = encodeURIComponent($('#fdt').val());
      var tdt = encodeURIComponent($('#tdt').val());
      $("#list_div").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#list_div").load("jquery-pages/purchase-lists.php?supplier_id="+supplier_id+"&fdt="+fdt+"&tdt="+tdt).fadeIn("fast") }, 1000);
    }
    function purchaseItems(purchase_no){
      $("#div_lightbox").load("lightbox/purchase-items.php?purchase_no="+purchase_no).fadeIn("fast");
      $('#modal-report').modal('show');
    }
    function purchaseExport(){
      var supplier_id = $('#supplier_id').val();
      var fdt = encodeURIComponent($('#fdt').val());
      var tdt = encodeURIComponent($('#tdt').val());
      document.location = "export/export-purchase-list.php?supplier_id="+supplier_id+"&fdt="+fdt+"&tdt="+tdt;
    }
    </script>
  </body>
</html>
<?php
}
?>