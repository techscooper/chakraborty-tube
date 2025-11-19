<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $unq_id=mysqli_real_escape_string($conn,$_POST['unq_id']);
    $unit_short_name=mysqli_real_escape_string($conn,$_POST['edit_unit_short_name']);
    $unit_value=mysqli_real_escape_string($conn,$_POST['edit_unit_value']);
    $valid = mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE unit_short_name='$unit_short_name' AND stat=1 AND unq_id!='$unq_id'");
    if ($unit_short_name==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Unit Name.";
      echo json_encode($return);
    }
    elseif ($row_valid = mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This Unit Name Already Exists.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE $tableName SET `unit_short_name`='$unit_short_name', `unit_value`='$unit_value' WHERE `unq_id`='$unq_id'");
      $return['success'] = true;
      $return['msg'] = "User Unit Name Updated Successfully.";
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
