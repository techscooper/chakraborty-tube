<div class="left_sidebar">
	<a href="index.php" style="font-size:21px;" class="text-white"><b><?php echo $projectName; ?></b></a>
	<ul class="navbar-nav mr-auto xs-show d-none"><li class="nav-item"><a class="nav-link nav-link-icon btn-dashboard" href="javascript:void(0);"><i class="fa fa-dashboard"></i></a></li></ul>
	<hr class="bg-white">
	<nav class="sidebar main_dashboard open">
		<ul class="metismenu">
			<?php
			if ($lvl_u_admin=='-10'){
				?><li><a href="../menu-setup/manage-menu.php"><i class="fa fa-bars"></i><span>Menu Manage</span></a></li><?php
			}
			$getLeftBarRootMenu = mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `parent_menu`=0 AND `stat`='1' ORDER BY `menu_rank` ASC");
			while($rowLeftBarRootMenu = mysqli_fetch_array($getLeftBarRootMenu)){
				$LeftBarRootMenuSl=$rowLeftBarRootMenu['sl'];
				$LeftBarRootMenuName=$rowLeftBarRootMenu['menu_nm'];
				$LeftBarRootMenuLink=$rowLeftBarRootMenu['menu_link'];
				$LeftBarRootMenuIcon=$rowLeftBarRootMenu['menu_icon'];
				$menu_accs_stat = "";
				$getMenuAccsData=mysqli_query($conn,"SELECT `stat` FROM `menu_accs` WHERE `emp_id_sl`='$lvl_u_admin' AND `menu_id`='$LeftBarRootMenuSl'");
				while($rowMenuAccsData=mysqli_fetch_array($getMenuAccsData)){
					$menu_accs_stat=$rowMenuAccsData['stat'];
				}
				if($lvl_u_admin<1){
					?><li><a href="<?php echo $LeftBarRootMenuLink; ?>"><i class="<?php echo $LeftBarRootMenuIcon; ?>"></i><span style="font-size:16px;"><?php echo $LeftBarRootMenuName; ?></span></a></li><?php
				}
				elseif ($menu_accs_stat==1){
					?><li><a href="<?php echo $LeftBarRootMenuLink; ?>"><i class="<?php echo $LeftBarRootMenuIcon; ?>"></i><span style="font-size:16px;"><?php echo $LeftBarRootMenuName; ?></span></a></li><?php
				}
			}
			?>
		</ul>
	</nav>
</div>