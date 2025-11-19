<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $unq_id=mysqli_real_escape_string($conn,$_POST['unq_id']);
    $group_name=mysqli_real_escape_string($conn,$_POST['group_name_update']);
    if ($group_name == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Group Name.";
      echo json_encode($return);
    }
    else{
      $getChk = mysqli_query($conn,"SELECT * FROM `expense_group` WHERE `group_name`='$group_name' AND `unq_id`!='$unq_id'");
      if(mysqli_num_rows($getChk)==0){
        mysqli_query($conn,"UPDATE `expense_group` SET `group_name`='$group_name' WHERE `unq_id`='$unq_id'");
        $return['success'] = true;
        $return['msg'] = "Group Update Successfully.";
        echo json_encode($return);
      }
      else {
        $return['error'] = true;
        $return['msg'] = "Group Already Exists.";
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