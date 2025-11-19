<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $group_name=mysqli_real_escape_string($conn,$_POST['group_name']);
    if ($group_name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Group Name.";
      echo json_encode($return);
    }
    else{
      $getChk = mysqli_query($conn,"SELECT * FROM `expense_group` WHERE `group_name`='$group_name'");
      if(mysqli_num_rows($getChk)==0){
        aa:
        $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
        $check_uid = mysqli_query($conn,"SELECT * FROM `expense_group` WHERE `unq_id`='$unq_id_unique'");
        if ($row_check_uid = mysqli_fetch_array($check_uid)){
          goto aa;
        }
        else{
          mysqli_query($conn,"INSERT INTO `expense_group`(`unq_id`, `group_name`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique', '$group_name', '$currentDateTime', '$idadmin', '1')");
          $return['success'] = true;
          $return['msg'] = "Group Create Successfully.";
          echo json_encode($return);
        }
      }
      else {
        $return['error'] = true;
        $return['msg'] = "Group Name Already Exists.";
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