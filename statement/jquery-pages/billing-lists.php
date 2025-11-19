<?php
include '../../config.php';
if($ckadmin==1){
  $customer_id=mysqli_real_escape_string($conn,$_REQUEST['customer_id']);
  $fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
  $tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));

  if($customer_id!=""){ $customer_id1="AND `customer_id`='$customer_id'"; }else{ $customer_id1=""; }
  if($fdt!="" && $tdt!=""){ $ftdt=" AND `invoice_date` BETWEEN '$fdt' AND '$tdt'"; }else{ $ftdt=""; }

  $stockCnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = 0;
  $getStock=mysqli_query($conn,"SELECT * FROM `billing` WHERE `stat`=1 $customer_id1 $ftdt ORDER BY `invoice_date` DESC");
  if(mysqli_num_rows($getStock)>0){
?>
<div class="row">
  <div class="col-12">
    <table class="table table-sm table-bordered">
      <tr class="bg-secondary">
       <th class="text-center">#</th>
       <!-- <th class="text-center">Action</th> -->
       <th class="text-center">Invoice No</th>
       <th class="text-center">Date</th>
       <th class="text-center">Customer</th>
       <th class="text-center">Taxable Amount</th>
       <th class="text-center">GST Value</th>
       <th class="text-center">Net Price</th>
      </tr>
    <?php
    while ($rowStock=mysqli_fetch_array($getStock)){
      $stockCnt++;
      $unq_id=$rowStock['unq_id'];
      $customer_id=$rowStock['customer_id'];
      $invoice_no=$rowStock['invoice_no'];
      $invoice_date=$rowStock['invoice_date'];
      $taxable_amount=$rowStock['taxable_amount'];
      $gst_value=$rowStock['gst_value'];
      $net_amount=$rowStock['net_amount'];
      $return_stat=$rowStock['return_stat'];
      $customerName=get_single_value("customer_tbl","unq_id",$customer_id,"customer_nm","");
      $taxable_amountTotal+=$taxable_amount;
      $gst_valueTotal+=$gst_value;
      $net_amountTotal+=$net_amount;
      ?>
      <tr>
        <td class="text-center"><?php echo $stockCnt; ?></td>
        <!--
        <td class="text-center">
          <?php
          if($return_stat==0){
            ?><a href="javascript:void(0);" class="btn btn-sm btn-warning text-white mt-1" onclick="returnBill('<?php echo base64_encode($invoice_no); ?>')"><i class="fa fa-pencil fa-lg" title="Click to Delete"></i> Return</a><?php
          }
          ?>          
        </td>
        -->
        <td class="text-center"><a href="javascript:void(0);" onclick="billReprint('<?php echo $invoice_no; ?>')"><?php echo $invoice_no; ?></a></td>
        <td class="text-center"><?php echo date('d-m-Y',strtotime($invoice_date)); ?></td>
        <td><?php echo $customerName; ?></td>
        <td class="text-right"><a href="javascript:void(0);" onclick="billingItems('<?php echo $invoice_no; ?>')" title="Click to Show Items"><?php echo number_format($taxable_amount,2); ?></a></td>
        <td class="text-right"><?php echo number_format($gst_value,2); ?></td>
        <td class="text-right"><b><?php echo number_format($net_amount,2); ?></b></td>
      </tr>
      <?php
    }
    ?>
    <tr>
        <td colspan="4"></td>
        <td class="text-right"><b><?php echo number_format($taxable_amountTotal,2); ?></b></td>
        <td class="text-right"><b><?php echo number_format($gst_valueTotal,2); ?></b></td>
        <td class="text-right"><b><?php echo number_format($net_amountTotal,2); ?></b></td>
      </tr>
    </table>
  </div>
</div>
<?php
}
}
?>