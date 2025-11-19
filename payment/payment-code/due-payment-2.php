<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $invoice_no=mysqli_real_escape_string($conn,$_POST['invoice_no']);
    $pay_date=mysqli_real_escape_string($conn,$_POST['pay_date']);

    //Payment | Start
    $getPay1=mysqli_query($conn,"SELECT * FROM `billing_payment_method_temp` WHERE `stat`=1 AND `invoice_no`='$invoice_no'");
    if(mysqli_num_rows($getPay1)>0){
      while ($rowPayment=mysqli_fetch_array($getPay1)){
        $pay_unq_id = $rowPayment['unq_id'];
        $pay_date_time = $rowPayment['pay_date_time'];
        $pay_method = $rowPayment['pay_method'];
        $ledger_id = $rowPayment['ledger_id'];
        $pay_pay_amnt = $rowPayment['pay_amnt'];
        $narration = $rowPayment['narration'];

        aa5:
        $ac_unique_id2 = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
        $check_ac_uid2 = mysqli_query($conn,"SELECT * FROM `account_master` WHERE `unq_id`='$ac_unique_id2'");
        if ($row_check_ac_uid2 = mysqli_fetch_array($check_ac_uid2)){
          goto aa5;
        }
        else{
          $customer_unq_id = get_single_value("billing","invoice_no",$invoice_no,"customer_id","",$conn);
          $subtotal_amnt = get_single_value("account_master","invoice_no",$invoice_no,"taxable_value"," AND `type`=2 AND `level`=1",$conn);

          mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `ledger_id`, `dr`, `cr`, `type`, `level`, `remark`, `edt`, `eby`, `stat`) VALUES
          ('$ac_unique_id2', '$invoice_no', '$pay_date_time', '$customer_unq_id', '', '$idadmin', '$pay_method', '$subtotal_amnt', '0', '0', '0', '0', '$pay_pay_amnt', '$ledger_id', '1', '0', '2', '2', '$narration', '$currentDateTime', '$idadmin', '1')");
        }
        mysqli_query($conn,"DELETE FROM `billing_payment_method_temp` WHERE `unq_id` = '$pay_unq_id'");
      }

      $payAmntChk = 0;
      $getPayChk1=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `pay_amnt1` FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=2 AND `invoice_no`='$invoice_no'");
      while ($rowPayChk1=mysqli_fetch_array($getPayChk1)){
        $payAmntChk = $rowPayChk1['pay_amnt1'];
      }
      $net_amnt=get_single_value("account_master","invoice_no",$invoice_no,"net_amount"," AND `type`=2 AND `level`=1",$conn);
      if($payAmntChk==$net_amnt){
        mysqli_query($conn,"UPDATE `billing` SET `payment_stat` = 1 WHERE `invoice_no` = '$invoice_no'");
      }

      $return['success'] = true;
      $return['msg'] = "Invoice Payment Successfully.";
      $return['customer_id'] = $customer_unq_id;
      $return['invoice_no'] = $invoice_no;
      echo json_encode($return);
    }
    else {
      $return['error'] = true;
      $return['msg'] = "Please Add Amount";
      echo json_encode($return);
    }
    //Payment | End
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