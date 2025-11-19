<?php
include '../config.php';
if($ckadmin==0){
  header('location:../login');
}
else {
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Role Create | <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Create New Role</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card bg-secondary">
                <div class="card-body">
                  <form id="role_create_frm" action="management-code/role-add-2.php" method="POST" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Role / Level<span class="text-danger"> *</span></label>
                        <input type="text" name="user_level_nm" id="user_level_nm" class="form-control" placeholder="Role / Level *">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Rank<span class="text-danger"> *</span></label>
                        <input type="text" name="l_rank" id="l_rank" class="form-control" placeholder="Rank *" onkeypress="return check(event)" maxlength="2">
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-top:30px;">
                      <button class="btn btn-success" type="submit" id="create_role_btn">Submit</button>
                    </div>
                  </div>
                  </form>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                          <thead class="bg-dark text-white">
                            <tr>
                              <th class="text-center">#</th>
                              <th class="text-center">ACTION</th>
                              <th class="text-center">ROLE / LEVEL</th>
                              <th class="text-center">RANK</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $slc=0;
    										      $get_level_dtls = mysqli_query($conn,"SELECT * FROM user_level WHERE sl>1 ORDER BY updt_stat, l_rank ASC");
                              while($row_level_dtls = mysqli_fetch_array($get_level_dtls))
                              {
                                $slc++;
    											      $level_unq_id=$row_level_dtls['unq_id'];
    											      $user_level_nm=$row_level_dtls['user_level_nm'];
    											      $l_rank=$row_level_dtls['l_rank'];
    											      $updt_stat=$row_level_dtls['updt_stat'];
    											      $stat=$row_level_dtls['stat'];

                                $tbl_nm = 'user_level';
    											      $act_field = 'stat';
    											      $act_value = $stat;
    											      $unq_field = 'unq_id';
    											      $unq_value = $level_unq_id;

                                if($act_value==1){
    												       $actlogo="../assets/allpic/active.png";
    												       $ttl="Click to De-active";
    											      }
    											      else{
    												       $actlogo="../assets/allpic/deactive.png";
    												       $ttl="Click to Active";
    											      }
                                ?>
                                <tr>
                                  <td class="text-center" style="width:5%;"><?php echo $slc;?></td>
                                  <td class="text-center" style="width:15%;">
                                    <?php
            												if($updt_stat==0)
            												{
            													?>
            													<a href="javascript:void(0);" style="cursor: not-allowed;" title="Disabled"><i class="fa fa-edit fa-lg" style="color:#525253;"></i></a>
                                      <img src="../assets/allpic/active.png" style="cursor: not-allowed; width:20px; height:20px;" title="Disabled">
            													<?php
            												}
            												else
            												{
            													?>
            													<a href="javascript:void(0);" onclick="update_level('<?php echo $level_unq_id;?>')"><i class="fa fa-edit fa-lg" title="Click to Update"></i></a>
            													<span class="p-1" id="div<?php echo $unq_value;?>">
            														<a href="javascript:void(0);" onclick="act_dact_level('<?php echo $tbl_nm;?>','<?php echo $act_field;?>','<?php echo $act_value;?>','<?php echo $unq_field;?>','<?php echo $unq_value;?>')">
            															<img src="<?php echo $actlogo;?>" style="width:20px; height:20px;" title="<?php echo $ttl;?>">
            														</a>
            													</span>
            													<?php
            												}
            												?>
                                  </td>
                                  <td class="text-center" style="width:70%;"><b><?php echo $user_level_nm;?></b></td>
                                  <td class="text-center" style="width:10%;"><?php echo $l_rank;?></td>
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
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="management-js/role-add.js"></script>
    <script type="text/javascript">
		function update_level(msl)
		{
			$('#div_lightbox').load("lightbox/role-update.php?msl="+msl).fadeIn("fast");
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