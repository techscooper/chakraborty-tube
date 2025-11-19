<?php
include '../../config.php';
if($ckadmin==1){
  $customer_id=mysqli_real_escape_string($conn,$_REQUEST['customer_id']);
  $payment_status=mysqli_real_escape_string($conn,$_REQUEST['payment_status']);
  $fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
  $tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
  if($customer_id!=""){$customer_id1 = "AND `customer_id`='$customer_id'";}else{$customer_id1 = "";}
  if($payment_status!=""){$payment_status1 = "AND `payment_stat`='$payment_status'";}else{$payment_status1 = "";}
  if($fdt!="" && $tdt!=""){$ftdt=" AND `invoice_date` BETWEEN '$fdt' AND '$tdt'";}else{$ftdt="";}

  $stockCnt = $total_net_amount = $total_paidAmount = $total_dueAmount = 0;
  $getStock=mysqli_query($conn,"SELECT * FROM `billing` WHERE `stat`=1 $customer_id1 $payment_status1 $ftdt ORDER BY `sl` DESC");
  if(mysqli_num_rows($getStock)>0){
?>
<div class="row">
  <div class="col-md-12">
    <table class="table table-sm table-bordered table-bordered">
      <tr class="bg-dark text-white">
       <th class="text-center" style="width:5%;">#</th>
       <th class="text-center" style="width:5%;">Action</th>
       <th class="text-center">Invoice</th>
       <th class="text-center">Date</th>
       <th class="text-center">Customer</th>
       <th class="text-center">Net Price</th>
       <th class="text-center">Paid</th>
       <th class="text-center">Due</th>
      </tr>
    <?php
    while ($rowStock=mysqli_fetch_array($getStock)){
      $stockCnt++;
      $unq_id = $rowStock['unq_id'];
      $customer_id = $rowStock['customer_id'];
      $invoice_no = $rowStock['invoice_no'];
      $invoice_date = $rowStock['invoice_date'];
      $payment_stat = $rowStock['payment_stat'];
      $customerName = get_single_value("customer_tbl","unq_id",$customer_id,"customer_nm","");

      $net_amount = $paidAmount = 0;
      $getNet=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `net_amount` FROM `account_master` WHERE `stat`=1 AND `invoice_no`='$invoice_no' AND `type`=2 AND `level`=1");
      while ($rowNet=mysqli_fetch_array($getNet)){
        $net_amount = $rowNet['net_amount'];
      }
      $getNet=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `paidAmount` FROM `account_master` WHERE `stat`=1 AND `invoice_no`='$invoice_no' AND `type`=2 AND `level`=2");
      while ($rowNet=mysqli_fetch_array($getNet)){
        $paidAmount = $rowNet['paidAmount'];
      }
      $dueAmount = $net_amount - $paidAmount;

      $total_net_amount = $total_net_amount + $net_amount;
      $total_paidAmount = $total_paidAmount + $paidAmount;
      $total_dueAmount = $total_dueAmount + $dueAmount;
      ?>
      <tr>
        <td class="text-center"><?php echo $stockCnt; ?></td>
        <?php
        if($payment_stat==0){
          ?><td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="pay('<?php echo $invoice_no; ?>')">Pay</a></td><?php
        }
        else{
          ?><td class="text-center"><a href="javascript:void(0);" class="btn btn-success btn-sm">Paid</a></td><?php
        }
        ?>
        <td class="text-center"><a href="../invoicing/export/billing-invoice-print.php?invoice_no=<?php echo $invoice_no; ?>" target="_blank"><?php echo $invoice_no; ?></a></td>
        <td class="text-center"><?php echo date('d-m-Y',strtotime($invoice_date)); ?></td>
        <td><?php echo $customerName; ?></td>
        <td class="text-right"><?php echo number_format($net_amount,2); ?></td>
        <td class="text-right"><?php echo number_format($paidAmount,2); ?></td>
        <td class="text-right"><?php echo number_format($dueAmount,2); ?></td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td class="text-left" colspan="5"><b>Total</b></td>
      <td class="text-right"><b><?php echo number_format($total_net_amount,2); ?></b></td>
      <td class="text-right"><b><?php echo number_format($total_paidAmount,2); ?></b></td>
      <td class="text-right"><b><?php echo number_format($total_dueAmount,2); ?></b></td>
    </tr>
    </table>
  </div>
</div>
<?php
}
else{
  ?><div><?php echo "No Data Available"; ?></div><?php
}
}
?>