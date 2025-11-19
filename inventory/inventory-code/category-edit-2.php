<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $category_edt=mysqli_real_escape_string($conn,$_POST['category_edt']);
    $category_uid_edt = base64_decode($_POST['category_uid_edt']);
    if ($category_edt == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Category Name.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE inventory_category_table SET category='$category_edt' WHERE unq_id='$category_uid_edt' And stat=1");
      $return['success'] = true;
      $return['msg'] = "Categroy Updated Successfully.";
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
}
?>