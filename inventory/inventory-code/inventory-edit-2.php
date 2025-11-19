<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $inv_uid_edt=mysqli_real_escape_string($conn,base64_decode($_POST['inv_uid_edt']));
    $category=mysqli_real_escape_string($conn,$_POST['category_edit']);
    $product_nm=mysqli_real_escape_string($conn,$_POST['product_nm_edit']);
    $product_code_edit=mysqli_real_escape_string($conn,$_POST['product_code_edit']);
    $sale_rate=mysqli_real_escape_string($conn,$_POST['sale_rate_edit']);
    $descp=mysqli_real_escape_string($conn,addslashes($_POST['descp_edit']));
    $product_unit=mysqli_real_escape_string($conn,$_POST['product_unit_edit']);
    $cgst=mysqli_real_escape_string($conn,$_POST['cgst_edit']);
    $sgst=mysqli_real_escape_string($conn,$_POST['sgst_edit']);
    $igst=mysqli_real_escape_string($conn,$_POST['igst_edit']);

    $valid = mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `category_id`='$category' AND `product_code`='$product_code_edit' AND stat=1 AND unq_id!='$inv_uid_edt'");

    if ($category == ''){
      $return['error'] = true;
      $return['msg'] = "Please Select Category.";
      echo json_encode($return);
    }
    elseif ($product_code_edit == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Product Code.";
      echo json_encode($return);
    }
    elseif ($product_nm == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Product Name.";
      echo json_encode($return);
    }
    elseif ($sale_rate == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Sales Rate.";
      echo json_encode($return);
    }
    elseif ($product_unit == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Product Unit.";
      echo json_encode($return);
    }
    elseif ($row_valid=mysqli_fetch_array($valid)){
      $return['error'] = true;
      $return['msg'] = "This Code Already Exists.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `inventory_tbl` SET `category_id`='$category', `product_code`='$product_code_edit', `product_name`='$product_nm', `sale_rate`='$sale_rate', `product_descp`='$descp', `product_unit`='$product_unit', `cgst`='$cgst', `sgst`='$sgst', `igst`='$igst' WHERE `unq_id`='$inv_uid_edt'");
      $return['success'] = true;
      $return['msg'] = "Inventory Updated Successfully.";
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