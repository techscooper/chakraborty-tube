<?php
include '../../config.php';
if($ckadmin==1){
  $pay_method=mysqli_real_escape_string($conn,$_REQUEST['pay_method']);
  if($pay_method==""){ $payMethod="AND `sl`=0"; } elseif ($pay_method==1){ $payMethod="AND `sl`=1"; } else { $payMethod="AND `sl`!=1"; }
  ?>
  <select class="form-control form-control-sm" name="ledger_id" id="ledger_id">
    <?php if($pay_method==''){ ?> <option value="">-- Select --</option><?php }
    $getPaymentLedger=mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `stat`=1 $payMethod ORDER BY `edit_stat` DESC, `sl`");
    while ($rowPaymentLedger=mysqli_fetch_array($getPaymentLedger)){
      $ledger_unq_id = $rowPaymentLedger['unq_id'];
      $ledger_name = $rowPaymentLedger['ledger_name'];
      ?><option value="<?php echo $ledger_unq_id;?>"><?php echo $ledger_name;?></option><?php
    }
    ?>
  </select>
<?php
}
?>