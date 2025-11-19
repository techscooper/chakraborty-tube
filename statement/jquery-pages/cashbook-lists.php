<?php
include '../../config.php';
if($ckadmin==1){
  $fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
  $tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
  $ledger_id = rawurldecode($_REQUEST['ledger_id']);
  if($fdt!="" && $tdt!=""){$ftdt=" AND DATE(`bill_date`) BETWEEN '$fdt' AND '$tdt'";}else{$ftdt="";}
  if($ledger_id!=""){ $ledger_id1="AND `unq_id`='$ledger_id'"; }else{ $ledger_id1=""; }
  if($ledger_id!=""){ $ledger_id2="AND `ledger_id`='$ledger_id'"; }else{ $ledger_id2=""; }
?>
<div class="row">
  <?php
  $getLedger=mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `stat`=1 $ledger_id1 ORDER BY `edit_stat` DESC, `sl`");
  while ($rowLedger = mysqli_fetch_array($getLedger)) {
    $ledger_unq_id=$rowLedger['unq_id'];
    $ledger_name=$rowLedger['ledger_name'];

    $getOpening=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `openingAmount` FROM `account_master` WHERE `stat`=1 AND DATE(`bill_date`)<'$fdt' AND `ledger_id`='$ledger_unq_id'");
    while ($rowOpening=mysqli_fetch_array($getOpening)){
      $openingBalance = $rowOpening['openingAmount'];
    }

    $getChkTemp = mysqli_query($conn,"SELECT * FROM `cashbook_ledger_temp` WHERE `ledger_id`='$ledger_unq_id'");
    if(mysqli_num_rows($getChkTemp)){
      mysqli_query($conn,"UPDATE `cashbook_ledger_temp` SET `balance_amount`='$openingBalance' WHERE `ledger_id`='$ledger_unq_id'");
    }
    else {
      $unq_id_unique=getUnqID('cashbook_ledger_temp');
      mysqli_query($conn,"INSERT INTO `cashbook_ledger_temp` (`unq_id`, `ledger_id`, `balance_amount`, `edt`, `eby`, `stat`) VALUES('$unq_id_unique', '$ledger_unq_id', '$openingBalance', '$currentDateTime', '$idadmin', '1')");
    }
    ?>
    <div class="col-md-4">
      <div class="card bg-secondary">
        <div class="p-2">
          <h4><?php echo $ledger_name; ?></h4>
          <h5>INR <?php echo number_format($openingBalance,2); ?></h5>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
</div>
<div class="row">
  <div class="col-12">
    <table class="table table-sm table-bordered">
      <thead class="bg-dark">
        <tr>
         <th class="text-center text-white" style="width:5%;">#</th>
         <th class="text-center text-white" style="width:10%;">Date</th>
         <th class="text-center text-white" style="width:18%;">Invoice / Refund No</th>
         <th class="text-center text-white" style="width:22%;">Particulars</th>
         <th class="text-center text-white" style="width:30%;">Ledger</th>
         <th class="text-center text-white" style="width:15%;">Debit</th>
         <th class="text-center text-white" style="width:15%;">Credit</th>
         <th class="text-center text-white" style="width:15%;">Balance</th>
        </tr>
      </thead>
    <?php
    $cnt = $debit = $credit = $balance = 0;
    $getCashbook=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type` IN('0','2','3') AND `level` IN('2','-1') $ftdt $ledger_id2");
    while ($rowCashbook=mysqli_fetch_array($getCashbook)){
      $cnt++;
      $invoice_no = $rowCashbook['invoice_no'];
      $refund_no = $rowCashbook['refund_no'];
      $bill_date = $rowCashbook['bill_date'];
      $net_amount = $rowCashbook['net_amount'];
      $ledger_id = $rowCashbook['ledger_id'];
      $remark = $rowCashbook['remark'];
      $type = $rowCashbook['type'];
      $level = $rowCashbook['level'];
      $dr = $rowCashbook['dr'];
      $cr = $rowCashbook['cr'];
      if($remark==""){ $remark='Na';}
      $ledgerName=get_single_value("expense_ledger","unq_id",$ledger_id,"ledger_name","");

      $openingBalance1 = get_single_value("cashbook_ledger_temp","ledger_id",$ledger_id,"balance_amount","");
      if($openingBalance1==""){$openingBalance1=0;}
      $debit = $credit = $balance = 0;
      if($dr==1 && $cr==0){
        $credit = $net_amount;
        $openingBalance1 = $openingBalance1 + $credit;

      }
      if($dr==0 && $cr==1){
        $debit = $net_amount;
        $openingBalance1 = $openingBalance1 - $debit;
      }
      $balance = $openingBalance1;

      $getChkTemp = mysqli_query($conn,"SELECT * FROM `cashbook_ledger_temp` WHERE `ledger_id`='$ledger_id'");
      if(mysqli_num_rows($getChkTemp)){
        mysqli_query($conn,"UPDATE `cashbook_ledger_temp` SET `balance_amount`='$balance' WHERE `ledger_id`='$ledger_id'");
      }
      else {
        aa1:
        $unq_id_unique = substr(str_shuffle('0123456789012345678901234567890123456789') , 0 , 8 );
        $check_uid = mysqli_query($conn,"SELECT * FROM `stock_master` WHERE `unq_id`='$unq_id_unique'");
        if ($row_check_uid = mysqli_fetch_array($check_uid)){
          goto aa1;
        }
        else{
          mysqli_query($conn,"INSERT INTO `cashbook_ledger_temp` (`unq_id`, `ledger_id`, `balance_amount`, `edt`, `eby`, `stat`) VALUES('$unq_id_unique', '$ledger_id', '$balance', '$currentDateTime', '$idadmin', '1')");
        }
      }
      ?>
      <tr>
        <td class="text-center"><?php echo $cnt; ?></td>
        <td class="text-center"><?php echo date('d-m-Y',strtotime($bill_date)).' ('.date('h:i:s A',strtotime($bill_date)).')'; ?></td>
        <td class="text-center">
          <?php
          if($refund_no!=""){
            ?><a href="../invoicing/export/billing-refund-print.php?refund_no=<?php echo $refund_no; ?>" target="_blank"><?php echo $refund_no; ?></a><?php
          }
          elseif ($invoice_no!="") {
            ?><a href="../invoicing/export/billing-invoice-print.php?invoice_no=<?php echo $invoice_no; ?>" target="_blank"><?php echo $invoice_no; ?></a><?php
          }
          elseif ($type==0 AND $level==2) {
            echo "Opening";
          }
          elseif ($type==3 AND $level==2) {
            echo 'Expense';
          }
          else { echo 'Na'; }
          ?>
        </td>
        <td class="text-center"><?php echo $remark; ?></td>
        <td class="text-center"><?php echo $ledgerName; ?></td>
        <td class="text-right"><b><?php echo number_format($debit,2); ?></b>&nbsp;</td>
        <td class="text-right"><b><?php echo number_format($credit,2); ?></b>&nbsp;</td>
        <td class="text-right"><b><?php echo number_format($balance,2); ?></b>&nbsp;</td>
      </tr>
      <?php
    }
    ?>
    </table>
  </div>
</div>
<?php
}
?>