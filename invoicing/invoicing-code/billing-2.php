<?php
include '../../config.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if($ckadmin==1){
    $mobile_no=mysqli_real_escape_string($conn,$_POST['mobile_no']);
    $customer_nm=mysqli_real_escape_string($conn,$_POST['customer_nm']);
    $email_id=mysqli_real_escape_string($conn,$_POST['email_id']);
    $gst_no=mysqli_real_escape_string($conn,$_POST['gst_no']);
    $pan_no=mysqli_real_escape_string($conn,$_POST['pan_no']);
    $zip_code=mysqli_real_escape_string($conn,$_POST['zip_code']);
    $address_1=mysqli_real_escape_string($conn,$_POST['address_1']);
    $address_2=mysqli_real_escape_string($conn,$_POST['address_2']);
    $customer_state_id=mysqli_real_escape_string($conn,$_POST['customer_state_id']);
    $invoice_no=mysqli_real_escape_string($conn,$_POST['invoice_no']);
    $invoice_date=mysqli_real_escape_string($conn,$_POST['invoice_date']);
    $valid = mysqli_query($conn,"SELECT * FROM `billing` WHERE `invoice_no`='$invoice_no' AND `stat`=1");
    if ($customer_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Customer.";
      echo json_encode($return);
    }
    elseif ($invoice_date == ''){
      $return['error'] = true;
      $return['msg'] = "Please Select Date.";
      echo json_encode($return);
    }
    elseif ($row_valid=mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This Invoice No Already Exists";
      echo json_encode($return);
    }
    else{
      //Customer | Start
      if(get_single_value("customer_tbl","mobile_no",$mobile_no,"mobile_no","")==""){
        $customerUnqID=getUnqID('customer_tbl');
        mysqli_query($conn,"INSERT INTO `customer_tbl`(`unq_id`, `customer_nm`, `email_id`, `mobile_no`, `gst_no`, `pan_no`, `customer_state_id`, `address_1`, `address_2`, `zip_code`, `edt`, `eby`, `stat`) VALUES('$customerUnqID', '$customer_nm', '$email_id', '$mobile_no', '$gst_no', '$pan_no', '$customer_state_id', '$address_1', '$address_2', '$zip_code', '$currentDateTime', '$idadmin', '1')");
      }
      else{
        if($customer_nm==''){ $customer_nm=get_single_value("customer_tbl","mobile_no",$mobile_no,"customer_nm",""); }
        if($email_id==''){ $email_id=get_single_value("customer_tbl","mobile_no",$mobile_no,"email_id",""); }
        if($gst_no==''){ $gst_no=get_single_value("customer_tbl","mobile_no",$mobile_no,"gst_no",""); }
        if($pan_no==''){ $pan_no=get_single_value("customer_tbl","mobile_no",$mobile_no,"pan_no",""); }
        if($customer_state_id==''){ $customer_state_id=get_single_value("customer_tbl","mobile_no",$mobile_no,"customer_state_id",""); }
        if($address_1==''){ $address_1=get_single_value("customer_tbl","mobile_no",$mobile_no,"address_1",""); }
        if($address_2==''){ $address_2=get_single_value("customer_tbl","mobile_no",$mobile_no,"address_2",""); }
        if($zip_code==''){ $zip_code=get_single_value("customer_tbl","mobile_no",$mobile_no,"zip_code",""); }
        $customerUnqID=get_single_value("customer_tbl","mobile_no",$mobile_no,"unq_id","");
        mysqli_query($conn,"UPDATE `customer_tbl` SET `customer_nm`='$customer_nm', `email_id`='$email_id', `mobile_no`='$mobile_no', `gst_no`='$gst_no', `pan_no`='$pan_no', `customer_state_id`='$customer_state_id', `address_1`='$address_1', `address_2`='$address_2', `zip_code`='$zip_code' WHERE `mobile_no`='$mobile_no'");
      }
      //Customer | End
      
      $getChkTempProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_temp`");
      if(mysqli_num_rows($getChkTempProduct)>0){
        //Add Billing || Start
        $grandTaxableAmount = $grandGstValue = $amountTotal = $grandTotalAmount = 0;
        $getTempProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_temp` WHERE `member_id`='$idadmin'");
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
            $itemUnqID=getUnqID('billing_product_item');
            mysqli_query($conn,"INSERT INTO `stock_master`(`unq_id`, `invoice_no`, `stk_dt`, `typ`, `product_id`, `stock_qty`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique_stock', '$invoice_no', '$invoice_date', '40', '$product_id', '$quantity', '$currentDateTime', '$idadmin', '1')");
            mysqli_query($conn,"INSERT INTO `billing_product_item`(`unq_id`, `member_id`, `invoice_no`, `product_id`, `quantity`, `product_rate`, `taxable_amount`, `gst_percentage`, `gst_value`, `net_amount`, `edt`, `eby`, `stat`) VALUES ('$itemUnqID', '$customerUnqID', '$invoice_no', '$product_id', '$quantity', '$product_rate', '$taxable_amount', '$gst_percentage', '$gst_value', '$net_amount', '$currentDateTime', '$idadmin', '1')");
          }
          mysqli_query($conn,"DELETE FROM `billing_product_item_temp` WHERE `sl`='$tempSl'");
        }
        $roundAmount=round((round($amountTotal,0)-$amountTotal),2);
        $grandTotalAmount=round(($amountTotal-$roundAmount),2);
        $billingUnqID=getUnqID('billing');
        mysqli_query($conn,"INSERT INTO `billing`(`unq_id`, `customer_id`, `invoice_no`, `invoice_date`, `taxable_amount`, `gst_value`, `total_amount`, `round_amount`, `net_amount`, `edt`, `eby`, `stat`) VALUES('$billingUnqID', '$customerUnqID', '$invoice_no', '$invoice_date', '$grandTaxableAmount', '$grandGstValue', '$amountTotal', '$roundAmount', '$grandTotalAmount', '$currentDateTime', '$idadmin', '1')");
        //Add Billing || End

        //Payable | Start
        $remark = 'Payble';
        $accountPayableUnqID=getUnqID('account_master');
        mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `dr`, `cr`, `type`, `level`, `remark`,  `edt`, `eby`, `stat`) VALUES('$accountPayableUnqID', '$invoice_no', '$invoice_date', '$customerUnqID', '', '$idadmin', '0', '$taxable_amount', '0', '0', '0', '0', '$grandTotalAmount', '0', '1', '2', '1', '$remark', '$currentDateTime', '$idadmin', '1')");
        //Payable | End
        
        /*
        //Discount | Start
        if($dis_amnt!="" OR $dis_amnt>0){
          $remark = "Discount";
          $accountDiscountUnqID=getUnqID('account_master');
          mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `dr`, `cr`, `type`, `level`, `remark`, `edt`, `eby`, `stat`) VALUES('$accountDiscountUnqID', '$invoice_no', '$invoice_date', '$customerUnqID', '', '$idadmin', '0', '$subtotal_amnt', '0', '0', '0', '0', '$dis_amnt', '0', '1', '2', '3', '$remark', '$currentDateTime', '$idadmin', '1')");          
        }
        //Discount | End

        //Shipping Charge | Start
        if($shipping_charge!="" OR $shipping_charge>0){
          $remark = "Shipping Charge";
          $accountShippingUnqID=getUnqID('account_master');
          mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `dr`, `cr`, `type`, `level`, `remark`, `edt`, `eby`, `stat`) VALUES('$accountShippingUnqID', '$invoice_no', '$invoice_date', '$customerUnqID', '', '$idadmin', '0', '$subtotal_amnt', '0', '0', '0', '0', '$shipping_charge', '0', '1', '2', '4', '$remark', '$currentDateTime', '$idadmin', '1')");
        }
        //Shipping Charge | End
        */

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
            mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `ledger_id`, `dr`, `cr`, `type`, `level`, `remark`, `edt`, `eby`, `stat`) VALUES('$accountPaymentUnqID', '$invoice_no', '$invoice_date', '$customerUnqID', '', '$idadmin', '$pay_method', '$subtotal_amnt', '0', '0', '0', '0', '$pay_pay_amnt', '$pay_ledger_id', '1', '0', '2', '2', '$narration', '$currentDateTime', '$idadmin', '1')");
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
          mysqli_query($conn,"UPDATE `billing` SET `payment_stat`=1 WHERE `invoice_no`='$invoice_no'");
        }
        $return['success'] = true;
        $return['msg'] = "Invoice Successfully.";
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
  header("X-XSS-Protection: 0");
}
?>