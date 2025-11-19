<?php
include '../../config.php';
$invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
$disc_type=mysqli_real_escape_string($conn,$_REQUEST['disc_type']);
$dis_per=mysqli_real_escape_string($conn,$_REQUEST['dis_per']);
$shipping_charge=mysqli_real_escape_string($conn,$_REQUEST['shipping_charge']);
if($shipping_charge==""){$shipping_charge=0;}

$due_refund_amount = "";
$subTotalAmount = $netAmount = $discountAmount = $discountAmount = 0;
$getProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `invoice_no`='$invoice_no'");
while ($rowProduct=mysqli_fetch_array($getProduct)){
  $quantity = $rowProduct['quantity'];
  $amount = $rowProduct['amount'];
  $subTotalAmount = $quantity * $amount;
  $netAmount = $netAmount + $subTotalAmount;
}

if($disc_type==1){
  $discountAmount = round(($dis_per * $netAmount / 100),2);
}
elseif ($disc_type==2) {
  $discountAmount = round($dis_per,2);
}
$netAmount = $netAmount - $discountAmount + $shipping_charge;

$getPaid=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `net_amount_paid` FROM `account_master` WHERE `invoice_no`='$invoice_no' AND `type`=2 AND `level`=2");
while ($rowPaid=mysqli_fetch_array($getPaid)){
  $net_amount_paid = $rowPaid['net_amount_paid'];
}
if($net_amount_paid>$netAmount){
  $refundAmount = number_format($net_amount_paid - $netAmount,2);
  $due_refund_amount="<b style=\"font-size:18px; color:red;\">Refund Amount: $refundAmount</>";
}
else {
  $dueAmount = number_format($netAmount - $net_amount_paid,2);
  $due_refund_amount="<b style=\"font-size:18px; color:red;\">Due Amount: $dueAmount</>";
}
echo round($discountAmount,2).'@'.$netAmount.'@'.$due_refund_amount;
?>