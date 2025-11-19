<?php
include '../../config.php';
$ledger_name=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['ledger_name']));
$af="%".$ledger_name."%";
if($ledger_name!=''){$a2=" AND (`ledger_name` LIKE '$af')";}else{$a2='';}
$slc=0;
$getList=mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `stat`!='-1' $a2 ORDER BY `edit_stat` DESC, `ledger_name`");
if(mysqli_num_rows($getList)>0){
?>
<div class="table-responsive">
  <table class="table table-sm table-bordered mt-3">
    <thead class="bg-dark text-white">
      <tr>
        <th class="text-center" style="width:5%;">#</th>
        <th class="text-center" style="width:15%;">Action</th>
        <th class="text-center" style="width:40%;">Ledger Name</th>
        <th class="text-center" style="width:20%;">Opening</th>
        <th class="text-center" style="width:20%;">Balance</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($rowList=mysqli_fetch_array($getList)){
        $slc++;
        $unq_id=$rowList['unq_id'];
        $ledger_name=$rowList['ledger_name'];
        $edt=$rowList['edt'];
        $eby=$rowList['eby'];
        $edit_stat=$rowList['edit_stat'];
        $stat=$rowList['stat'];

        $tbl_nm = 'expense_ledger';
        $act_field = 'stat';
        $act_value = $stat;
        $unq_field = 'unq_id';
        $unq_value = $unq_id;

        if($act_value==1){
           $actlogo="../assets/allpic/active.png";
           $ttl="Click to De-active";
        }
        else{
           $actlogo="../assets/allpic/deactive.png";
           $ttl="Click to Active";
        }
        $openingBalance=get_single_value("account_master","ledger_id",$unq_id,"net_amount","AND `type`=0 AND `level`=2");
        if($openingBalance==''){$openingBalance=0;}
        $ledgerBalance=ledgerBalance($unq_id);
        ?>
        <tr>
          <td class="text-center"><?php echo $slc;?></td>
          <td class="text-center">
            <a href="javascript:void(0);" onclick="updateExpense('<?php echo base64_encode($unq_id);?>')"><i class="fa fa-edit fa-lg"></i></a>
            <span class="p-1" id="div<?php echo $unq_value;?>">
              <a href="javascript:void(0);" onclick="act_dact_level('<?php echo $tbl_nm;?>','<?php echo $act_field;?>','<?php echo $act_value;?>','<?php echo $unq_field;?>','<?php echo $unq_value;?>')">
                <img src="<?php echo $actlogo;?>" style="width:20px; height:20px;" title="<?php echo $ttl;?>">
              </a>
            </span>
          </td>
          <td><b><?php echo $ledger_name;?></b></td>
          <td class="text-right"><b><?php echo number_format($openingBalance,2);?></b>&nbsp;</td>
          <td class="text-right"><b><?php echo number_format($ledgerBalance,2);?></b>&nbsp;</td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
<?php
}
?>