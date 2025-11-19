<?php
include '../../config.php';
$invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
$tAmnt = $gAmnt = 0;
$getProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `invoice_no`='$invoice_no'");
while ($rowProduct=mysqli_fetch_array($getProduct)){
  $quantity = $rowProduct['quantity'];
  $amount = $rowProduct['amount'];
  $tAmnt = $quantity * $amount;
  $gAmnt = round(($gAmnt + $tAmnt),2);
}
echo $gAmnt;
?>