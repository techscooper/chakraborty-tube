<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $stk_dt=mysqli_real_escape_string($conn,$_POST['stk_dt']);
    $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1");
    while($rowProduct=mysqli_fetch_array($getProduct)){
      $productUnqId=$rowProduct['unq_id'];
      $stock_qty=mysqli_real_escape_string($conn,$_POST['product'.$productUnqId]);
      if($stock_qty>0){
        $stockUnqID=getUnqID('stock_master');
        mysqli_query($conn,"INSERT INTO `stock_master`(`unq_id`, `stk_dt`, `typ`, `product_id`, `stock_qty`, `edt`, `eby`, `stat`) VALUES('$stockUnqID', '$currentDate', '10', '$productUnqId', '$stock_qty', '$currentDateTime', '$idadmin', '1')");
      }
    }
    $return['success'] = true;
    $return['msg'] = "Opening Stock Added Successfully.";
    echo json_encode($return);
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