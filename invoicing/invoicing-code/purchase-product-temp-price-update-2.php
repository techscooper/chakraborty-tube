<?php
include '../../config.php';
if($ckadmin==1){
  $sl=mysqli_real_escape_string($conn,$_POST['sl']);
  $amount=mysqli_real_escape_string($conn,$_POST['amount']);
  mysqli_query($conn,"UPDATE `purchase_product_item_temp` SET `amount`='$amount' WHERE `sl`='$sl'");
  $return['success'] = true;
  $return['msg'] = "Price updated successfully.";
  echo json_encode($return);
}
?>