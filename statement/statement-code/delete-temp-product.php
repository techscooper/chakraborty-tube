<?php
include '../../config.php';
if($ckadmin==1){
  $temp_sl=mysqli_real_escape_string($conn,$_REQUEST['sl']);
  $fun_nm=mysqli_real_escape_string($conn,$_REQUEST['fun_nm']);
  $tbl_nm=mysqli_real_escape_string($conn,$_REQUEST['tbl_nm']);
  $invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
  $get_product_del=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `sl`='$temp_sl' AND `invoice_no`='$invoice_no'");
  while($row_product_del = mysqli_fetch_array($get_product_del)){
    $member_id_del =$row_product_del['member_id'];
    $invoice_no_del =$row_product_del['invoice_no'];
    $product_id_del =$row_product_del['product_id'];
    $quantity_del =$row_product_del['quantity'];
    $amount_del = $row_product_del['amount'];
    mysqli_query($conn,"INSERT INTO `billing_product_item_delete`(`sl`, `member_id`, `invoice_no`, `product_id`, `quantity`, `amount`, `edt`, `eby`, `stat`) VALUES (NULL,'$member_id_del','$invoice_no_del','$product_id_del','$quantity_del','$amount_del','$currentDateTime','$idadmin','0')");
  }
  mysqli_query($conn,"DELETE FROM $tbl_nm WHERE `sl`='$temp_sl'");
  ?>
  <script type="text/javascript">
    <?php echo "$fun_nm('$invoice_no')";?>
  </script>
  <?php
}
else{
  header('location:../../');
  header("X-XSS-Protection: 0");
}
?>