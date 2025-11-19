<?php
include '../../config.php';
if($ckadmin==1){
  $fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
  $tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
  if($fdt!="" && $tdt!=""){ $ftdt=" AND `billing`.`invoice_date` BETWEEN '$fdt' AND '$tdt'"; }else{ $ftdt=""; }
  $stockCnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = 0;
  $getStock=mysqli_query($conn,"SELECT `billing`.`invoice_date`, `billing_product_item`.`member_id`, `billing_product_item`.`invoice_no`, `billing_product_item`.`product_id`, `billing_product_item`.`quantity`, `billing_product_item`.`product_rate`, `billing_product_item`.`taxable_amount`, `billing_product_item`.`gst_percentage`, `billing_product_item`.`gst_value`, `billing_product_item`.`net_amount` FROM `billing`, `billing_product_item`, `customer_tbl` WHERE `billing`.`invoice_no`=`billing_product_item`.`invoice_no` AND `customer_tbl`.`unq_id`=`billing`.`customer_id` AND `customer_tbl`.`unq_id`=`billing_product_item`.`member_id` AND `customer_tbl`.`gst_no`='' AND `billing`.`stat`=1 $ftdt ORDER BY `billing_product_item`.`sl` DESC");
  if(mysqli_num_rows($getStock)>0){
?>
<div class="row">
  <div class="col-12">
    <table class="table table-sm table-bordered">
      <tr class="bg-secondary">
       <th class="text-center">#</th>
       <th class="text-center">Date</th>
       <th class="text-center">Invoice No</th>
       <th class="text-center">Customer Name</th>
       <th class="text-center">Customer Mobile</th>
       <th class="text-center">Product Name</th>
       <th class="text-center">HSN Code</th>
       <th class="text-center">Qty</th>
       <th class="text-center">Unit</th>
       <th class="text-center">Rate</th>
       <th class="text-center">Taxable Amount</th>
       <th class="text-center">GST (%)</th>
       <th class="text-center">GST Value</th>
       <th class="text-center">Net Price</th>
      </tr>
    <?php
    while ($rowStock=mysqli_fetch_array($getStock)){
      $stockCnt++;
      $member_id=$rowStock['member_id'];
      $invoice_date=$rowStock['invoice_date'];
      $invoice_no=$rowStock['invoice_no'];
      $product_id=$rowStock['product_id'];
      $quantity=$rowStock['quantity'];
      $product_rate=$rowStock['product_rate'];
      $taxable_amount=$rowStock['taxable_amount'];
      $gst_percentage=$rowStock['gst_percentage'];
      $gst_value=$rowStock['gst_value'];
      $net_amount=$rowStock['net_amount'];
      $customerName=get_single_value("customer_tbl","unq_id",$member_id,"customer_nm","");
      $customerMobile=get_single_value("customer_tbl","unq_id",$member_id,"mobile_no","");
      $productName=get_single_value("inventory_tbl","unq_id",$product_id,"product_name","");
      $hsnCode=get_single_value("inventory_tbl","unq_id",$product_id,"hsn_code","");
      $productUnitID=get_single_value("inventory_tbl","unq_id",$product_id,"unit_id","");
      $productUnit=get_single_value("unit_tbl","unq_id",$productUnitID,"unit_short_name","");
      ?>
      <tr>
        <td class="text-center"><?php echo $stockCnt; ?></td>
        <td class="text-center"><?php echo date('d-m-Y',strtotime($invoice_date)); ?></td>
        <td class="text-center"><?php echo $invoice_no; ?></td>
        <td class="text-center"><?php echo $customerName; ?></td>
        <td class="text-center"><?php echo $customerMobile; ?></td>
        <td class="text-center"><?php echo $productName; ?></td>
        <td class="text-center"><?php echo $hsnCode; ?></td>
        <td class="text-center"><?php echo $quantity; ?></td>
        <td class="text-center"><?php echo $productUnit; ?></td>
        <td class="text-right"><?php echo number_format($product_rate,2); ?></td>
        <td class="text-right"><?php echo number_format($taxable_amount,2); ?></td>
        <td class="text-right"><?php echo number_format($gst_percentage,2); ?></td>
        <td class="text-right"><?php echo number_format($gst_value,2); ?></td>
        <td class="text-right"><?php echo number_format($net_amount,2); ?></td>
      </tr>
      <?php
    }
    ?>
    </table>
  </div>
</div>
<?php
}
}
?>