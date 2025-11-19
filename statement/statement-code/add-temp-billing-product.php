<?php
include '../../config.php';
if($ckadmin==1){
  $quantity=mysqli_real_escape_string($conn,$_REQUEST['stock_qty']);
  $product_id=mysqli_real_escape_string($conn,$_REQUEST['product_id']);
  $amount=mysqli_real_escape_string($conn,$_REQUEST['amount']);
  $invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
  $member_id=mysqli_real_escape_string($conn,$_REQUEST['member_id']);
  $getProductChk=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `product_id`='$product_id' AND `invoice_no`='$invoice_no'");
  $rcntProductChk=mysqli_num_rows($getProductChk);
  if($rcntProductChk==0){
    mysqli_query($conn,"INSERT INTO `billing_product_item_update` (`member_id`, `invoice_no`, `product_id`, `quantity`, `amount`, `edt`, `eby`) VALUES ('$member_id', '$invoice_no', '$product_id', '$quantity', '$amount', '$currentDateTime', '$idadmin')");
  }
  else{
    if($quantity>0 && $amount>0){
      mysqli_query($conn,"UPDATE `billing_product_item_update` SET `quantity`='$quantity', `amount`='$amount' WHERE `product_id`='$product_id' AND `invoice_no`='$invoice_no'");
    }
    else{
      mysqli_query($conn,"UPDATE `billing_product_item_update` SET `amount`='$amount' WHERE `product_id`='$product_id' AND `invoice_no`='$invoice_no'");
    }
  }
}
?>
<script type="text/javascript">
  getTempProduct('<?php echo $invoice_no; ?>');
</script>