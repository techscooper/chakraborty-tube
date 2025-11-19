<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $unq_id=mysqli_real_escape_string($conn,$_POST['unq_id']);
    $ledger_name=mysqli_real_escape_string($conn,$_POST['ledger_name_update']);
    $opening_balance=mysqli_real_escape_string($conn,$_POST['opening_balance_update']);
    if($unq_id == ''){
      $return['error'] = true;
      $return['msg'] = "Undefined error";
      echo json_encode($return);
    }
    elseif ($ledger_name == ''){
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
      $getChk = mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `ledger_name`='$ledger_name' AND `unq_id`!='$unq_id'");
      if(mysqli_num_rows($getChk)==0){
        mysqli_query($conn,"UPDATE `expense_ledger` SET `ledger_name`='$ledger_name' WHERE `unq_id`='$unq_id'");
        $openingBalanceUnqID=get_single_value("account_master","ledger_id",$unq_id,"unq_id","AND `type`=0 AND `level`=1");
        if($openingBalanceUnqID==""){
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
            ('$ac_unique_id1', '', '$currentDateTime', '', '', '$idadmin', '0', '0', '0', '0', '0', '0', '$opening_balance', '$unq_id', '1', '0', '0', '2', '$remark', '$currentDateTime', '$idadmin', '1')");
          }
          //Account Master (Add Opening) | End
        }
        mysqli_query($conn,"UPDATE `account_master` SET `net_amount`='$opening_balance' WHERE `unq_id`='$openingBalanceUnqID'");

        $return['success'] = true;
        $return['msg'] = "Ledger Name Update Successfully.";
        echo json_encode($return);
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