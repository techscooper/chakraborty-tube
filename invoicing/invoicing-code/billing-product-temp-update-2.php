<?php
include '../../config.php';
if($ckadmin==1){
  $sl=mysqli_real_escape_string($conn,$_POST['sl']);
  $quantity_no=mysqli_real_escape_string($conn,$_POST['quantity_no']);
  mysqli_query($conn,"UPDATE `billing_product_item_temp` SET `quantity`='$quantity_no' WHERE `sl`='$sl'");
  $return['success'] = true;
  $return['msg'] = "Quantity updated successfully.";
  echo json_encode($return);
}
?>