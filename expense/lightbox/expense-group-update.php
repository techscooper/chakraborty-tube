<?php
include '../../config.php';
$unq_id = base64_decode($_REQUEST['unq_id']);
$getUpdate=mysqli_query($conn,"SELECT * FROM `expense_group` WHERE `unq_id`='$unq_id'");
while($rowUpdate=mysqli_fetch_array($getUpdate)){
  $group_name_update=$rowUpdate['group_name'];
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
      <form id="updateGroupFrm" name="updateGroupFrm" action="expense-code/expense-group-update-2.php" method="POST">
        <input type="hidden" name="unq_id" id="unq_id" value="<?php echo $unq_id;?>">
        <div class="row">
          <div class="form-group col-md-12">
            <label><b>Group Name <span class="text-danger">*</span></b></label>
            <input type="text" name="group_name_update" id="group_name_update" value="<?php echo $group_name_update; ?>" class="form-control" placeholder="Group Name" onclick="select()">
          </div>
          <div class="form-group col-md-12 text-right">
            <button class="btn btn-success" type="submit" id="updateGroupBtn" name="updateGroupBtn">Update</button>
          </div>
        </div>
      </form>
		</div>
	</div>
</div>
<script type="text/javascript" src="expense-js/expense-group-update.js"></script>
