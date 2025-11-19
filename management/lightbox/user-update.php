<?php
include '../../config.php';
$unq_id=mysqli_real_escape_string($conn,$_REQUEST['msl']);
$getUser=mysqli_query($conn,"SELECT * FROM `login_tbl` WHERE `u_id`='$unq_id'");
while($rowUser=mysqli_fetch_array($getUser)){
  $full_nm=$rowUser['full_nm'];
  $email=$rowUser['email'];
  $mobile_no=$rowUser['mobile_no'];
  $joining=$rowUser['joining'];
  $stat=$rowUser['stat'];
  $lvl=$rowUser['lvl'];
  $designation=$rowUser['designation'];
}
?>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header"><h5>Update User <small>(<?php echo $unq_id; ?>)</small></h5></div>
    <form id="user_update_frm" name="user_update_frm" action="user-management-code/update-user-2.php" method="POST">
      <input type="hidden" name="unq_id" value="<?php echo $unq_id;?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>Role / Level<span class="text-danger"> *</span></label>
              <select class="form-control" name="e_user_role" id="e_user_role">
              <option value="">-- Select --</option>
              <?php
              $get_role = mysqli_query($conn,"SELECT * FROM user_level WHERE sl>2 AND stat='1' ORDER BY updt_stat,sl ASC");
              while($row_role = mysqli_fetch_array($get_role))
              {
                $level_unq_id=$row_role['unq_id'];
                $user_level_nm=$row_role['user_level_nm'];
                ?><option value="<?php echo $level_unq_id ?>" <?php if($lvl==$level_unq_id){ echo 'selected';} ?>><?php echo $user_level_nm; ?></option> <?php
              }
              ?>
              </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Name<span class="text-danger"> *</span></label>
              <input type="text" name="e_nm" id="e_nm" value="<?php echo $full_nm; ?>" class="form-control" placeholder="Name *">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Mobile<span class="text-danger"> *</span></label>
              <input type="text" name="e_user_mobile" id="e_user_mobile" value="<?php echo $mobile_no; ?>" class="form-control" placeholder="Mobile *" onkeypress="return check(event)" maxlength="10">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Email</label>
              <input type="text" name="e_user_email" id="e_user_email" value="<?php echo $email; ?>" class="form-control" placeholder="Email" onkeypress="return check3(event)">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</button>
        <button type="reset" class="btn btn-primary btn-sm">Reset</button>
        <button type="submit" class="btn btn-success btn-sm" id="user_update_btn" name="user_update_btn">Save Changes</button>
      </div>
    </form>
  </div>
</div>
<!--Code page Link-->
<script type="text/javascript" src="user-management-js/update-user.js"></script>
