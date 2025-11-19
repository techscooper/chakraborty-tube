<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($ckadmin==1) {
    $full_nm=mysqli_real_escape_string($conn,$_POST['nm']);
    $user_mobile=mysqli_real_escape_string($conn,$_POST['user_mobile']);
    $user_email=mysqli_real_escape_string($conn,$_POST['user_email']);
    $user_role=mysqli_real_escape_string($conn,$_POST['user_role']);
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $npassword=mysqli_real_escape_string($conn,$_POST['npassword']);
    $cpassword=mysqli_real_escape_string($conn,$_POST['cpassword']);

    $valid = mysqli_query($conn,"SELECT * FROM login_tbl WHERE u_id='$username'");

    if ($full_nm == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Name.";
      echo json_encode($return);
    }
    elseif ($user_mobile == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Mobile.";
      echo json_encode($return);
    }
    elseif ($user_role == '') {
      $return['error'] = true;
      $return['msg'] = "Please Select User Role.";
      echo json_encode($return);
    }
    elseif ($username == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Username.";
      echo json_encode($return);
    }
    elseif ($npassword == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter New Password.";
      echo json_encode($return);
    }
    elseif ($cpassword == '') {
      $return['error'] = true;
      $return['msg'] = "Please Enter Confirm Password.";
      echo json_encode($return);
    }
    elseif ($row_valid = mysqli_fetch_array($valid)) {
      $return['error'] = true;
      $return['msg'] = "This User Username Already Exists.";
      echo json_encode($return);
    }
    else {
      if ($npassword != $cpassword) {
        $return['error'] = true;
        $return['msg'] = "The password and confirmation password do not match.";
        echo json_encode($return);
      }
      else {
        $newPassHash = password_hash($cpassword, PASSWORD_DEFAULT);
        $verify_code = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 6 );
        $tech_token = base64_encode($cpassword);
        mysqli_query($conn,"INSERT INTO login_tbl(u_id, full_nm, pass, tech_token, email, mobile_no, verification, joining, stat, lvl, e_v_stat, m_verify_stat, dp_pic) VALUES ('$username', '$full_nm', '$newPassHash', '$tech_token', '$user_email', '$user_mobile', '$verify_code', '$currentDateTime', '1', '$user_role', '1', '1', 'default.jpg')");

        $return['success'] = true;
        $return['msg'] = "User Created Successfully.";
        echo json_encode($return);
      }
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