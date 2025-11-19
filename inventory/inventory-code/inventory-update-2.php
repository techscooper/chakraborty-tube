<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $inventoryUnqID=mysqli_real_escape_string($conn,base64_decode($_POST['inventoryUnqID']));
    $category_id=mysqli_real_escape_string($conn,$_POST['category_id_update']);
    $product_name=mysqli_real_escape_string($conn,$_POST['product_name_update']);
    $unit_id=mysqli_real_escape_string($conn,$_POST['unit_id_update']);
    $purchase_rate=mysqli_real_escape_string($conn,$_POST['purchase_rate_update']);
    $sale_rate=mysqli_real_escape_string($conn,$_POST['sale_rate_update']);
    $hsn_code=mysqli_real_escape_string($conn,$_POST['hsn_code_update']);
    $cgst=mysqli_real_escape_string($conn,$_POST['cgst_update']);
    $sgst=mysqli_real_escape_string($conn,$_POST['sgst_update']);
    $igst=mysqli_real_escape_string($conn,$_POST['igst_update']);
    $product_descp=mysqli_real_escape_string($conn,addslashes($_POST['product_descp_update']));
    $valid=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `category_id`='$category_id' AND `product_name`='$product_name' AND `stat`!='-1' AND `unq_id`!='$inventoryUnqID'");
    if($category_id==''){
      $return['error'] = true;
      $return['msg'] = "Please select category";
      echo json_encode($return);
    }
    elseif($product_name==''){
      $return['error'] = true;
      $return['msg'] = "Please enter product name";
      echo json_encode($return);
    }
    elseif($unit_id==''){
      $return['error'] = true;
      $return['msg'] = "Please select product unit";
      echo json_encode($return);
    }
    elseif($purchase_rate==''){
      $return['error'] = true;
      $return['msg'] = "Please enter purchase rate";
      echo json_encode($return);
    }
    elseif ($sale_rate==''){
      $return['error'] = true;
      $return['msg'] = "Please enter sale rate";
      echo json_encode($return);
    }
    elseif($row_valid=mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This Product Already Exists";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `inventory_tbl` SET `category_id`='$category_id', `product_name`='$product_name', `purchase_rate`='$purchase_rate', `sale_rate`='$sale_rate', `product_descp`='$product_descp', `unit_id`='$unit_id', `hsn_code`='$hsn_code', `cgst`='$cgst', `sgst`='$sgst', `igst`='$igst' WHERE `unq_id`='$inventoryUnqID'");
      $return['success'] = true;
      $return['msg'] = "Product Update Successfully";
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
  header("X-XSS-Protection: 0");
}
?>