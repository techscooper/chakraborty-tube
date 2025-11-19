<?php
include '../../config.php';

$unq_id = $_REQUEST['uid'];
$getLevel=mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `unq_id`='$unq_id'");
while($rowLevel=mysqli_fetch_array($getLevel))
{
  $edit_unit_short_name=$rowLevel['unit_short_name'];
  $edit_unit_value=$rowLevel['unit_value'];
}
?>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Update Role / Level</h5>
    </div>
    <form id="unit_update_frm" name="unit_update_frm" action="inventory-setup-code/update-unit-2.php" method="POST">
      <input type="hidden" name="unq_id" value="<?php echo $unq_id;?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Unit Name <span class="text-danger"> *</span></label>
              <input type="text" name="edit_unit_short_name" id="edit_unit_short_name" class="form-control" placeholder="Unit Name *" value="<?php echo $edit_unit_short_name; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Unit Value <span class="text-danger"> *</span></label>
              <input type="text" name="edit_unit_value" id="edit_unit_value" class="form-control" placeholder="Unit Value *" value="<?php echo $edit_unit_value; ?>">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</button>
        <button type="reset" class="btn btn-primary btn-sm">Reset</button>
        <button type="submit" class="btn btn-success btn-sm" id="unit_update_btn" name="unit_update_btn">Save Changes</button>
      </div>
    </form>
  </div>
</div>
<!--Code page Link-->
<script type="text/javascript" src="inventory-setup-js/update-unit.js"></script>
