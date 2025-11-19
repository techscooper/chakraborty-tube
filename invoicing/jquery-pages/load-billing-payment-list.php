<?php
include '../../config.php';
if($ckadmin==1){
  $invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
  $amountCount = 0;
  $getPay=mysqli_query($conn,"SELECT * FROM `billing_payment_method_temp` WHERE `stat`=1 AND `invoice_no`='$invoice_no' ORDER BY `sl` ASC");
  if(mysqli_num_rows($getPay)>0){
?>
<table style="width:100%; border: 1px solid black;">
 <thead>
   <tr>
     <th class="text-center" style="width:5%; border: 1px solid black;">Action</th>
     <th class="text-center" style="width:10%; border: 1px solid black;">Date</th>
     <th class="text-center" style="width:30%; border: 1px solid black;">Received to</th>
     <th class="text-center" style="width:35%; border: 1px solid black;">Remark</th>
     <th class="text-center" style="width:10%; border: 1px solid black;">Pay</th>
     <th class="text-center" style="width:10%; border: 1px solid black;">Due</th>
   </tr>
 </thead>
 <tbody>
<?php
while ($rowPay=mysqli_fetch_array($getPay))
{
  $payUnqId = $rowPay['unq_id'];
  $pay_typ = $rowPay['pay_typ'];
  $pay_method = $rowPay['pay_method'];
  $ledger_id = $rowPay['ledger_id'];
  $pay_amnt = $rowPay['pay_amnt'];
  $due_amnt = $rowPay['due_amnt'];
  $pay_date_time = $rowPay['pay_date_time'];
  $narration = $rowPay['narration'];
  $ledgerName = get_single_value("expense_ledger","unq_id",$ledger_id,"ledger_name","",$conn);
  $payMethod = get_single_value("payment_method","sl",$pay_method,"pay_method","",$conn);

  ?>
  <tr class="<?php echo $payColor; ?>">
    <td class="text-center" style="border: 1px solid black;"><i class="fa fa-trash fa-lg" style="color:red; cursor:pointer;" title="Click to Delete" onclick="payDelete('<?php echo $payUnqId; ?>')"></i></td>
    <td class="text-center" style="border: 1px solid black;"><?php echo date('d-m-Y',strtotime($pay_date_time)); ?></td>
    <td class="text-center" style="border: 1px solid black;"><?php echo "<b>$payMethod</b> - $ledgerName"; ?></td>
    <td class="text-left" style="border: 1px solid black;">&nbsp;<?php echo $narration; ?></td>
    <td class="text-right" style="border: 1px solid black;"><?php echo number_format($pay_amnt,2); ?>&nbsp;</td>
    <td class="text-right text-danger" style="border: 1px solid black;"><?php echo number_format($due_amnt,2); ?>&nbsp;</td>
  </tr>
  <?php
}
?>
</tbody>
</table>
<?php
}
}
?>