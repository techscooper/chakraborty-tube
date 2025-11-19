<?php
include '../config.php';
if ($ckadmin==0){
  header('location:../login');
}
else{
  $invoice_no=base64_decode($_REQUEST['invoice_no']);
  //mysqli_query($conn,"DELETE FROM `billing_product_item_delete` WHERE `invoice_no`='$invoice_no' AND `stat`='0'");
  mysqli_query($conn,"DELETE FROM `billing_product_item_update` WHERE `invoice_no`='$invoice_no'");
  $getUpdateTemp=mysqli_query($conn,"SELECT * FROM `billing_product_item` WHERE `invoice_no`='$invoice_no'");
  while ($rowUpdateTemp=mysqli_fetch_array($getUpdateTemp)) {
    $item_unq_id=$rowUpdateTemp['unq_id'];
    $temp_member_id=$rowUpdateTemp['member_id'];
    $temp_product_id=$rowUpdateTemp['product_id'];
    $temp_quantity=$rowUpdateTemp['quantity'];
    $temp_amount=$rowUpdateTemp['amount'];
    $temp_edt=$rowUpdateTemp['edt'];
    $temp_eby=$rowUpdateTemp['eby'];
    $temp_stat=$rowUpdateTemp['stat'];
    mysqli_query($conn,"INSERT INTO `billing_product_item_update` (`item_unq_id`, `member_id`, `invoice_no`, `product_id`, `quantity`, `amount`, `edt`, `eby`, `stat`) VALUES ('$item_unq_id', '$temp_member_id', '$invoice_no', '$temp_product_id', '$temp_quantity', '$temp_amount', '$temp_edt', '$temp_eby', '$temp_stat')");
  }
  $getUpdate1=mysqli_query($conn,"SELECT * FROM `billing` WHERE `invoice_no`='$invoice_no'");
  while ($rowUpdate1=mysqli_fetch_array($getUpdate1)) {
    $billing_unq_id=$rowUpdate1['unq_id'];
    $billing_customer_id=$rowUpdate1['customer_id'];
    $billing_invoice_date=$rowUpdate1['invoice_date'];
    $billing_disc_type=$rowUpdate1['disc_type'];
    $billing_dis_per=$rowUpdate1['dis_per'];
    $billing_dis_amnt=$rowUpdate1['dis_amnt'];
    $billing_payment_stat=$rowUpdate1['payment_stat'];
  }
  $billing_customer_name=get_single_value("customer_tbl","unq_id",$billing_customer_id,"customer_nm","");
  $billing_customer_mobile=get_single_value("customer_tbl","unq_id",$billing_customer_id,"mobile_no","");
  $billing_customer_address=get_single_value("customer_tbl","unq_id",$billing_customer_id,"address_1","");
  $getUpdate2=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `invoice_no`='$invoice_no' AND `type`=2 AND `level`=1");
  while ($rowUpdate2=mysqli_fetch_array($getUpdate2)) {
    $taxable_value=$rowUpdate2['taxable_value'];
    $net_amount=$rowUpdate2['net_amount'];
  }
  $getUpdate2=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `invoice_no`='$invoice_no' AND `type`=2 AND `level`=4");
  while ($rowUpdate2=mysqli_fetch_array($getUpdate2)) {
    $shipping_charge=$rowUpdate2['net_amount'];
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Return Invoice | <?php echo $projectName; ?>::</title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Return Invoice | <?php echo $invoice_no; ?></h1></div>
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
                <form method="POST" id="returnInvoiceFrm" action="statement-code/billing-return-2.php">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
                <div class="body">
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Billing Information</h5></div></div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Date of Invoice</b><span class="text-danger"> *</span></label>
                        <input type="text" value="<?php echo date('d-m-Y',strtotime($billing_invoice_date)); ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Invoice No</b></label>
                        <input type="text" value="<?php echo $invoice_no; ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Date of Return</b><span class="text-danger"> *</span></label>
                        <input type="date" id="return_invoice_date" name="return_invoice_date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Return Invoice No</b></label>
                        <input type="text" id="return_invoice_no" name="return_invoice_no" value="<?php echo getReturnInvoiceNo(); ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Customer Information</h5></div></div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Customer Name</b><span class="text-danger"> *</span></label>
                        <input type="text" value="<?php echo $billing_customer_name; ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Mobile</b></label>
                        <input type="text" value="<?php echo $billing_customer_mobile; ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><b>Address</b></label>
                        <input type="text" value="<?php echo $billing_customer_address; ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Invoice Products</h5></div></div>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="divTempProductList"></div>
                    </div>
                  </div>
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Return Products</h5></div></div>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="divTempReturnProductList"></div>
                    </div>
                  </div>
                  <div id="divAmountInformation"></div>
                  <div class="row">
                    <div class="col-12 text-right pt-5"><button type="submit" id="returnInvoiceBtn" class="btn btn-success">Confirm</button></div>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="statement-js/billing-return.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        getTempProduct('<?php echo $invoice_no; ?>','','');
        getAmountInformation('<?php echo $invoice_no; ?>');
      });
      function getTempProduct(invoice_no,tmpProductSl,returnStat){
      $("#divTempProductList").load("jquery-pages/load-temp-billing-product.php?invoice_no="+invoice_no+"&tmpProductSl="+tmpProductSl+"&returnStat="+returnStat).fadeIn("fast");
        setTimeout(function(){
          $("#divTempReturnProductList").load("jquery-pages/load-temp-billing-product-delete.php?invoice_no="+invoice_no).fadeIn("fast");
          getAmountInformation('<?php echo $invoice_no; ?>');
        }, 100);
      
      /*
      $.get("jquery-pages/get-billing-subtotal-amount.php?invoice_no="+invoice_no, function(data){
        $('#t_amnt').val(data);
        $('#n_amnt').val(data);
        //getDiscount();
      });
      */
    }
    function getAmountInformation(invoice_no){
      $("#divAmountInformation").load("jquery-pages/get-billing-amount-information.php?invoice_no="+invoice_no).fadeIn("fast");
    }
    /*
    function getDiscount(){
      var invoice_no = $('#invoice_no').val();
      var disc_type = $('#disc_type').val();
      var dis_per = $('#dis_per').val();
      var shipping_charge = $('#shipping_charge').val();
      $.get("jquery-pages/get-billing-discount-amount.php?invoice_no="+invoice_no+"&disc_type="+disc_type+"&dis_per="+dis_per+"&shipping_charge="+shipping_charge, function(data){
        var str=data;
        var stra=str.split("@")
        var fstr1=stra.shift()
        var fstr2= stra.shift()
        var fstr3= stra.shift()
        $('#dis_amnt').val(fstr1);
        $('#n_amnt').val(fstr2);
        $('#due_refund_amount').html(fstr3);
      });
    }
    */
    </script>
  </body>
</html>
<?php
}
?>