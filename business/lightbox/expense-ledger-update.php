<?php
include '../../config.php';
$unq_id=mysqli_real_escape_string($conn,base64_decode($_REQUEST['unq_id']));
$getUpdate=mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `unq_id`='$unq_id'");
while($rowUpdate=mysqli_fetch_array($getUpdate)){
  $ledger_name_update=$rowUpdate['ledger_name'];
  $edit_stat_update=$rowUpdate['edit_stat'];
  $openingBalance=get_single_value("account_master","ledger_id",$unq_id,"net_amount","AND `type`=0 AND `level`=1");
  if($openingBalance==''){$openingBalance=0;}
}
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Bank Information Update</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
    <div class="modal-body">
      <form id="updateExpenseFrm" name="updateExpenseFrm" action="business-code/expense-ledger-update-2.php" method="POST">
        <input type="hidden" name="unq_id" id="unq_id" value="<?php echo $unq_id;?>">
        <div class="row">
          <div class="form-group col-md-12">
            <label><b>Ledger Name <span class="text-danger">*</span></b></label>
            <input type="text" name="ledger_name_update" id="ledger_name_update" value="<?php echo $ledger_name_update; ?>" class="form-control" <?php if ($edit_stat_update==1){ echo 'readonly'; }?>>
          </div>
          <div class="form-group col-md-12">
            <label><b>Opening Balance <span class="text-danger">*</span></b></label>
            <input type="text" name="opening_balance_update" id="opening_balance_update" value="<?php echo $openingBalance; ?>" class="form-control" placeholder="Opening Balance" onclick="select()">
          </div>
          <div class="form-group col-md-12 text-right">
            <button class="btn btn-success" type="submit" id="updateExpenseBtn" name="updateExpenseBtn">Update</button>
          </div>
        </div>
      </form>
		</div>
	</div>
</div>
<script type="text/javascript" src="business-js/expense-ledger-update.js"></script>
