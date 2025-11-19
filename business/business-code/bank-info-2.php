<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $bank_h_nm=mysqli_real_escape_string($conn,$_POST['bank_h_nm']);
    $bank_nm=mysqli_real_escape_string($conn,$_POST['bank_nm']);
    $bank_ac_no=mysqli_real_escape_string($conn,$_POST['bank_ac_no']);
    $branch_nm=mysqli_real_escape_string($conn,$_POST['branch_nm']);
    $ifsc_code=mysqli_real_escape_string($conn,$_POST['ifsc_code']);
    if ($bank_h_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Bank Holder Name.";
      echo json_encode($return);
    }
		elseif ($bank_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Bank Name.";
      echo json_encode($return);
    }
		elseif ($bank_ac_no == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Bank A/C Number.";
      echo json_encode($return);
    }
		elseif ($branch_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Branch Name.";
      echo json_encode($return);
    }
		elseif ($ifsc_code == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter IFSC Code.";
      echo json_encode($return);
    }
    else{
      aa:
      $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
      $check_uid = mysqli_query($conn,"SELECT * FROM bank_information_tbl WHERE unq_id='$unq_id_unique'");
      if ($row_check_uid = mysqli_fetch_array($check_uid))
      {
        goto aa;
      }
      else
      {
        $getChkPrimaryAc = mysqli_query($conn,"SELECT * FROM bank_information_tbl WHERE primary_stat=1 AND stat=1");
        if(mysqli_num_rows($getChkPrimaryAc)==0){
          mysqli_query($conn,"INSERT INTO `bank_information_tbl`(`unq_id`, `bank_holder_nm`, `bank_nm`, `bank_ac_number`, `branch_nm`, `ifsc_code`, `edt`, `eby`, `primary_stat`, `stat`) VALUES('$unq_id_unique', '$bank_h_nm', '$bank_nm', '$bank_ac_no', '$branch_nm', '$ifsc_code', '$currentDateTime', '$idadmin', '1', '1')");
        }
        else{
          mysqli_query($conn,"INSERT INTO `bank_information_tbl`(`unq_id`, `bank_holder_nm`, `bank_nm`, `bank_ac_number`, `branch_nm`, `ifsc_code`, `edt`, `eby`, `primary_stat`, `stat`) VALUES('$unq_id_unique', '$bank_h_nm', '$bank_nm', '$bank_ac_no', '$branch_nm', '$ifsc_code', '$currentDateTime', '$idadmin', '0', '1')");
        }
        $return['success'] = true;
        $return['msg'] = "Bank Information Inserted Successfully.";
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