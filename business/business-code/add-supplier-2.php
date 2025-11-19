<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
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
      aa:
      $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
      $check_uid = mysqli_query($conn,"SELECT * FROM supplier_tbl WHERE unq_id='$unq_id_unique'");
      if ($row_check_uid = mysqli_fetch_array($check_uid))
      {
        goto aa;
      }
      else{
				mysqli_query($conn,"INSERT INTO `supplier_tbl`(`sl`, `unq_id`, `supplier_nm`, `email_id`, `mobile_no`, `gst_no`, `supplier_state_id`,`address_1`,`address_2`,`zip_code`,`edt`,`eby`, `stat`) VALUES (NULL,'$unq_id_unique','$supplier_nm','$email_id','$mobile_no','$gst_no','$supplier_state','$address_1','$address_2','$zip_code','$currentDateTime','$idadmin','1')");

        $return['success'] = true;
        $return['msg'] = "Supplier Inserted Successfully.";
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