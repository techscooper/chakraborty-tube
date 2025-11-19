<?php
include '../../config.php';
if($ckadmin==1){
  $disc_type=mysqli_real_escape_string($conn,$_REQUEST['disc_type']);
  $dis_per=mysqli_real_escape_string($conn,$_REQUEST['dis_per']);
  $shipping_charge=mysqli_real_escape_string($conn,$_REQUEST['shipping_charge']);
  if($shipping_charge==""){$shipping_charge=0;}
  $subTotalAmount = $netAmount = $discountAmount = $discountAmount = 0;
  $getProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_temp` WHERE `member_id`='$idadmin'");
  while ($rowProduct=mysqli_fetch_array($getProduct)){
    $quantity = $rowProduct['quantity'];
    $amount = $rowProduct['amount'];
    $subTotalAmount = $quantity * $amount;
    $netAmount = $netAmount + $subTotalAmount;
  }

  if($dis_per==""){$dis_per=0;}
  if($disc_type==1){
    $discountAmount = round(($dis_per * $netAmount / 100),2);
  }
  elseif ($disc_type==2) {
    $discountAmount = round($dis_per,2);
  }

  $netAmount = $netAmount - $discountAmount + $shipping_charge;
  echo round($discountAmount,2).'@'.$netAmount;
}
?>