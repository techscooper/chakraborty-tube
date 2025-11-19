<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $typ = 20;
    $supplier_id=mysqli_real_escape_string($conn,$_POST['supplier_id']);
    $invoice_date=mysqli_real_escape_string($conn,$_POST['purchase_date']);
    $invoice_no=mysqli_real_escape_string($conn,$_POST['billno']);
    if ($supplier_id == ''){
      $return['error'] = true;
      $return['msg'] = "Please Select Supplier.";
      echo json_encode($return);
    }
    elseif ($invoice_date == ''){
      $return['error'] = true;
      $return['msg'] = "Please Select Date.";
      echo json_encode($return);
    }
    elseif ($invoice_no == ''){
      $return['error'] = true;
      $return['msg'] = "Please enter bill no.";
      echo json_encode($return);
    }
    else{
      $getChkTempProduct=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp`");
      if(mysqli_num_rows($getChkTempProduct)>0){
        //Add Billing || Start
        $grandTaxableAmount = $grandGstValue = $amountTotal = $grandTotalAmount = 0;
        $getTempProduct=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp` WHERE `supplier_id`='$idadmin'");
        while($rowTempProduct=mysqli_fetch_array($getTempProduct)){
          $tempSl=$rowTempProduct['sl'];
          $product_id=$rowTempProduct['product_id'];
          $quantity=$rowTempProduct['quantity'];
          $product_rate=$rowTempProduct['product_rate'];
          $taxable_amount=$rowTempProduct['taxable_amount'];
          $gst_percentage=$rowTempProduct['gst_percentage'];
          $gst_value=$rowTempProduct['gst_value'];
          $net_amount=$rowTempProduct['net_amount'];

          $grandTaxableAmount+=$taxable_amount;
          $grandGstValue+=$gst_value;
          $amountTotal+=$net_amount;
          
          if($quantity>0){
            $unq_id_unique_stock=getUnqID('stock_master');
            $itemUnqID=getUnqID('purchase_product_item');
            mysqli_query($conn,"INSERT INTO `stock_master`(`unq_id`, `invoice_no`, `stk_dt`, `typ`, `product_id`, `stock_qty`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique_stock', '$invoice_no', '$invoice_date', '20', '$product_id', '$quantity', '$currentDateTime', '$idadmin', '1')");
            mysqli_query($conn,"INSERT INTO `purchase_product_item`(`unq_id`, `supplier_id`, `purchase_no`, `product_id`, `quantity`, `product_rate`, `taxable_amount`, `gst_percentage`, `gst_value`, `net_amount`, `edt`, `eby`, `stat`) VALUES('$itemUnqID', '$supplier_id', '$invoice_no', '$product_id', '$quantity', '$product_rate', '$taxable_amount', '$gst_percentage', '$gst_value', '$net_amount', '$currentDateTime', '$idadmin', '1')");
          }
          mysqli_query($conn,"DELETE FROM `purchase_product_item_temp` WHERE `sl`='$tempSl'");
        }
        $roundAmount=round((round($amountTotal,0)-$amountTotal),2);
        $grandTotalAmount=round(($amountTotal-$roundAmount),2);
        $billingUnqID=getUnqID('purchase');
        mysqli_query($conn,"INSERT INTO `purchase`(`unq_id`, `supplier_id`, `purchase_no`, `purchase_date`, `taxable_amount`, `gst_value`, `total_amount`, `round_amount`, `net_amount`, `edt`, `eby`, `stat`) VALUES('$billingUnqID', '$supplier_id', '$invoice_no', '$invoice_date', '$grandTaxableAmount', '$grandGstValue', '$amountTotal', '$roundAmount', '$grandTotalAmount', '$currentDateTime', '$idadmin', '1')");
        //Add Billing || End

        //Payable | Start
        $remark = 'Payble';
        $accountPayableUnqID=getUnqID('account_master');
        mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `dr`, `cr`, `type`, `level`, `remark`,  `edt`, `eby`, `stat`) VALUES('$accountPayableUnqID', '$invoice_no', '$invoice_date', '$supplier_id', '', '$idadmin', '0', '$taxable_amount', '0', '0', '0', '0', '$grandTotalAmount', '0', '1', '2', '1', '$remark', '$currentDateTime', '$idadmin', '1')");
        //Payable | End
       
        //Payment | Start
        $getPay1=mysqli_query($conn,"SELECT * FROM `billing_payment_method_temp` WHERE `stat`=1 AND `invoice_no`='$invoice_no'");
        if(mysqli_num_rows($getPay1)>0){
          while($rowPayment=mysqli_fetch_array($getPay1)){
            $pay_unq_id=$rowPayment['unq_id'];
            $pay_date_time=$rowPayment['pay_date_time'];
            $pay_method=$rowPayment['pay_method'];
            $pay_ledger_id=$rowPayment['ledger_id'];
            $pay_pay_amnt=$rowPayment['pay_amnt'];
            $narration=$rowPayment['narration'];
            $accountPaymentUnqID=getUnqID('account_master');
            mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `ledger_id`, `dr`, `cr`, `type`, `level`, `remark`, `edt`, `eby`, `stat`) VALUES('$accountPaymentUnqID', '$invoice_no', '$invoice_date', '$supplier_id', '', '$idadmin', '$pay_method', '$subtotal_amnt', '0', '0', '0', '0', '$pay_pay_amnt', '$pay_ledger_id', '1', '0', '2', '2', '$narration', '$currentDateTime', '$idadmin', '1')");
            mysqli_query($conn,"DELETE FROM `billing_payment_method_temp` WHERE `unq_id` = '$pay_unq_id'");
          }
        }
        //Payment | End
        
        $payAmntChk = 0;
        $getPayChk1=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `pay_amnt1` FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=2 AND `invoice_no`='$invoice_no'");
        while($rowPayChk1=mysqli_fetch_array($getPayChk1)){
          $payAmntChk = $rowPayChk1['pay_amnt1'];
        }
        if($payAmntChk==$grandTotalAmount){
          mysqli_query($conn,"UPDATE `purchase` SET `payment_stat`=1 WHERE `invoice_no`='$invoice_no'");
        }
        $return['success'] = true;
        $return['msg'] = "Purchase Successfully.";
        $return['invoice_no'] = $invoice_no;
        echo json_encode($return);
      }
      else{
        $return['error'] = true;
        $return['msg'] = "Please Add Product Item.";
        echo json_encode($return);
      }
    }
  }
  else{
    $return['error'] = true;
    $return['msg'] = "Server timeout, login session expired.";
    echo json_encode($return);
  }
}
else{
  header('location:../../');
}
?>