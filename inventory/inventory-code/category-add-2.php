<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $category_nm=mysqli_real_escape_string($conn,$_POST['category_nm']);
    if ($category_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Category Name.";
      echo json_encode($return);
    }
    else{
      $unq_id_unique=getUnqID('inventory_category');
      mysqli_query($conn,"INSERT INTO `inventory_category`(`unq_id`, `category_name`, `edt`, `eby`, `stat`) VALUES('$unq_id_unique', '$category_nm', '$currentDateTime', '$idadmin', '1')");
      $return['success'] = true;
      $return['msg'] = "Category Added Successfully.";
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
}
?>