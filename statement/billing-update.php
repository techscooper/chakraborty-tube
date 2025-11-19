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
    $temp_member_id=$rowUpdateTemp['member_id'];
    $temp_product_id=$rowUpdateTemp['product_id'];
    $temp_quantity=$rowUpdateTemp['quantity'];
    $temp_amount=$rowUpdateTemp['amount'];
    $temp_edt=$rowUpdateTemp['edt'];
    $temp_eby=$rowUpdateTemp['eby'];
    $temp_stat=$rowUpdateTemp['stat'];
    mysqli_query($conn,"INSERT INTO `billing_product_item_update` (`member_id`, `invoice_no`, `product_id`, `quantity`, `amount`, `edt`, `eby`, `stat`) VALUES ('$temp_member_id', '$invoice_no', '$temp_product_id', '$temp_quantity', '$temp_amount', '$temp_edt', '$temp_eby', '$temp_stat')");
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
  $billing_customer_name=get_single_value("customer_tbl","unq_id",$billing_customer_id,"customer_nm","",$conn);
  $billing_customer_mobile=get_single_value("customer_tbl","unq_id",$billing_customer_id,"mobile_no","",$conn);
  $billing_customer_address=get_single_value("customer_tbl","unq_id",$billing_customer_id,"address_1","",$conn);
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
                <!-- <form id="bill_generate_frm" action="statement-code/billing-2.php" method="POST" enctype="multipart/form-data"> -->
                <form id="bill_generate_frm" action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
                <div class="body">
                  <div class="row">
                    <div class="col-md-5"><h5 class="text-info">Product List</h5></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="form-control form-control-sm" name="product_typ" id="product_typ" onchange="getProduct('')">
                          <?php
                          $getProductType=mysqli_query($conn,"SELECT * FROM `inventory_category_table` WHERE `stat`=1 ORDER BY `category`");
                          while ($rowProductType=mysqli_fetch_array($getProductType)){
                            $uidProductType = $rowProductType['unq_id'];
                            $catProductType = $rowProductType['category'];
                            ?><option value="<?php echo $uidProductType;?>"><?php echo $catProductType;?></option><?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <input type="text" name="product_src" id="product_src" class="form-control form-control-sm" placeholder="Search by Product Name" onkeyup="getProduct(this.value)">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 pt-1">
                      <div id="divProductList"></div>
                    </div>
                  </div>
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Added Products</h5></div></div>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="divTempProductList"></div>
                      <div id="divTemp"></div>
                    </div>
                  </div>
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Billing info</h5></div></div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Customer Name</b><span class="text-danger"> *</span></label>
                        <input type="text" name="customer_id" id="customer_id" value="<?php echo $billing_customer_name; ?>" autocomplete="off" class="form-control form-control-sm" onclick="select()" readonly>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Mobile</b></label>
                        <input type="number" name="mobile_no" id="mobile_no" class="form-control form-control-sm" value="<?php echo $billing_customer_mobile; ?>" onclick="select()" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label><b>Address</b></label>
                        <input type="text" name="address_1" id="address_1" class="form-control form-control-sm" value="<?php echo $billing_customer_address; ?>" onclick="select()" readonly>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Date of Invoice</b><span class="text-danger"> *</span></label>
                        <input type="text" name="invoice_date" id="invoice_date" value="<?php echo date('d-m-Y',strtotime($billing_invoice_date)); ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Invoice No</b></label>
                        <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Subtotal</b></label>
                        <div class="input-group">
                          <input type="text" name="t_amnt" id="t_amnt" value="<?php echo $taxable_value; ?>" class="form-control form-control-sm" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Shipping Charge</b></label>
                        <input type="number" name="shipping_charge" id="shipping_charge" value="<?php echo $shipping_charge; ?>" class="form-control form-control-sm" min="0" onclick="select()" onkeyup="getDiscount()">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Disc Type</b></label>
                        <div class="input-group">
                          <select class="form-control form-control-sm" name="disc_type" id="disc_type" onchange="getDiscount()">
                            <option value="1" <?php if($billing_disc_type==1){ echo "selected";} ?>>Percentage</option>
                            <option value="2" <?php if($billing_disc_type==2){ echo "selected";} ?>>Fixed</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Disc Rate</b></label>
                        <div class="input-group">
                          <input type="number" name="dis_per" id="dis_per" value="<?php echo $billing_dis_per; ?>" onkeyup="getDiscount()" onclick="select()" class="form-control form-control-sm" min="0">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Disc Price</b></label>
                        <div class="input-group">
                          <input type="text" name="dis_amnt" id="dis_amnt" value="<?php echo $billing_dis_amnt; ?>" class="form-control form-control-sm" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Net Price</b></label>
                        <div class="input-group">
                          <input type="text" name="n_amnt" id="n_amnt" class="form-control form-control-sm" value="<?php echo $net_amount; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pt-5"><span id="due_refund_amount"></span></div>
                    <div class="col-md-6 text-right pt-5"><button class="btn btn-success" type="submit" id="create_bill_btn" name="create_bill_btn">Confirm</button></div>
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
    <script type="text/javascript" src="statement-js/billing.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      getProduct('');
      getTempProduct('<?php echo $invoice_no; ?>');
      $("#product_src").focus();
    });
    function getProduct(product_src){
      var product_typ = $('#product_typ').val();
      var emp_id = $('#emp_id').val();
      $("#divProductList").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#divProductList").load("jquery-pages/load-billing-product-list.php?product_typ="+product_typ+"&emp_id="+emp_id+"&product_src="+encodeURIComponent(product_src)).fadeIn("fast") }, 500);
    }
    function getTempProduct(invoice_no){
      $("#divTempProductList").load("jquery-pages/load-temp-billing-product.php?invoice_no="+invoice_no).fadeIn("fast");
      $.get("jquery-pages/get-billing-subtotal-amount.php?invoice_no="+invoice_no, function(data){
        $('#t_amnt').val(data);
        $('#n_amnt').val(data);
        getDiscount();
      });
    }
    function saveSingleProductTemp(product_id,avStk){
      var invoice_no = $('#invoice_no').val();
      var stock_qty = $('#qty'+product_id).val();
      var amount = $('#amnt'+product_id).val();
      var tamnt = parseFloat(stock_qty) * parseFloat(amount);
      $('#tamnt'+product_id).val(tamnt.toFixed(2));
      $('#divTemp').load("statement-code/add-temp-billing-product.php?stock_qty="+stock_qty+"&product_id="+product_id+"&amount="+amount+"&invoice_no="+invoice_no+"&member_id=<?php echo $temp_member_id; ?>").fadeIn("fast");
    }
    function del_tmp_product(sl,fun_nm,tbl_nm,invoice_no){
      $("#divTemp").load("statement-code/delete-temp-product.php?sl="+sl+"&fun_nm="+fun_nm+"&tbl_nm="+tbl_nm+"&invoice_no="+invoice_no).fadeIn("fast");
    }
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
    </script>
  </body>
</html>
<?php
}
?>
