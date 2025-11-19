<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $unq_id = $_POST['unq_id'];
    $user_role = $_POST['e_user_role'];
    $nm = $_POST['e_nm'];
    $user_mobile = $_POST['e_user_mobile'];
    $user_email = $_POST['e_user_email'];

    $valid = mysqli_query($conn,"SELECT * FROM login_tbl WHERE mobile_no='$user_mobile' AND u_id!='$unq_id'");

    if ($user_role==''){
      $return['error'] = true;
      $return['msg'] = "Please Select Role / Level.";
      echo json_encode($return);
    }
    elseif ($nm==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Name.";
      echo json_encode($return);
    }
    elseif ($user_mobile==''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Mobile No.";
      echo json_encode($return);
    }
    elseif ($row_valid = mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This User Already Exists.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE $tableName SET lvl='$user_role', full_nm='$nm', mobile_no='$user_mobile', email='$user_email' WHERE $updateUniqueField='$updateUniqueValue'");
      $return['success'] = true;
      $return['msg'] = "User Updated Successfully.";
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