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
    <title>Purchase | <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php'); ?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php'); ?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Purchase</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <form id="purchaseAddFrm" action="invoicing-code/purchase-2.php" method="POST" enctype="multipart/form-data">
                  <div class="body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Supplier<span class="text-danger"> *</span></label>
                          <select class="form-control" name="supplier_id" id="supplier_id">
                            <option value="">-Select-</option>
                            <?php
                            $get_customer=mysqli_query($conn,"SELECT * FROM `supplier_tbl` WHERE `stat`=1 ORDER BY `supplier_nm`");
                            while($row_customer=mysqli_fetch_array($get_customer)){
                              $supplier_u_id = $row_customer['unq_id'];
                              $supplier_nm = $row_customer['supplier_nm'];
                              $mobile_no = $row_customer['mobile_no'];
                              ?><option value="<?php echo $supplier_u_id;?>"><?php echo "$supplier_nm ($mobile_no)";?></option><?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Date of Purchase<span class="text-danger"> *</span></label>
                          <input type="date" name="purchase_date" id="purchase_date" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Bill Number</label>
                          <input type="text" name="billno" id="billno" value="" class="form-control" placeholder="Bill Number">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Product Type</label>
                          <select class="form-control" name="product_typ" id="product_typ" onchange="getProduct('')">
                            <?php
                            $getProductCategory=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1 ORDER BY `category_name`");
                            while($rowProductCategory=mysqli_fetch_array($getProductCategory)){
                              $categoryUnqID=$rowProductCategory['unq_id'];
                              $categoryName=$rowProductCategory['category_name'];
                              ?><option value="<?php echo $categoryUnqID; ?>"><?php echo $categoryName;?></option><?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row"><div class="col-md-12"><hr></div></div>
                    <div class="row">
                      <div class="col-md-7"><h5>Product List</h5></div>
                      <div class="col-md-5">
                        <input type="text" name="product_src" id="product_src" class="form-control" placeholder="Search by Product Name & Code" onkeyup="getProduct(this.value)">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 pt-1">
                        <div id="divProductList"></div>
                      </div>
                    </div>
                    <div class="row"><div class="col-md-12"><hr><h5>Added Products</h5></div></div>
                    <div class="row">
                      <div class="col-md-12">
                        <div id="divTempProductList"></div>
                        <div id="divTemp"></div>
                      </div>
                    </div>
                    <div class="row"><div class="col-md-12"><hr></div></div>
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label><b>Taxable Amount</b></label>
                          <input type="text" name="taxableAmountTotal" id="taxableAmountTotal" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label><b>GST Value</b></label>
                          <input type="text" name="gstValueTotal" id="gstValueTotal" value="0" class="form-control" readonly>
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
                          <input type="text" name="netAmountTotal" id="netAmountTotal" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <button type="submit" id="purchaseAddBtn" class="btn btn-success">Confirm</button>
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
    <script type="text/javascript" src="invoicing-js/purchase.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        getProduct('');
        getTempProduct();
        $("#product_src").focus();
      });
      function getProduct(product_src){
        var product_typ = $('#product_typ').val();
        var emp_id = $('#emp_id').val();
        $("#divProductList").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
        setTimeout(function(){ $("#divProductList").load("jquery-pages/load-purchase-product-list.php?product_typ="+product_typ+"&emp_id="+emp_id+"&product_src="+encodeURIComponent(product_src)).fadeIn("fast") }, 1000);
      }
      function getTempProduct(){
        $("#divTempProductList").load("jquery-pages/load-temp-purchase-product.php").fadeIn("fast");
        $.get("jquery-pages/get-purchase-subtotal-amount.php", function(data){
          var str=data;
          var stra=str.split("@")
          var fstr1=stra.shift()
          var fstr2=stra.shift()
          var fstr3=stra.shift()
          var fstr4=stra.shift()
          var fstr5=stra.shift()
          $('#taxableAmountTotal').val(fstr1);
          $('#gstValueTotal').val(fstr2);
          $('#totalAmount').val(fstr3);
          $('#roundAmount').val(fstr4);
          $('#netAmountTotal').val(fstr5);
        });
      }
      function saveSingleProductTemp(product_id,avStk){
        var stock_qty = $('#qty'+product_id).val();
        var amount = $('#amnt'+product_id).val();
        if(stock_qty!="" && amount!=""){
          var tamnt = parseFloat(stock_qty) * parseFloat(amount);
          $('#tamnt'+product_id).val(tamnt.toFixed(2));
          $('#divTemp').load("invoicing-code/add-temp-purchase-product.php?stock_qty="+stock_qty+"&product_id="+product_id+"&amount="+amount).fadeIn("fast");
        }
        else if(stock_qty==""){
          var tamnt = 0 * parseFloat(amount);
          $('#tamnt'+product_id).val(tamnt.toFixed(2));
        }
        else if (stock_qty==""){
          var tamnt = parseFloat(stock_qty) * 0;
          $('#tamnt'+product_id).val(tamnt.toFixed(2));
        }
      }
      function del_tmp_product(sl,fun_nm,tbl_nm){
        $("#divTemp").load("invoicing-code/delete-temp-product.php?sl="+sl+"&fun_nm="+fun_nm+"&tbl_nm="+tbl_nm).fadeIn("fast");
      }
      function getDiscount(dis_per){
        $.get("jquery-pages/get-purchase-discount-amount.php?dis_per="+dis_per, function(data){
          var str=data;
          var stra=str.split("@")
          var fstr1=stra.shift()
          var fstr2=stra.shift()
          $('#n_amnt').val(fstr1);
          $('#dis_amnt').val(fstr2);
        });
      }
    </script>
  </body>
</html>
<?php
}
?>