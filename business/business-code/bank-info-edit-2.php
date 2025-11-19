<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $Bank_Holder_Name=mysqli_real_escape_string($conn,$_POST['bank_h_nm_e']);
    $Bank_Name=mysqli_real_escape_string($conn,$_POST['bank_nm_e']);
    $Bank_acount_Number=mysqli_real_escape_string($conn,$_POST['bank_ac_no_e']);
    $Branch_Name=mysqli_real_escape_string($conn,$_POST['branch_nm_e']);
    $IFSC_Code=mysqli_real_escape_string($conn,$_POST['ifsc_code_e']);
    $bank_info_unq_id=mysqli_real_escape_string($conn,base64_decode($_POST['bank_info_unq_id']));
    if ($Bank_Holder_Name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Bank Holder Name.";
      echo json_encode($return);
    }
    elseif ($Bank_Name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Bank Name.";
      echo json_encode($return);
    }
    elseif ($Bank_acount_Number == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Bank Acount Number.";
      echo json_encode($return);
    }
    elseif ($Branch_Name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Brancj Number.";
      echo json_encode($return);
    }
    elseif ($IFSC_Code == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter IFSC Code.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `bank_information_tbl` SET `bank_holder_nm`='$Bank_Holder_Name', `bank_nm`='$Bank_Name', `bank_ac_number`='$Bank_acount_Number', `branch_nm`='$Branch_Name', `ifsc_code`='$IFSC_Code' WHERE `unq_id`='$bank_info_unq_id'");
      $return['success'] = true;
      $return['msg'] = "Bank Information Updated Successfully.";
      echo json_encode($return);
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