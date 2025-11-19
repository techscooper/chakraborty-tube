<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $category_del_id=mysqli_real_escape_string($conn,base64_decode($_POST['category_del_id']));
    if ($category_del_id == ''){
      $return['error'] = true;
      $return['msg'] = "Unknown Error.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `inventory_category_table` SET `stat`='-1' WHERE `unq_id`='$category_del_id'");
      $return['success'] = true;
      $return['msg'] = "Category Deleted Successfully.";
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