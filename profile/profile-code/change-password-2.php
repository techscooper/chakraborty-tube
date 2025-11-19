<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($ckadmin==1) {
    $old_password=mysqli_real_escape_string($conn,$_POST['old_password']);
    $new_password=mysqli_real_escape_string($conn,$_POST['new_pass']);
    $confirm_password=mysqli_real_escape_string($conn,$_POST['confirm_pass']);
    if ($old_password==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Your Current Password.";
      echo json_encode($return);
    }
    elseif ($new_password==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Your New Password.";
      echo json_encode($return);
    }
    elseif ($confirm_password==''){
      $return['error'] = true;
      $return['msg'] = "Please Confirm Your Password.";
      echo json_encode($return);
    }
    elseif ($new_password!=$confirm_password){
      $return['error'] = true;
      $return['msg'] = "Confirm Password did not Match.";
      echo json_encode($return);
    }
    else{
      $old_tbl_pass_hash = get_single_value('login_tbl','u_id',$idadmin,'pass','',$conn);

      if (password_verify($old_password, $old_tbl_pass_hash)){
        $tech_token = base64_encode($new_password);
        $new_usr_pass_hash = password_hash($confirm_password, PASSWORD_DEFAULT);
        mysqli_query($conn,"UPDATE login_tbl SET pass='$new_usr_pass_hash',tech_token='$tech_token' WHERE u_id='$idadmin'");

        $return['success'] = true;
        $return['msg'] = "Password Updated Successfully.";
        echo json_encode($return);
      }
      else{
        $return['error'] = true;
        $return['msg'] = "Invalid Current Password.";
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