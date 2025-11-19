<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $pay_date=mysqli_real_escape_string($conn,$_POST['pay_date']);
    $invoice_no=mysqli_real_escape_string($conn,$_POST['invoice_no']);
    $net_amnt=mysqli_real_escape_string($conn,$_POST['net_amnt']);
    $pay_method=mysqli_real_escape_string($conn,$_POST['pay_method']);
    $ledger_id=mysqli_real_escape_string($conn,$_POST['ledger_id']);
    $pay_amnt=mysqli_real_escape_string($conn,$_POST['pay_amnt']);
    $narration=mysqli_real_escape_string($conn,$_POST['narration']);
    $valid = mysqli_query($conn,"SELECT * FROM `billing_payment_method_temp` WHERE `invoice_no`='$invoice_no' AND `pay_method`='$pay_method'");
    $getPaidAmount = mysqli_query($conn,"SELECT SUM(`pay_amnt`) AS `pay_amnt` FROM `billing_payment_method_temp` WHERE `invoice_no`='$invoice_no' AND `pay_typ`=1");
    while ($rowPaidAmount = mysqli_fetch_array($getPaidAmount)) {
      $paidAmount = $rowPaidAmount['pay_amnt'];
    }
    if ($net_amnt == ''){
      $return['error'] = true;
      $return['msg'] = "Please Add Product";
      echo json_encode($return);
    }
    elseif ($pay_method == ''){
      $return['error'] = true;
      $return['msg'] = "Please Select Payment Method";
      echo json_encode($return);
    }
    elseif ($pay_amnt == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Amount";
      echo json_encode($return);
    }
    elseif (($net_amnt - $paidAmount) < $pay_amnt){
      $return['error'] = true;
      $return['msg'] = "Please Enter Valid Amount";
      echo json_encode($return);
    }
    elseif ($row_valid=mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This Payment Method Already Exists";
      echo json_encode($return);
    }
    else{
      aa:
      $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
      $check_uid = mysqli_query($conn,"SELECT * FROM `billing_payment_method_temp` WHERE `unq_id`='$unq_id_unique'");
      if ($row_check_uid = mysqli_fetch_array($check_uid)){
        goto aa;
      }
      else{
        $pay_date_time = date('Y-m-d',strtotime($pay_date)).' '.date('H:i:s');
        $tablePayment = $due_amnt = $paidAmount = 0;

        $getAcountMaster=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `paidAmount` FROM `account_master` WHERE `stat`=1 AND `invoice_no`='$invoice_no' AND `type`=2 AND `level`=2");
        while ($rowAcountMaster=mysqli_fetch_array($getAcountMaster)){
          $paidAmount = $rowAcountMaster['paidAmount'];
        }
        $getProductTemp1=mysqli_query($conn,"SELECT SUM(`pay_amnt`) AS `tablePayment` FROM `billing_payment_method_temp` WHERE `stat`=1 AND `pay_typ`=1 AND `invoice_no`='$invoice_no'");
        while ($rowProductTemp1=mysqli_fetch_array($getProductTemp1)){
          $tablePayment = $rowProductTemp1['tablePayment'];
        }

        $due_amnt = (int)$net_amnt - (int)$paidAmount - (int)$tablePayment - (int)$pay_amnt;
        mysqli_query($conn,"INSERT INTO `billing_payment_method_temp`(`unq_id`, `invoice_no`, `pay_date_time`, `pay_typ`, `pay_method`, `ledger_id`, `net_amnt`, `pay_amnt`, `due_amnt`, `narration`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique', '$invoice_no', '$pay_date_time', '1', '$pay_method', '$ledger_id', '$net_amnt', '$pay_amnt', '$due_amnt', '$narration', '$currentDateTime', '$idadmin', '1')");

        $return['success'] = true;
        $return['msg'] = "Payment Successfully.";
        $return['invoice_no'] = $invoice_no;
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