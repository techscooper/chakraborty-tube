<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $category_id=mysqli_real_escape_string($conn,$_POST['category_id']);
    $product_name=mysqli_real_escape_string($conn,$_POST['product_name']);
    $unit_id=mysqli_real_escape_string($conn,$_POST['unit_id']);
    $purchase_rate=mysqli_real_escape_string($conn,$_POST['purchase_rate']);
    $sale_rate=mysqli_real_escape_string($conn,$_POST['sale_rate']);
    $hsn_code=mysqli_real_escape_string($conn,$_POST['hsn_code']);
    $cgst=mysqli_real_escape_string($conn,$_POST['cgst']);
    $sgst=mysqli_real_escape_string($conn,$_POST['sgst']);
    $igst=mysqli_real_escape_string($conn,$_POST['igst']);
    $opening_stock=mysqli_real_escape_string($conn,$_POST['opening_stock']);
    $product_descp=mysqli_real_escape_string($conn,addslashes($_POST['product_descp']));
    $valid=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `category_id`='$category_id' AND `product_name`='$product_name' AND `stat`!='-1'");
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
      $unq_id_unique=getUnqID('inventory_tbl');
      mysqli_query($conn,"INSERT INTO `inventory_tbl` (`unq_id`, `category_id`, `product_name`, `purchase_rate`, `sale_rate`, `product_descp`, `unit_id`, `hsn_code`, `cgst`, `sgst`, `igst`, `edt`, `eby`, `stat`) VALUES('$unq_id_unique', '$category_id', '$product_name', '$purchase_rate', '$sale_rate', '$product_descp', '$unit_id', '$hsn_code', '$cgst', '$sgst', '$igst', '$currentDateTime', '$idadmin', '1')");
      $return['success'] = true;
      $return['msg'] = "Product Added Successfully";
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