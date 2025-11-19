<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $s_uid_edt=mysqli_real_escape_string($conn,base64_decode($_POST['s_uid_edt']));
    $supplier_nm=mysqli_real_escape_string($conn,$_POST['supplier_nm']);
    $email_id=mysqli_real_escape_string($conn,$_POST['email_id']);
    $mobile_no=mysqli_real_escape_string($conn,$_POST['mobile_no']);
    $gst_no=mysqli_real_escape_string($conn,$_POST['gst_no']);
    $supplier_state=mysqli_real_escape_string($conn,$_POST['supplier_state']);
    $address_1=mysqli_real_escape_string($conn,addslashes($_POST['address_1']));
    $address_2=mysqli_real_escape_string($conn,addslashes($_POST['address_2']));
    $zip_code=mysqli_real_escape_string($conn,$_POST['zip_code']);
    if ($supplier_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Supplier Name.";
      echo json_encode($return);
    }
		elseif ($mobile_no == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Mobile Number.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `supplier_tbl` SET `supplier_nm`='$supplier_nm', `email_id`='$email_id', `mobile_no`='$mobile_no', `gst_no`='$gst_no', `supplier_state_id`='$supplier_state', `address_1`='$address_1', `address_2`='$address_2', `zip_code`='$zip_code' WHERE `unq_id`='$s_uid_edt'");
      $return['success'] = true;
      $return['msg'] = "Supplier Updated Successfully.";
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