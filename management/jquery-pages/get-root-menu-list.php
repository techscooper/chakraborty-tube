<?php
include '../../config.php';
if ($ckadmin==0){
  header('location:../../login');
}
else{
	$emp_id_sl=mysqli_real_escape_string($conn,$_REQUEST['emp_id_sl']);
	$root_id=mysqli_real_escape_string($conn,$_REQUEST['root_id']);
	if($root_id!=""){$rootsrc=" AND sl='$root_id'";}else{$rootsrc="";}

	if($emp_id_sl!=""){
		$getMenuUpdate=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE stat='1'");
		while($rowMenuUpdate=mysqli_fetch_array($getMenuUpdate)){
			$menu_id = $rowMenuUpdate['sl'];
			$parent_menu = $rowMenuUpdate['parent_menu'];
			$getCheckUpdate=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menu_id'");
			$rcntCheckUpdate=mysqli_num_rows($getCheckUpdate);
			if($rcntCheckUpdate==0)
			{
				mysqli_query($conn,"INSERT INTO menu_accs(emp_id_sl,menu_id,parent_menu,stat) values('$emp_id_sl','$menu_id', '$parent_menu','0')");
			}
		}
?>
<form id="sbmt_frm" name="sbmt_frm" action="user-management-code/update-role-management.php" method="POST">
<input type="hidden" name="emp_id_sl" value="<?php echo $emp_id_sl;?>">
<div class="dt-responsive table-responsive">
<table class="table table-striped table-bordered nowrap">
<thead>
	<tr>
	<th style="text-align:center; width:10%;">#</th>
	<th style="text-align:center; width:20%;">Root</th>
	<th style="text-align:center; width:70%;">Menu</th>
	</tr>
</thead>
<tbody>
<?php
$cnt=0;
$getParentMenu=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE stat=1 AND parent_menu=0 $rootsrc ORDER BY menu_rank");
while($rowParentMenu=mysqli_fetch_array($getParentMenu))
{
	$cnt++;
	$menu_sl=$rowParentMenu['sl'];
	$root_menu_nm=$rowParentMenu['menu_nm'];

	$parentMenuAccStat = $parentMenuAccChk = "";
	$getAccRoot=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND parent_menu='0' AND menu_id='$menu_sl'");
	while($rowAccRoot=mysqli_fetch_array($getAccRoot))
	{
		$parentMenuAccStat=$rowAccRoot['stat'];
	}
	if($parentMenuAccStat==1){$parentMenuAccChk="checked";}
	?>
	<tr>
	<td class="text-center"><?php echo $cnt;?></td>
	<td class="text-center">
    <?php echo $root_menu_nm;?><br>
		<label class="toggle-switch">
			<input type="checkbox" id="root_ck<?php echo $menu_sl;?>" <?php echo $parentMenuAccChk;?> onclick="checkall(this.checked,<?php echo $menu_sl;?>)">
			<span class="toggle-switch-slider"></span>
    </label>
	</td>
	<td class="text-center">
		<table class="table table-bordered">
			<thead>
			<tr>
			<th style="text-align:center; width:10%;">#</th>
			<th style="text-align:center; width:20%;">Menu Name</th>
			<th style="text-align:center; width:20%;">Add</th>
			<th style="text-align:center; width:20%;">View</th>
			<th style="text-align:center; width:20%;">Update</th>
			<th style="text-align:center; width:20%;">Delete</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$subcnt=0;
			$submenu_sl="";
			$sub_menu_nm="";
			$getChildMenu=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE stat=1 AND parent_menu='$menu_sl' ORDER BY menu_rank");
			$rcntChildMenu=mysqli_num_rows($getChildMenu);
			if($rcntChildMenu==0)
			{
				$childMenuAccStat_a = $childMenuAccChk_a = "";
				$getAccChild_a=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menu_sl' AND accs_entry='1'");
				while($rowAccChild_a=mysqli_fetch_array($getAccChild_a))
				{
					$childMenuAccStat_a=$rowAccChild_a['accs_entry'];
				}
				if($childMenuAccStat_a==1){$childMenuAccChk_a="checked";}

				$childMenuAccStat_v = $childMenuAccChk_v = "";
				$getAccChild_v=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menu_sl' AND accs_view='1'");
				while($rowAccChild_v=mysqli_fetch_array($getAccChild_v))
				{
					$childMenuAccStat_v=$rowAccChild_v['accs_view'];
				}
				if($childMenuAccStat_v==1){$childMenuAccChk_v="checked";}

				$childMenuAccStat_u = $childMenuAccChk_u = "";
				$getAccChild_u=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menu_sl' AND accs_modify='1'");
				while($rowAccChild_u=mysqli_fetch_array($getAccChild_u))
				{
					$childMenuAccStat_u=$rowAccChild_u['accs_modify'];
				}
				if($childMenuAccStat_u==1){$childMenuAccChk_u="checked";}

				$childMenuAccStat_d = $childMenuAccChk_d = "";
				$getAccChild_d=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menu_sl' AND accs_delete='1'");
				while($rowAccChild_d=mysqli_fetch_array($getAccChild_d))
				{
					$childMenuAccStat_d=$rowAccChild_d['accs_delete'];
				}
				if($childMenuAccStat_d==1){$childMenuAccChk_d="checked";}
				?>
				<tr>
				<td style="text-align:center;">1</td>
				<td style="text-align:center;"><?php echo $root_menu_nm;?></td>
				<td style="text-align:center;">
					<label class="toggle-switch">
						<input type="checkbox" id="add<?php echo $menu_sl;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $menu_sl.'@a';?>" <?php echo $childMenuAccChk_a;?> onclick="checkonly('<?php echo $menu_sl;?>')">
						<span class="toggle-switch-slider"></span>
          </label>
					</div>
				</td>
				<td style="text-align:center;">
					<label class="toggle-switch">
						<input type="checkbox" id="view<?php echo $menu_sl;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $menu_sl.'@v';?>" <?php echo $childMenuAccChk_v;?> onclick="checkonly('<?php echo $menu_sl;?>')">
						<span class="toggle-switch-slider"></span>
          </label>
					</div>
				</td>
				<td style="text-align:center;">
					<label class="toggle-switch">
						<input type="checkbox" id="update<?php echo $menu_sl;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $menu_sl.'@u';?>" <?php echo $childMenuAccChk_u;?> onclick="checkonly('<?php echo $menu_sl;?>')">
						<span class="toggle-switch-slider"></span>
          </label>
					</div>
				</td>
				<td style="text-align:center;">
					<label class="toggle-switch">
						<input type="checkbox" id="delete<?php echo $menu_sl;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $menu_sl.'@d';?>" <?php echo $childMenuAccChk_d;?> onclick="checkonly('<?php echo $menu_sl;?>')">
<span class="toggle-switch-slider"></span>
            </label>
					</div>
				</td>
				</tr>
				<?php
			}
			else
			{
				while($rowChildMenu=mysqli_fetch_array($getChildMenu))
				{
					$subcnt++;
					$submenu_sl=$rowChildMenu['sl'];
					$sub_menu_nm=$rowChildMenu['menu_nm'];

					$childMenuAccStat_a = $childMenuAccChk_a = "";
					$getAccChild_a=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$submenu_sl' AND accs_entry='1'");
					while($rowAccChild_a=mysqli_fetch_array($getAccChild_a))
					{
						$childMenuAccStat_a=$rowAccChild_a['accs_entry'];
					}
					if($childMenuAccStat_a==1){$childMenuAccChk_a="checked";}

					$childMenuAccStat_v = $childMenuAccChk_v = "";
					$getAccChild_v=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$submenu_sl' AND accs_view='1'");
					while($rowAccChild_v=mysqli_fetch_array($getAccChild_v))
					{
						$childMenuAccStat_v=$rowAccChild_v['accs_view'];
					}
					if($childMenuAccStat_v==1){$childMenuAccChk_v="checked";}

					$childMenuAccStat_u = $childMenuAccChk_u = "";
					$getAccChild_u=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$submenu_sl' AND accs_modify='1'");
					while($rowAccChild_u=mysqli_fetch_array($getAccChild_u))
					{
						$childMenuAccStat_u=$rowAccChild_u['accs_modify'];
					}
					if($childMenuAccStat_u==1){$childMenuAccChk_u="checked";}

					$childMenuAccStat_d = $childMenuAccChk_d = "";
					$getAccChild_d=mysqli_query($conn,"SELECT * FROM menu_accs WHERE emp_id_sl='$emp_id_sl' AND menu_id='$submenu_sl' AND accs_delete='1'");
					while($rowAccChild_d=mysqli_fetch_array($getAccChild_d))
					{
						$childMenuAccStat_d=$rowAccChild_d['accs_delete'];
					}
					if($childMenuAccStat_d==1){$childMenuAccChk_d="checked";}

					?>
					<tr>
					<td style="text-align:center;"><?php echo $subcnt;?></td>
					<td style="text-align:center;"><?php echo $sub_menu_nm;?></td>
					<td style="text-align:center;">
						<label class="toggle-switch">
							<input type="checkbox" id="add<?php echo $menu_sl.$subcnt;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $submenu_sl.'@a';?>" <?php echo $childMenuAccChk_a;?> onclick="checkonly('<?php echo $menu_sl;?>')">
<span class="toggle-switch-slider"></span>
              </label>
					</div>
					</td>
					<td style="text-align:center;">
						<label class="toggle-switch">
							<input type="checkbox" id="view<?php echo $menu_sl.$subcnt;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $submenu_sl.'@v';?>" <?php echo $childMenuAccChk_v;?> onclick="checkonly('<?php echo $menu_sl;?>')">
<span class="toggle-switch-slider"></span>
              </label>
					</div>
					</td>
					<td style="text-align:center;">
						<label class="toggle-switch">
							<input type="checkbox" id="update<?php echo $menu_sl.$subcnt;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $submenu_sl.'@u';?>" <?php echo $childMenuAccChk_u;?> onclick="checkonly('<?php echo $menu_sl;?>')">
              <span class="toggle-switch-slider"></span>
						</label>
					</div>
					</td>
					<td style="text-align:center;">
						<label class="toggle-switch">
							<input type="checkbox" id="delete<?php echo $menu_sl.$subcnt;?>" name="chk<?php echo $menu_sl;?>[]" value="<?php echo $submenu_sl.'@d';?>" <?php echo $childMenuAccChk_d;?> onclick="checkonly('<?php echo $menu_sl;?>')">
              <span class="toggle-switch-slider"></span>
							</label>
					</div>
					</td>
					</tr>
					<?php
				}
			}
			?>
			</tbody>
		</table>
	</td>
	</tr>
	<?php
}
?>
<tr>
<td colspan="3" style="text-align:right;">
	<button type="submit" id="sbmt_btn" name="sbmt_btn" class="btn btn-info">Assign</button>
</td>
</tr>
</tbody>
</table>
</div>
</form>
<script src="user-management-js/update-role-management.js" charset="utf-8"></script>
<?php
	}
}
?>