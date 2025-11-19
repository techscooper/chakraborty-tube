<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $customer_del_id=mysqli_real_escape_string($conn,base64_decode($_POST['customer_del_id']));
    if ($customer_del_id == ''){
      $return['error'] = true;
      $return['msg'] = "Unknown Error.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE customer_tbl SET stat='-1' WHERE unq_id='$customer_del_id'");
      $return['success'] = true;
      $return['msg'] = "Customer Deleted Successfully.";
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
}
?>