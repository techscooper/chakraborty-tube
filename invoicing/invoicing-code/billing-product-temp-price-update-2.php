<?php
include '../../config.php';
if($ckadmin==1){
  $sl=mysqli_real_escape_string($conn,$_POST['sl']);
  $price_amount=mysqli_real_escape_string($conn,$_POST['price_amount']);
  mysqli_query($conn,"UPDATE `billing_product_item_temp` SET `amount`='$price_amount' WHERE `sl`='$sl'");
  $return['success'] = true;
  $return['msg'] = "Price updated successfully.";
  echo json_encode($return);
}
?>