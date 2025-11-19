<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $ledger_name=mysqli_real_escape_string($conn,$_POST['ledger_name']);
    $opening_balance=mysqli_real_escape_string($conn,$_POST['opening_balance']);
    if ($ledger_name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Ledger Name.";
      echo json_encode($return);
    }
    elseif ($opening_balance == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Opening Balance.";
      echo json_encode($return);
    }
    else{
      $getChk = mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `ledger_name`='$ledger_name'");
      if(mysqli_num_rows($getChk)==0){
        aa:
        $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
        $check_uid = mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `unq_id`='$unq_id_unique'");
        if ($row_check_uid = mysqli_fetch_array($check_uid)){
          goto aa;
        }
        else{
          mysqli_query($conn,"INSERT INTO `expense_ledger`(`unq_id`, `ledger_name`, `edt`, `eby`, `edit_stat`, `stat`) VALUES ('$unq_id_unique', '$ledger_name', '$currentDateTime', '$idadmin', '0', '1')");

          //Account Master (Add Opening) | Start
          aa2:
          $ac_unique_id1 = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
          $check_ac_uid1 = mysqli_query($conn,"SELECT * FROM `account_master` WHERE `unq_id`='$ac_unique_id1'");
          if ($row_check_ac_uid1 = mysqli_fetch_array($check_ac_uid1)){
            goto aa2;
          }
          else{
            $remark = 'Opening Ledger';
            mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `ledger_id`, `dr`, `cr`, `type`, `level`, `remark`,  `edt`, `eby`, `stat`) VALUES
            ('$ac_unique_id1', '', '$currentDateTime', '', '', '$idadmin', '0', '0', '0', '0', '0', '0', '$opening_balance', '$unq_id_unique', '1', '0', '0', '2', '$remark', '$currentDateTime', '$idadmin', '1')");
          }
          //Account Master (Add Opening) | End

          $return['success'] = true;
          $return['msg'] = "Ledger Name Inserted Successfully.";
          echo json_encode($return);
        }
      }
      else {
        $return['error'] = true;
        $return['msg'] = "Ledger Name, Already Exists.";
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