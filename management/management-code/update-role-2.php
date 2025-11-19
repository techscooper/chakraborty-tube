<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $user_level_nm=mysqli_real_escape_string($conn,$_POST['level_nm']);
    $l_rank=mysqli_real_escape_string($conn,$_POST['rank']);
    $unq_id=mysqli_real_escape_string($conn,$_POST['unq_id']);
    $valid = mysqli_query($conn,"SELECT * FROM user_level WHERE user_level_nm='$user_level_nm' AND stat=1 AND unq_id!='$unq_id'");
    if ($user_level_nm==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Role / Level.";
      echo json_encode($return);
    }
    elseif ($row_valid = mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This User Role / Level Already Exists.";
      echo json_encode($return);
    }
		elseif ($l_rank==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Rank.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `user_level` SET `user_level_nm`='$user_level_nm', `l_rank`='$l_rank' WHERE `unq_id`='$unq_id'");

      $return['success'] = true;
      $return['msg'] = "User Role / Level Updated Successfully.";
      echo json_encode($return);
    }
  }
  else {
    $return['error'] = true;
    $return['msg'] = "Server timeout, login session expired.";
    echo json_encode($return);
  }
}
else{
  header('location:../../');
}
?>