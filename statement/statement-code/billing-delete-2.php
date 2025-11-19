<?php
include '../../config.php';
if($ckadmin==1){
  $invoice_no = mysqli_real_escape_string($conn,base64_decode($_REQUEST['invoice_no']));
  mysqli_query($conn,"UPDATE `billing` SET `stat` = '-1' WHERE `invoice_no` = '$invoice_no'");
  mysqli_query($conn,"UPDATE `billing_product_item` SET `stat` = '-1' WHERE `invoice_no` = '$invoice_no'");
  mysqli_query($conn,"UPDATE `stock_master` SET `stat` = '-1' WHERE `invoice_no` = '$invoice_no'");

  $returnAmount = 0;
  $getPayChk1=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `pay_amnt1`, `customer_id`, `taxable_value` FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=2 AND `invoice_no`='$invoice_no'");
  while ($rowPayChk1=mysqli_fetch_array($getPayChk1)){
    $returnAmount = $rowPayChk1['pay_amnt1'];
    $customer_id = $rowPayChk1['customer_id'];
    $taxable_value = $rowPayChk1['taxable_value'];
  }

  if ($returnAmount>0) {
    //Refund | Start
    aa3:
    $ac_unique_id1 = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
    $check_ac_uid1 = mysqli_query($conn,"SELECT * FROM `account_master` WHERE `unq_id`='$ac_unique_id1'");
    if ($row_check_ac_uid1 = mysqli_fetch_array($check_ac_uid1)){
      goto aa3;
    }
    else{
      //Refund No || Start
      $cy1 = date('y');
      $cy2 = $cy1 + 1;
      $pre = get_single_value('billing_serise_tbl','sl','1','refund_series','',$conn);
      $id=$pre.'/'.$cy1.'-'.$cy2.'/';
      $refund_no = '00000000000000';
      $get=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `refund_no` LIKE '$id%' ORDER BY `sl` DESC LIMIT 0,1");
      while($row=mysqli_fetch_array($get)){
        $refund_no=$row['refund_no'];
      }
      $count=1;
      $vid=substr($refund_no,11,4);
      while($count>0){
        $vid=$vid+1;
        $refund_no=$id.str_pad($vid, 4, '0', STR_PAD_LEFT);
        $query=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `refund_no`='$refund_no'");
        $count=mysqli_num_rows($query);
      }
      //Refund No || End
      $ledger_id = '10517731'; // for cash
      $remark = 'Refund';
      mysqli_query($conn,"INSERT INTO `account_master`(`unq_id`, `invoice_no`, `refund_no`, `bill_date`, `customer_id`, `supplier_id`, `user_id`, `pay_method`, `taxable_value`, `cgst`, `sgst`, `igst`, `gst`, `net_amount`, `ledger_id`, `dr`, `cr`, `type`, `level`, `remark`,  `edt`, `eby`, `stat`) VALUES
      ('$ac_unique_id1', '$invoice_no', '$refund_no', '$currentDateTime', '$customer_id', '', '$idadmin', '1', '$taxable_value', '0', '0', '0', '0', '$returnAmount', '$ledger_id', '0', '1', '2', '-1', '$remark', '$currentDateTime', '$idadmin', '1')");
    }
    //Refund | End
  }
}
?>
<script type="text/javascript">
  show_list_div();
</script>