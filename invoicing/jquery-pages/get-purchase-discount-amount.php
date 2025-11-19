<?php
include '../../config.php';
if($ckadmin==1){
  $discountPercentage=mysqli_real_escape_string($conn,$_REQUEST['dis_per']);
  $tAmnt = $gAmnt = $dAmnt = $dis_amnt = 0;
  $getProduct=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp` WHERE `supplier_id`='$idadmin'");
  while ($rowProduct=mysqli_fetch_array($getProduct)){
    $quantity = $rowProduct['quantity'];
    $amount = $rowProduct['amount'];
    $tAmnt = $quantity * $amount;
    $gAmnt = $gAmnt + $tAmnt;
  }

  if($discountPercentage!=0 AND $discountPercentage!='' AND $discountPercentage<=100){
    $dAmnt = round(($gAmnt - ($discountPercentage * $gAmnt / 100)),2);
    $dis_amnt = round(($gAmnt - $dAmnt),2);
  }
  else{
    $dAmnt = round($gAmnt,2);
  }
  echo $dAmnt.'@'.$dis_amnt;
}
?>