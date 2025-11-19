<?php
include '../../config.php';
if($ckadmin==1){
  $supplier_id=mysqli_real_escape_string($conn,$_REQUEST['supplier_id']);
  $fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
  $tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
  if($supplier_id!=""){$supplier_id1 = "AND `supplier_id`='$supplier_id'";}else{$supplier_id1 = "";}
  if($fdt!="" && $tdt!=""){$ftdt=" AND `purchase_date` BETWEEN '$fdt' AND '$tdt'";}else{$ftdt="";}
  $stockCnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = 0;
  $getStock=mysqli_query($conn,"SELECT * FROM `purchase` WHERE `stat`=1 $supplier_id1 $ftdt ORDER BY `purchase_date` DESC, `sl` DESC");
  if(mysqli_num_rows($getStock)>0){
    ?>
    <table class="table table-sm table-bordered">
      <tr>
        <th class="text-center">#</th>
        <th class="text-center">Date</th>
        <th class="text-center">Purchase No</th>
        <th class="text-center">Supplier</th>
        <th class="text-center">Taxable Amount</th>
        <th class="text-center">GST Value</th>
        <th class="text-center">Net Amount</th>
      </tr>
      <?php
      while ($rowStock=mysqli_fetch_array($getStock)){
        $stockCnt++;
        $supplier_id=$rowStock['supplier_id'];
        $purchase_date=$rowStock['purchase_date'];
        $purchase_no=$rowStock['purchase_no'];
        $taxable_amount=$rowStock['taxable_amount'];
        $gst_value=$rowStock['gst_value'];
        $net_amount=$rowStock['net_amount'];
        $taxable_amountTotal+=$taxable_amount;
        $gst_valueTotal+=$gst_value;
        $net_amountTotal+=$net_amount;
        $supplierName=get_single_value("supplier_tbl","unq_id",$supplier_id,"supplier_nm","");
        ?>
        <tr>
          <td class="text-center"><?php echo $stockCnt; ?></td>
          <td class="text-center"><?php echo date('d-m-Y',strtotime($purchase_date)); ?></td>
          <td class="text-center"><a href="javascript:void(0);" onclick="purchaseItems('<?php echo $purchase_no; ?>')" title="Click to Show Purchase Items"><?php echo $purchase_no; ?></a></td>
          <td><?php echo $supplierName; ?></td>
          <td class="text-right"><?php echo number_format($taxable_amount,2); ?></td>
          <td class="text-right"><?php echo number_format($gst_value,2); ?></td>
          <td class="text-right"><?php echo number_format($net_amount,2); ?></td>
        </tr>
        <?php
      }
      ?>
      <tr>
        <td class="text-left" colspan="4"><b>Total</b></td>
        <td class="text-right"><b><?php echo number_format($taxable_amountTotal,2); ?></b></td>
        <td class="text-right"><b><?php echo number_format($gst_valueTotal,2); ?></b></td>
        <td class="text-right"><b><?php echo number_format($net_amountTotal,2); ?></b></td>
      </tr>
    </table>
    <?php
  }
  else{
    ?><div><?php echo "No Data Available"; ?></div><?php
  }
}
?>