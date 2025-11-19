<?php
include '../config.php';

if ($ckadmin==0){
  header('location:../login');
}
else{
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Manage Menu || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Menu List</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
              	<span class="btn-inner--visible">Create Menu</span>
              	<span class="btn-inner--hidden"><i class="fa fa-plus"></i></span>
              </a>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header"><h2><i class="fa fa-plus-circle"></i> Menu List</h2></div>
  <div class="body">
    <div class="dt-responsive table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Action</th>
              <th class="text-center">Main Menu</th>
              <th class="text-center">Sub Menu</th>
              <th class="text-center">Alias</th>
              <th class="text-center">Link</th>
              <th class="text-center">Rank</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $slc=0;
            $get_menu_dtls=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `parent_menu`=0 AND `stat`=1 ORDER BY `menu_rank`");
            while($row_menu_dtls=mysqli_fetch_array($get_menu_dtls)){
              $slc++;
              $menu_sl1=$row_menu_dtls['sl'];
              $menu_nm1=$row_menu_dtls['menu_nm'];
              $menu_alias1=$row_menu_dtls['menu_alias'];
              $menu_link1=$row_menu_dtls['menu_link'];
              $menu_rank1=$row_menu_dtls['menu_rank'];
            ?>
            <tr>
              <td style="text-align:center;"><?php echo $slc;?></td>
              <td style="text-align:center;">
                <a href="javascript:void(0);" onclick="menu_edit('<?php echo $menu_sl1;?>')">
                  <i class="fa fa-edit fa-lg" title="Click to Update"></i>
                </a>
                <a href="javascript:void(0);" onclick="menu_delete('<?php echo $menu_sl1;?>')">
                  <i class="fa fa-trash fa-lg" style="color:red;" title="Click to delete"></i>
                </a>
              </td>
              <td><b><?php echo $menu_nm1;?></b></td>
              <td>-</td>
              <td><?php echo $menu_alias1;?></td>
              <td><?php echo $menu_link1;?></td>
              <td style="text-align:center;"><?php echo $menu_rank1;?></td>
            </tr>
            <?php
            $get_menu_dtls1=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `parent_menu`='$menu_sl1' AND `stat`=1");
            while($row_menu_dtls1=mysqli_fetch_array($get_menu_dtls1))
            {
              $slc++;
              $menu_sl2=$row_menu_dtls1['sl'];
              $menu_nm2=$row_menu_dtls1['menu_nm'];
              $menu_alias2=$row_menu_dtls1['menu_alias'];
              $menu_link2=$row_menu_dtls1['menu_link'];
              $menu_rank2=$row_menu_dtls1['menu_rank'];
            ?>
            <tr>
              <td style="text-align:center;"><?php echo $slc;?></td>
              <td style="text-align:center;">
                <a href="javascript:void(0);" onclick="menu_edit('<?php echo $menu_sl2;?>')">
	                 <i class="fa fa-edit fa-lg" title="Click to Update"></i>
                </a>
                <a href="javascript:void(0);" onclick="menu_delete('<?php echo $menu_sl2;?>')">
	                 <i class="fa fa-trash fa-lg" style="color:red;" title="Click to delete"></i>
                </a>
              </td>
              <td>-</td>
              <td style="color:#008073;"><?php echo "$menu_nm2";?></td>
              <td><?php echo $menu_alias2;?></td>
              <td><?php echo $menu_link2;?></td>
              <td style="text-align:center;"><?php echo $menu_rank2;?></td>
            </tr>
            <?php
            }
            }
            ?>
          </tbody>
        </table>
    </div>
  </div>
<!--Main Content-->
</div>
</div>
</div>

</div>
</div>
</div>
<!-- Required Js -->
<?php require_once('../javascripts.php');?>
<script type="text/javascript">
function menu_edit(msl)
{
  $('#div_lightbox').load("lightbox/menu-edit.php?msl="+msl).fadeIn("fast");
  $('#modal-report').modal('show');
}
function menu_delete(msl)
{
  $("#div_lightbox").load("lightbox/menu-delete.php?msl="+msl).fadeIn("fast");
  $('#modal-report').modal('show');
}
</script>
<script src="menu-setup-js/create-menu.js" charset="utf-8"></script>
</body>
</html>
<?php
}
?>
