<?php
include '../config.php';
if ($ckadmin==0)
{
  header('location:../login');
}
else
{
?>
<!doctype html>
<html lang="en">
  <head>
    <title>::Create User:: <?php echo $projectName; ?> ::</title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left">
              <h1>Create User</h1>
              <ol class="breadcrumb">
                <li class=""><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"></li>
                <li class="breadcrumb-item">User Management</li>
                <li class="breadcrumb-item active">Create User</li>
              </ol>
            </div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header">
                  <h2><i class="fa fa-plus-circle"></i> Create User</h2>
                </div>
                <form id="user_create_frm" action="management-code/user-add-2.php" method="POST" enctype="multipart/form-data">
                  <div class="body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Name<span class="text-danger"> *</span></label>
                          <input type="text" name="nm" id="nm" class="form-control" placeholder="Name *">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Mobile<span class="text-danger"> *</span></label>
                          <input type="text" name="user_mobile" id="user_mobile" class="form-control" placeholder="Mobile *" onkeypress="return check(event)" maxlength="10">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" name="user_email" id="user_email" class="form-control" placeholder="Email" onkeypress="return check3(event)">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Role / Level<span class="text-danger"> *</span></label>
                          <select class="form-control" name="user_role" id="user_role">
                          <option value="">-- Select --</option>
                          <?php
                          $get_role = mysqli_query($conn,"SELECT * FROM user_level WHERE sl>2 AND stat='1' ORDER BY updt_stat,sl ASC");
                          while($row_role = mysqli_fetch_array($get_role))
                          {
                            $level_unq_id=$row_role['unq_id'];
                            $user_level_nm=$row_role['user_level_nm'];
                            ?><option value="<?php echo $level_unq_id ?>"><?php echo $user_level_nm; ?></option> <?php
                          }
                          ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>User Name<span class="text-danger"> *</span></label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="User Name *" onkeypress="return check3(event)">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>New Password<span class="text-danger"> *</span></label>
                          <input type="password" name="npassword" id="npassword" class="form-control" placeholder="Password *">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Confirm Password<span class="text-danger"> *</span></label>
                          <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Password *">
                        </div>
                      </div>
                      <div class="col-md-12 text-right">
                        <button class="btn btn-success" type="submit" id="create_user_btn" name="create_user_btn">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header">
                  <h2><i class="fa fa-list"></i> List of User</h2>
                </div>
                <div class="body">
                  <div class="table-responsive">
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">Action</th>
                          <th class="text-center">Username</th>
                          <th class="text-center">Name</th>
                          <th class="text-center">Mobile</th>
                          <th class="text-center">Email</th>
                          <th class="text-center">Role / Level</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $slc=0;
										      $get_user_dtls = mysqli_query($conn,"SELECT * FROM login_tbl WHERE lvl>0 ORDER BY full_nm");
                          while($row_user_dtls = mysqli_fetch_array($get_user_dtls))
                          {
                            $slc++;
                            $username=$row_user_dtls['u_id'];
                            $user_password=$row_user_dtls['pass'];
                            $full_nm=$row_user_dtls['full_nm'];
                            $email=$row_user_dtls['email'];
                            $mobile_no=$row_user_dtls['mobile_no'];
                            $joining=$row_user_dtls['joining'];
                            $stat=$row_user_dtls['stat'];
                            $lvl=$row_user_dtls['lvl'];
                            $dp_pic=$row_user_dtls['dp_pic'];
											      $stat=$row_user_dtls['stat'];

                            $user_role = get_single_value('user_level','unq_id',$lvl,'user_level_nm','',$conn);
                            ?>
                            <tr>
                              <td class="text-center"><?php echo $slc;?></td>
                              <td class="text-center"><a href="javascript:void(0);" onclick="update_user('<?php echo $username;?>')"><i class="fa fa-edit fa-lg" title="Click to Update"></i></a></td>
                              <td class="text-center"><?php echo $username;?></td>
                              <td class="text-center"><?php echo $full_nm; ?></td>
                              <td class="text-center"><b><?php echo $mobile_no;?></b></td>
                              <td class="text-center"><?php echo $email;?></td>
                              <td class="text-center"><?php echo $user_role;?></td>
                            </tr>
                            <?php
                          }
                         ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="management-js/user-add.js"></script>
    <script type="text/javascript">
		function update_user(msl)
		{
			$('#div_lightbox').load("lightbox/user-update.php?msl="+msl).fadeIn("fast");
			$('#modal-report').modal('show');
		}
		function act_dact_level(tbl_nm,act_field,act_value,unq_field,unq_value)
		{
			$("#div"+unq_value).load("../all-active-deactive.php?tbl_nm="+tbl_nm+"&act_field="+act_field+"&act_value="+act_value+"&unq_field="+unq_field+"&unq_value="+unq_value).fadeIn("fast");
		}
		</script>
  </body>
</html>
<?php
}
?>