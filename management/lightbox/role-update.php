<?php
include '../../config.php';
$unq_id=mysqli_real_escape_string($conn,$_REQUEST['msl']);
$getLevel=mysqli_query($conn,"SELECT * FROM `user_level` WHERE `unq_id`='$unq_id'");
while($rowLevel=mysqli_fetch_array($getLevel)){
  $user_level_nm=$rowLevel['user_level_nm'];
  $l_rank=$rowLevel['l_rank'];
}
?>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Update Role / Level</h5>
    </div>
    <form id="role_update_frm" name="role_update_frm" action="user-management-code/update-role-2.php" method="POST">
      <input type="hidden" name="unq_id" value="<?php echo $unq_id;?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Role / Level<span class="text-danger"> *</span></label>
              <input type="text" name="level_nm" id="level_nm" class="form-control" placeholder="Role / Level *" value="<?php echo $user_level_nm; ?>" autofocus>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Rank<span class="text-danger"> *</span></label>
              <input type="text" name="rank" id="rank" class="form-control" placeholder="Rank *" value="<?php echo $l_rank; ?>" onkeypress="return check(event)" maxlength="2">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</button>
        <button type="reset" class="btn btn-primary btn-sm">Reset</button>
        <button type="submit" class="btn btn-success btn-sm" id="role_update_btn" name="role_update_btn">Save Changes</button>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="user-management-js/update-role.js"></script>