<?php
include '../../config.php';
if($ckadmin==1){
  $grandTaxableAmount = $grandGstValue = $amountTotal = $grandTotalAmount = 0;
  $getProductTemp=mysqli_query($conn,"SELECT * FROM `billing_product_item_temp` WHERE `member_id`='$idadmin'");
  while($rowProductTemp=mysqli_fetch_array($getProductTemp)){
    $quantity=$rowProductTemp['quantity'];
    $productRate=$rowProductTemp['product_rate'];
    $taxableAmount=$rowProductTemp['taxable_amount'];
    $gstPercentage=$rowProductTemp['gst_percentage'];
    $gstValue=$rowProductTemp['gst_value'];
    $netAmount=$rowProductTemp['net_amount'];
    $grandTaxableAmount+=$taxableAmount;
    $grandGstValue+=$gstValue;
    $amountTotal+=$netAmount;
  }
  $roundAmount=round(($amountTotal-round($amountTotal,0)),2);
  $grandTotalAmount=round(($amountTotal-$roundAmount),2);
  echo number_format($grandTaxableAmount,2).'@'.number_format($grandGstValue,2).'@'.number_format($amountTotal,2).'@'.number_format($roundAmount,2).'@'.number_format($grandTotalAmount,2);
}
?>