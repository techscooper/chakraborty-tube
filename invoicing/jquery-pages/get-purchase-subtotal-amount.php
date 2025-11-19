<?php
include '../../config.php';
if($ckadmin==1){
  $taxable_amountTotal = $gst_valueTotal = $amountTotal = $roundAmount = $net_amountTotal = 0;
  $getProduct=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp` WHERE `supplier_id`='$idadmin'");
  while ($rowProduct=mysqli_fetch_array($getProduct)){
    $taxable_amount=$rowProduct['taxable_amount'];
    $gst_value=$rowProduct['gst_value'];
    $net_amount=$rowProduct['net_amount'];
    $taxable_amountTotal+=$taxable_amount;
    $gst_valueTotal+=$gst_value;
    $amountTotal+=$net_amount;
  }
  $roundAmount=round(($amountTotal-round($amountTotal,0)),2);
  $net_amountTotal=round(($amountTotal-$roundAmount),2);
  echo number_format($taxable_amountTotal,2).'@'.number_format($gst_valueTotal,2).'@'.number_format($amountTotal,2).'@'.number_format($roundAmount,2).'@'.number_format($net_amountTotal,2);
}
?>