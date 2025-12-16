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
    <title>Billing | <?php echo $projectName; ?>::</title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Create New Bill</h1></div>
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
                <!-- <form id="bill_generate_frm" action="invoicing-code/billing-2.php" method="POST" enctype="multipart/form-data"> -->
                <form id="bill_generate_frm" action="invoicing-code/billing-2.php" method="POST" enctype="multipart/form-data">
                <div class="body">
                  <div class="row">
                    <div class="col-md-5"><h5 class="text-info">Product List</h5></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="form-control form-control-sm" name="product_typ" id="product_typ" onchange="getProduct('')">
                          <option value="">All</option>
                          <?php
                          $getProductType=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1 ORDER BY `category_name`");
                          while($rowProductType=mysqli_fetch_array($getProductType)){
                            $uidProductType=$rowProductType['unq_id'];
                            $catProductType=$rowProductType['category_name'];
                            ?><option value="<?php echo $uidProductType;?>"><?php echo $catProductType;?></option><?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <input type="text" name="product_src" id="product_src" class="form-control form-control-sm" placeholder="Search by Product Name" onkeyup="getProduct()">
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
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Date of Invoice</b><span class="text-danger"> *</span></label>
                        <input type="date" name="invoice_date" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Invoice No</b></label>
                        <input type="text" name="invoice_no" id="invoice_no" value="<?php echo getInvoiceNo(); ?>" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label><b>Taxable</b></label>
                        <div class="input-group">
                          <input type="text" name="taxable_amount" id="taxable_amount" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>GST Value</b></label>
                        <div class="input-group">
                          <input type="text" name="gst_value" id="gst_value" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Total Amount</b></label>
                        <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label><b>Round Amount</b></label>
                        <input type="text" name="roundAmount" id="roundAmount" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label><b>Net Amount</b></label>
                        <div class="input-group">
                          <input type="text" name="net_amount" id="net_amount" class="form-control" value="" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Payment Information &nbsp;&nbsp;&nbsp;<i class="fas fa-undo fa-lg" onclick="getReturnInfo()"></i></h5></div></div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Method</b></label>
                        <select class="form-control form-control-sm" name="pay_method" id="pay_method" onchange="getLedger(this.value)">
                          <option value="">-- Select --</option>
                          <?php
                          $getPaymentMethod=mysqli_query($conn,"SELECT * FROM `payment_method` WHERE `stat`=1");
                          while ($rowPaymentMethod=mysqli_fetch_array($getPaymentMethod)){
                            $pay_typ_sl = $rowPaymentMethod['sl'];
                            $pay_method_name = $rowPaymentMethod['pay_method'];
                            ?><option value="<?php echo $pay_typ_sl;?>" <?php if($pay_typ_sl==1){ echo "selected";} ?>><?php echo $pay_method_name;?></option><?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Received to</b></label>
                        <div id="divLedger">
                          <select class="form-control form-control-sm" name="ledger_id" id="ledger_id">
                            <option value="">-- Select --</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><b>Amount</b></label>
                        <div class="input-group">
                          <input type="number" name="pay_amnt" id="pay_amnt" onclick="select()" class="form-control form-control-sm" min="0">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Remark / Reference No.</label>
                        <input type="text" name="narration" id="narration" class="form-control form-control-sm" placeholder="Remark">
                      </div>
                    </div>
                    <div class="col-md-2" style="padding-top:31px;">
                      <button type="sumbit" name="pay_method_btn" id="pay_method_btn" class="btn btn-sm btn-info">Payment</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="divPayList"></div>
                    </div>
                  </div>
                  -->
                  <div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Customer Information</h5></div></div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><b>Mobile</b></label>
                        <input type="number" name="mobile_no" id="mobile_no" class="form-control form-control-sm">
                        </td>
                      </div>
                    </div>
                    <div class="col-md-2" style="padding-top:31px;">
                      <button type="button" class="btn btn-info btn-sm" onclick="getCustomerInfo()">Get Data</button>
                    </div>
                  </div>
                  <div id="divCustomerInfo"></div>
                  <div class="row">
                    <div class="col-md-12 text-right pt-5">
                      <button class="btn btn-success" type="submit" id="create_bill_btn" name="create_bill_btn">Confirm</button>
                    </div>
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
    <script type="text/javascript" src="invoicing-js/billing.js"></script>
    <script type="text/javascript" src="invoicing-js/billing-payment.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      getProduct('');
      getTempProduct();
      getPayList();
      $("#product_src").focus();
    });
    function getProduct(){
      var product_typ = $('#product_typ').val();
      var emp_id = $('#emp_id').val();
      var product_src = $('#product_src').val();
      $("#divProductList").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#divProductList").load("jquery-pages/load-billing-product-list.php?product_typ="+product_typ+"&emp_id="+emp_id+"&product_src="+encodeURIComponent(product_src)).fadeIn("fast") }, 500);
    }
    function getTempProduct(){
      $("#divTempProductList").load("jquery-pages/load-temp-billing-product.php").fadeIn("fast");
      $.get("jquery-pages/get-billing-subtotal-amount.php", function(data){
        var dataSplit=data.split("@")
        var dataSplit1=dataSplit.shift()
        var dataSplit2=dataSplit.shift()
        var dataSplit3=dataSplit.shift()
        var dataSplit4=dataSplit.shift()
        var dataSplit5=dataSplit.shift()
        $('#taxable_amount').val(dataSplit1);
        $('#gst_value').val(dataSplit2);
        $('#totalAmount').val(dataSplit3);
        $('#roundAmount').val(dataSplit4);
        $('#net_amount').val(dataSplit5);
      });
    }
    function saveSingleProductTemp(product_id,avStk){
      var stock_qty=$('#qty'+product_id).val();
      var amount=$('#amnt'+product_id).val();
      var tamnt=parseFloat(stock_qty) * parseFloat(amount);
      $('#tamnt'+product_id).val(tamnt.toFixed(2));
      $('#divTemp').load("invoicing-code/add-temp-billing-product.php?stock_qty="+stock_qty+"&product_id="+product_id+"&amount="+amount).fadeIn("fast");
    }
    function del_tmp_product(sl,fun_nm,tbl_nm){
      $("#divTemp").load("invoicing-code/delete-temp-product.php?sl="+sl+"&fun_nm="+fun_nm+"&tbl_nm="+tbl_nm).fadeIn("fast");
    }
    function getDiscount(){
      var disc_type = $('#disc_type').val();
      var dis_per = $('#dis_per').val();
      var shipping_charge = $('#shipping_charge').val();
      $.get("jquery-pages/get-billing-discount-amount.php?disc_type="+disc_type+"&dis_per="+dis_per+"&shipping_charge="+shipping_charge, function(data){
        var str=data;
        var stra=str.split("@")
        var fstr1=stra.shift()
        var fstr2= stra.shift()
        $('#dis_amnt').val(fstr1);
        $('#n_amnt').val(fstr2);
      });
    }
    function getPayList(){
      var invoice_no = $('#invoice_no').val();
      $("#divPayList").load("jquery-pages/load-billing-payment-list.php?invoice_no="+invoice_no).fadeIn("fast");
      $('#pay_method').val('');
      $('#pay_amnt').val('');
      $('#narration').val('');
    }
    function getPayBalance(){
      var n_amnt = $('#n_amnt').val();
      $('#pay_amnt').val(n_amnt);
    }
    function payDelete(pid){
      $("#divPayList").load("invoicing-code/billing-payment-delete.php?pid="+pid).fadeIn("fast");
    }
    function getLedger(pay_method){
      $("#divLedger").load("jquery-pages/get-ledger.php?pay_method="+pay_method).fadeIn("fast");
    }
    function getReturnInfo(){
      $("#div_lightbox").load("lightbox/billing-return-invoice.php").fadeIn("fast");
      $('#modal-report').modal('show');
    }
    // Add Product Modal
    function addProduct(){
      $("#div_lightbox").load("lightbox/add-product.php").fadeIn("fast");
      $('#modal-report').modal('show');
    }
    function getCustomerInfo(){
      var mobile_no=$('#mobile_no').val();
      $("#divCustomerInfo").load("jquery-pages/get-customer-info.php?mobile_no="+mobile_no).fadeIn("fast"); 
    }
    </script>
  </body>
</html>
<?php
}
?>