<?php
include '../../config.php';
if($ckadmin==1){
  $product_id=mysqli_real_escape_string($conn,$_REQUEST['product_id']);
  $quantity=mysqli_real_escape_string($conn,$_REQUEST['stock_qty']);
  $productRate=mysqli_real_escape_string($conn,$_REQUEST['amount']);

  $gstPercentage=get_single_value('inventory_tbl','unq_id',$product_id,'igst','');
  $taxableAmount = $productRate * $quantity;
  $gstValue=round((($taxableAmount*$gstPercentage)/100),2);
  $netAmount=$taxableAmount+$gstValue;

  $getProductChk=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp` WHERE `product_id`='$product_id' AND `supplier_id`='$idadmin'");
  if(mysqli_num_rows($getProductChk)==0){
    mysqli_query($conn,"INSERT INTO `purchase_product_item_temp`(`supplier_id`, `product_id`, `quantity`, `product_rate`, `taxable_amount`, `gst_percentage`, `gst_value`, `net_amount`, `edt`, `eby`) VALUES ('$idadmin', '$product_id', '$quantity', '$productRate', '$taxableAmount', '$gstPercentage', '$gstValue', '$netAmount', '$currentDateTime', '$idadmin')");
  }
  else{
    mysqli_query($conn,"UPDATE `purchase_product_item_temp` SET `quantity`='$quantity', `product_rate`='$productRate', `taxable_amount`='$taxableAmount', `gst_percentage`='$gstPercentage', `gst_value`='$gstValue', `net_amount`='$netAmount' WHERE `product_id`='$product_id' AND `supplier_id`='$idadmin'");
  }
  ?>
  <script type="text/javascript">
    getTempProduct();
  </script>
  <?php
}
?>