<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $bank_info_unq_id=mysqli_real_escape_string($conn,base64_decode($_POST['bank_info_unq_id']));
    if ($bank_info_unq_id == ''){
      $return['error'] = true;
      $return['msg'] = "Unknown Error.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE  `bank_information_tbl` SET `stat`='-1' WHERE `unq_id`='$bank_info_unq_id'");
      $return['success'] = true;
      $return['msg'] = "Bank Information Deleted Successfully.";
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