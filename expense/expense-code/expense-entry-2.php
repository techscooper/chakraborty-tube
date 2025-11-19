<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $ledger_id=mysqli_real_escape_string($conn,$_POST['ledger_id']);
    $expense_group_id=mysqli_real_escape_string($conn,$_POST['expense_group_id']);
    $bill_date=mysqli_real_escape_string($conn,$_POST['bill_date']);
    $net_amount=mysqli_real_escape_string($conn,$_POST['net_amount']);
    $remark=mysqli_real_escape_string($conn,$_POST['remark']);

    if ($ledger_id == ''){
      $return['error'] = true;
      $return['msg'] = "Please Select Ledger.";
      echo json_encode($return);
    }
    elseif ($expense_group_id == '') {
      $return['error'] = true;
      $return['msg'] = "Please Select Group.";
      echo json_encode($return);
    }
    elseif ($bill_date == '') {
      $return['error'] = true;
      $return['msg'] = "Please Select Date.";
      echo json_encode($return);
    }
    elseif ($net_amount == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Amount.";
      echo json_encode($return);
    }
    else{
      aa:
      $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
      $check_uid = mysqli_query($conn,"SELECT * FROM `account_master` WHERE `unq_id`='$unq_id_unique'");
      if ($row_check_uid = mysqli_fetch_array($check_uid)){
        goto aa;
      }
      else{
        aa2:
        $unq_id_unique_tran = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
        $check_uid_tran = mysqli_query($conn,"SELECT * FROM `account_master` WHERE `transaction_id`='$unq_id_unique_tran'");
        if ($row_check_uid_tran = mysqli_fetch_array($check_uid_tran)){
          goto aa2;
        }
        else{
          mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `transaction_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `ledger_id`, `expense_group_id`, `dr`, `cr`, `type`, `level`, `remark`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique', '$unq_id_unique_tran', '', '$bill_date', '', '', '$idadmin', '1', '0', '0', '0', '0', '0', '$net_amount', '$ledger_id', '$expense_group_id', '1', '0', '3', '2', '$remark', '$currentDateTime', '$idadmin', '1')");
          $return['success'] = true;
          $return['msg'] = "Expense Entry Successfully.";
          echo json_encode($return);
        }
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