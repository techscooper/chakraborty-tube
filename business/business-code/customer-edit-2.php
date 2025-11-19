<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $customer_nm=mysqli_real_escape_string($conn,$_POST['customer_nm']);
    $email_id=mysqli_real_escape_string($conn,$_POST['email_id']);
    $mobile_no=mysqli_real_escape_string($conn,$_POST['mobile_no']);
    $dob=mysqli_real_escape_string($conn,$_POST['dob']);
    $gst_no=mysqli_real_escape_string($conn,$_POST['gst_no']);
    $pan_no=mysqli_real_escape_string($conn,$_POST['pan_no']);
    $customer_state=mysqli_real_escape_string($conn,$_POST['customer_state']);
    $address_1=mysqli_real_escape_string($conn,addslashes($_POST['address_1']));
    $address_2=mysqli_real_escape_string($conn,addslashes($_POST['address_2']));
    $zip_code=mysqli_real_escape_string($conn,$_POST['zip_code']);
    $c_uid_edt=mysqli_real_escape_string($conn,base64_decode($_POST['c_uid_edt']));
    if ($customer_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Customer Name.";
      echo json_encode($return);
    }
		elseif ($mobile_no == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Mobile Number.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `customer_tbl` SET `customer_nm`='$customer_nm', `email_id`='$email_id', `mobile_no`='$mobile_no', `date_of_birth`='$dob', `gst_no`='$gst_no', `pan_no`='$pan_no', `customer_state_id`='$customer_state', `address_1`='$address_1', `address_2`='$address_2', `zip_code`='$zip_code' WHERE `unq_id`='$c_uid_edt'");

      $return['success'] = true;
      $return['msg'] = "Customer Updated Successfully.";
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
