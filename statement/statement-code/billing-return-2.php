<?php
include '../../config.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if($ckadmin==1){
    $invoice_no=mysqli_real_escape_string($conn,$_POST['invoice_no']);
    $return_invoice_date=mysqli_real_escape_string($conn,$_POST['return_invoice_date']);
    $return_invoice_no=mysqli_real_escape_string($conn,$_POST['return_invoice_no']);
    $itemRemoveAmount = $itemRemoveAmountTotal = 0;
    $getAmount=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `stat`=0 AND `invoice_no`='$invoice_no'");
    while($rowAmount=mysqli_fetch_array($getAmount)) {
      $item_unq_id=$rowAmount['item_unq_id'];
      $member_id=$rowAmount['member_id'];
      $invoice_no=$rowAmount['invoice_no'];
      $product_id=$rowAmount['product_id'];
      $quantity=$rowAmount['quantity'];
      $amount=$rowAmount['amount'];
      $itemRemoveAmount=$quantity*$amount;
      $itemRemoveAmountTotal+=$itemRemoveAmount;
      $itemReturnUnqID=getUnqID('billing_product_item_return');
      mysqli_query($conn,"INSERT INTO `billing_product_item_return`(`unq_id`, `member_id`, `invoice_no`, `product_id`, `quantity`, `amount`, `edt`, `eby`, `stat`) VALUES('$itemReturnUnqID', '$member_id', '$invoice_no', '$product_id', '$quantity', '$amount', '$currentDateTime', '$idadmin', '1')");
      
      $unq_id_unique_stock=getUnqID('stock_master');
      mysqli_query($conn,"INSERT INTO `stock_master`(`unq_id`, `invoice_no`, `return_no`, `stk_dt`, `typ`, `product_id`, `worker_id`, `stock_qty`, `qty_sm_value`, `edt`, `eby`, `stat`) VALUES ('$unq_id_unique_stock', '$invoice_no', '$return_invoice_no', '$return_invoice_date', '30', '$product_id', '', '$quantity', '', '$currentDateTime', '$idadmin', '1')");

      mysqli_query($conn,"DELETE FROM `billing_product_item` WHERE `unq_id`='$item_unq_id'");
    }
    $itemAmount = $itemAmountTotal = 0;
    $getProductItem=mysqli_query($conn,"SELECT * FROM `billing_product_item` WHERE `invoice_no`='$invoice_no'");
    while($rowProductItem=mysqli_fetch_array($getProductItem)) {
      $unq_id=$rowProductItem['unq_id'];
      $product_id=$rowProductItem['product_id'];
      $quantity=$rowProductItem['quantity'];
      $amount=$rowProductItem['amount'];
      $itemAmount=$quantity*$amount;
      $itemAmountTotal+=$itemAmount;
    }
    mysqli_query($conn,"UPDATE `billing` SET `subtotal_amnt`='$itemAmountTotal', `net_amnt`='$itemAmountTotal', `return_stat`=1 WHERE `invoice_no`='$invoice_no'");
    mysqli_query($conn,"UPDATE `billing_return` SET `subtotal_amnt`='$itemRemoveAmountTotal', `net_amnt`='$itemRemoveAmountTotal', `return_stat`=1 WHERE `invoice_no`='$invoice_no'");
    
   
    $remark = 'Refund';
    $ac_unique_id1=getUnqID('account_master');
    mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `refund_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `dr`, `cr`, `type`, `level`, `remark`,  `edt`, `eby`, `stat`) VALUES('$ac_unique_id1', '$invoice_no', '$return_invoice_no', '$return_invoice_date', '$member_id', '', '$idadmin', '1', '$itemRemoveAmountTotal', '0', '0', '0', '0', '$itemRemoveAmountTotal', '0', '1', '2', '-1', '$remark', '$currentDateTime', '$idadmin', '1')");
    
    $return['success'] = true;
    $return['msg'] = "Invoice Successfully.";
    $return['customer_id'] = $member_id;
    $return['invoice_no'] = $invoice_no;
    $return['refund_amount'] = $itemRemoveAmountTotal;
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