<?php
include '../../config.php';
if($ckadmin==1){
  $emp_id=mysqli_real_escape_string($conn,$_REQUEST['emp_id']);
  $stock_qty=mysqli_real_escape_string($conn,$_REQUEST['stock_qty']);
  $product_id=mysqli_real_escape_string($conn,$_REQUEST['product_id']);
  $typ=mysqli_real_escape_string($conn,$_REQUEST['typ']);
  $getProductChk=mysqli_query($conn,"SELECT * FROM `product_add_temp` WHERE `emp_id`='$emp_id' AND `product_id`='$product_id' AND `typ`='$typ'");
  $rcntProductChk=mysqli_num_rows($getProductChk);
  if($rcntProductChk==0){
    mysqli_query($conn,"INSERT INTO `product_add_temp`(`typ`, `emp_id`, `product_id`, `stock_qty`, `edt`, `eby`) VALUES ('$typ', '$emp_id', '$product_id', '$stock_qty', '$currentDateTime', '$idadmin')");
  }
  else{
    mysqli_query($conn,"UPDATE `product_add_temp` SET `stock_qty`='$stock_qty' WHERE `emp_id`='$emp_id' AND `product_id`='$product_id' AND `typ`='$typ'");
  }
}
?>