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
    <title>Billing Statement || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Billing Statement</h1></div>
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
                        <label>Customer</label>
                        <select class="form-control form-control-sm" name="customer_id" id="customer_id">
                          <option value="">-- All --</option>
                          <?php
                          $get_customer=mysqli_query($conn,"SELECT * FROM `customer_tbl` WHERE `stat`=1 ORDER BY `customer_nm`");
                          while ($row_customer=mysqli_fetch_array($get_customer)){
                            $customer_u_id = $row_customer['unq_id'];
                            $customer_name = $row_customer['customer_nm'];
                            $mobile_no = $row_customer['mobile_no'];
                            ?><option value="<?php echo $customer_u_id;?>"><?php echo "$customer_name"; if($mobile_no!=""){ echo " ($mobile_no)";} ?></option><?php
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
                    <div class="col-md-4" style="padding-top:29px;">
                      <a href="javascript:void(0);" class="btn btn-sm btn-info" onclick="show_list_div()">Show</a>
                      <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick="listExport()">CSV Export</a> -->
                      <a href="javascript:void(0);" class="btn btn-sm btn-success" onclick="listExportDetails()">CSV Export (Details)</a>
                    </div>
                  </div>
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
      var customer_id = $('#customer_id').val();
      var fdt = encodeURIComponent($('#fdt').val());
      var tdt = encodeURIComponent($('#tdt').val());
      $("#list_div").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#list_div").load("jquery-pages/billing-lists.php?customer_id="+customer_id+"&fdt="+fdt+"&tdt="+tdt).fadeIn("fast") }, 1000);
    }
    function listExport(){
      var customer_id=$('#customer_id').val();
      var fdt=encodeURIComponent($('#fdt').val());
      var tdt=encodeURIComponent($('#tdt').val());
      document.location="export/billing-lists-export.php?customer_id="+customer_id+"&fdt="+fdt+"&tdt="+tdt;
    }
    function listExportDetails(){
      var fdt=encodeURIComponent($('#fdt').val());
      var tdt=encodeURIComponent($('#tdt').val());
      document.location="export/billing-lists-details-export.php?fdt="+fdt+"&tdt="+tdt;
    }
    function billingItems(invoice_no){
      $("#div_lightbox").load("lightbox/billing-items.php?invoice_no="+invoice_no).fadeIn("fast");
      $('#modal-report').modal('show');
    }
    function billReprint(invoice_no){
      window.open("../invoicing/export/billing-invoice-print.php?invoice_no="+invoice_no, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=300,width=800,height=1000");
    }
    function returnBill(invoice_no){
      if(confirm('Are you sure want to Return?')){
        document.location="billing-return.php?invoice_no="+invoice_no;
      }
    }
    </script>
  </body>
</html>
<?php
}
?>