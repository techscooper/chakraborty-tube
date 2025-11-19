<?php
include '../config.php';

if ($ckadmin==0)
{
  header('location:../login');
}
else
{
  $page_val=1;
?>
<!doctype html>
<html lang="en">
<head>
<title>::Change Password::<?php echo $projectName; ?>::</title>
<?php require_once('../stylesheet.php');?>
<style media="screen">
fieldset{
  border: 1px solid #ddd !important;
  margin: 0;
  xmin-width: 0;
  padding: 10px;
  position: relative;
  border-radius:4px;
  background-color:#f5f5f5;
  padding-left:10px!important;
}

legend{
  font-size:14px;
  font-weight:bold;
  margin-bottom: 0px;
  width: 60%;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px 5px 5px 10px;
  background-color: #ffffff;
}
</style>
</head>
<body class="theme-blue">
<?php require_once('../navbar/index.php');?>
<div class="main_content">
	<?php require_once('../sidebar/left-sidebar.php'); ?>
	<div class="page">
		<div class="container-fluid">
      <br><br>
      <form id="change_pass_frm" name="change_pass_frm" action="profile-code/change-password-2.php" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <fieldset class="col-md-4">
                <legend><i class="fa fa-key"></i> Change Password</legend>
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label><b>Old Password</b> <span class="text-danger"> *</span></label>
                          <input type="password" name="old_password" id="old_password" class="form-control form-control-sm" placeholder="Old Password *">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label><b>New Password</b> <span class="text-danger"> *</span></label>
                          <input type="password" class="form-control form-control-sm" name="new_pass" id="new_pass" value="" placeholder="New Password *">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label><b>Confirm Password</b> <span class="text-danger"> *</span></label>
                          <input type="password" class="form-control form-control-sm" name="confirm_pass" id="confirm_pass" value="" placeholder="Confirm Your Password *">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <button class="btn btn-info" type="submit" id="cng_pass_btn" name="cng_pass_btn">Confirm</button>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
      </form>
		</div>
	</div>
</div>
<?php require_once('../javascripts.php');?>
<script type="text/javascript" src="profile-js/change-password.js"></script>
</body>
</html>
<?php
}
?>
