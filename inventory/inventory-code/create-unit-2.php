<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $unit_short_name=mysqli_real_escape_string($conn,$_POST['unit_short_name']);
    $unit_value=mysqli_real_escape_string($conn,$_POST['unit_value']);
    $valid = mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `unit_short_name`='$unit_short_name' AND `stat`=1");

    if ($unit_short_name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Unit Name.";
      echo json_encode($return);
    }
    if ($unit_value == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Unit Value.";
      echo json_encode($return);
    }
    elseif ($row_valid = mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This Unit Name Already Exists.";
      echo json_encode($return);
    }
    else{
      aa:
      $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
      $check_uid = mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `unq_id`='$unq_id_unique'");
      if ($row_check_uid = mysqli_fetch_array($check_uid))
      {
        goto aa;
      }
      else
      {
				mysqli_query($conn,"INSERT INTO `unit_tbl`(`unq_id`, `unit_short_name`, `unit_value`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique', '$unit_short_name', '$unit_value', '$currentDateTime', '$idadmin', '1')");

        $return['success'] = true;
        $return['msg'] = "Product Unit Name Submitted Successfully.";
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