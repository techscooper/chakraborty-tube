<?php
include '../../config.php';
$ledger_id=mysqli_real_escape_string($conn,$_REQUEST['ledger_id']);
$fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
$tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));

if($ledger_id!=""){$ledger_id1 = "AND `ledger_id`='$ledger_id'";}else{$ledger_id1 = "";}
if($fdt!="" and $tdt!=""){$ftdt=" AND DATE(`bill_date`) BETWEEN '$fdt' AND '$tdt'";}else{$ftdt="";}

$stockCnt = 0;
$getStock=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type`=3 AND `level`=2 $ledger_id1 $ftdt ORDER BY `sl` DESC");
$rcntStock=mysqli_num_rows($getStock);
if($rcntStock>0){
?>
<div class="row">
  <div class="col-12">
    <table class="table table-sm table-bordered">
      <tr class="bg-secondary">
       <th class="text-center" style="width:5%;"><b>#</b></th>
       <th class="text-center" style="width:10%;"><b>Transaction ID</b></th>
       <th class="text-center" style="width:10%;"><b>Date</b></th>
       <th class="text-center" style="width:15%;"><b>Ledger</b></th>
       <th class="text-center" style="width:15%;"><b>Group</b></th>
       <th class="text-center" style="width:35%;"><b>Remark</b></th>
       <th class="text-center" style="width:10%;"><b>Amount</b></th>
      </tr>
    <?php
    while ($rowStock=mysqli_fetch_array($getStock)){
      $stockCnt++;
      $unq_id = $rowStock['unq_id'];
      $transaction_id = $rowStock['transaction_id'];
      $bill_date = $rowStock['bill_date'];
      $net_amount = $rowStock['net_amount'];
      $ledger_id = $rowStock['ledger_id'];
      $expense_group_id = $rowStock['expense_group_id'];
      $remark = $rowStock['remark'];

      $ledgerName = get_single_value("expense_ledger","unq_id",$ledger_id,"ledger_name","",$conn);
      $groupName = get_single_value("expense_group","unq_id",$expense_group_id,"group_name","",$conn);
      ?>
      <tr>
        <td class="text-center"><?php echo $stockCnt; ?></td>
        <!--
        <td class="text-center">
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white"><i class="fa fa-trash fa-lg" title="Click to Delete"></i> Delete</a><br>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white mt-1"><i class="fa fa-pencil fa-lg" title="Click to Delete"></i> Update</a>
        </td>
        -->
        <td class="text-center"><?php echo $transaction_id; ?></td>
        <td class="text-center"><?php echo date('d-m-Y',strtotime($bill_date)); ?></td>
        <td><?php echo $ledgerName; ?></td>
        <td><?php echo $groupName; ?></td>
        <td><?php echo $remark; ?></td>
        <td class="text-right"><b><?php echo number_format($net_amount,2); ?></b></td>
      </tr>
      <?php
    }
    ?>
    </table>
  </div>
</div>
<?php
}
else
{
  ?><div><?php echo "No Data Available"; ?></div><?php
}
?>
