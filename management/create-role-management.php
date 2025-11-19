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
    <title>::Role Assign:: <?php echo $projectName; ?> ::</title>
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
              <h1>Role Assign</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item">User Management</li>
                <li class="breadcrumb-item active">Role Assign</li>
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
<div class="card-body">
<div class="row">
	<div class="col-lg-3">
		<div class="form-group">
			<select name="emp_id_sl" id="emp_id_sl" class="form-control select2" onchange="get_root_menu_list()">
			<option value="">Select User Role/Level</option>
			<?php
			$get_user_level_dtls=mysqli_query($conn,"SELECT * FROM user_level WHERE sl>2 AND stat=1 ORDER BY l_rank ASC");
			while($row_user_level_dtls=mysqli_fetch_array($get_user_level_dtls))
			{
				$user_lvl_unq_id = $row_user_level_dtls['unq_id'];
				$user_lvl_name = $row_user_level_dtls['user_level_nm'];
				?>
				<option value="<?php echo $user_lvl_unq_id;?>"><?php echo $user_lvl_name;?></option>
				<?php
			}
			?>
			</select>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="form-group">
			<select name="root_id" id="root_id" class="form-control select2" onchange="get_root_menu_list()">
			<option value="">Select Root</option>
			<?php
			$get_menu_dtls=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE stat=1 AND parent_menu='0' ORDER BY menu_rank");
			while($row_menu_dtls=mysqli_fetch_array($get_menu_dtls))
			{
				$menu_sl = $row_menu_dtls['sl'];
				$menu_nm = $row_menu_dtls['menu_nm'];
				?>
				<option value="<?php echo $menu_sl;?>"><?php echo $menu_nm;?></option>
				<?php
			}
			?>
			</select>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="form-group">
			<button id="create_btn" name="create_btn" class="btn btn-info" onclick="get_root_menu_list()"> Show </button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div id="div_menu_list"></div>
	</div>
</div>
</div>

</div>
</div>
</div>

</div>
</div>
</div>
<!-- Required Js -->
<?php require_once('../javascripts.php');?>
<script type="text/javascript">
function get_root_menu_list()
{
	var emp_id_sl=document.getElementById('emp_id_sl').value;
	var root_id=document.getElementById('root_id').value;

	if(emp_id_sl!="" || root_id!="")
	{
		$('#div_menu_list').load('jquery-pages/get-root-menu-list.php?emp_id_sl='+emp_id_sl+'&root_id='+root_id).fadeIn("fast");
	}
}

function checkall(val,rootsl)
{
	var chk=document.getElementsByName('chk'+rootsl+'[]');
	for(i=0; i<chk.length; i++)
	{
		chk[i].checked = val;
	}
}

function checkonly(menu_sl)
{
	var j3='';
	var chk = document.getElementsByName('chk'+menu_sl+'[]');
	for(i=0; i<chk.length; i++)
	{
		if(i==0)
		{
			if(chk[i].checked){j3=chk[i].value;}
		}
		else
		{
			if(chk[i].checked){j3=j3+','+chk[i].value;}
		}
	}
	if(j3 != '')
	{
		$("#root_ck"+menu_sl).prop( "checked", true );
	}
	else
	{
		$("#root_ck"+menu_sl).prop( "checked", false );
	}
}
</script>
</body>
</html>
<?php
}
?>
