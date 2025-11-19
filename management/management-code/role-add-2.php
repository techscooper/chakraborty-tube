<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($ckadmin==1) {
    $user_level_nm=mysqli_real_escape_string($conn,$_POST['user_level_nm']);
    $l_rank=mysqli_real_escape_string($conn,$_POST['l_rank']);
    $valid = mysqli_query($conn,"SELECT * FROM user_level WHERE user_level_nm='$user_level_nm' AND stat=1");
    if ($user_level_nm == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Role / Level.";
      echo json_encode($return);
    }
    elseif ($l_rank == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Rank.";
      echo json_encode($return);
    }
    elseif ($row_valid = mysqli_fetch_array($valid)) {
      $return['error'] = true;
      $return['msg'] = "This User Role / Level Already Exists.";
      echo json_encode($return);
    }
    else {
      $unq_id_unique=getUnqID('user_level');
      mysqli_query($conn,"INSERT INTO `user_level`(`unq_id`, `user_level_nm`, `l_rank`, `edt`, `eby`, `updt_stat`, `stat`) VALUES('$unq_id_unique', '$user_level_nm', '$l_rank', '$currentDateTime', '$idadmin', '1', '1')");
      $return['success'] = true;
      $return['msg'] = "User Role / Level Created Successfully.";
      echo json_encode($return);
    }
  }
  else {
    $return['error'] = true;
    $return['msg'] = "Server timeout, login session expired.";
    echo json_encode($return);
  }
}
else {
  header('location:../../');
  header("X-XSS-Protection: 0");
}
?>