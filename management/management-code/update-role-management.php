<?php
include '../../config.php';
if ($ckadmin == 0){
  header('location:../login');
	header("X-XSS-Protection: 0");
}
else{
	$emp_id_sl=mysqli_real_escape_string($conn,$_POST['emp_id_sl']);
	mysqli_query($conn,"UPDATE menu_accs SET accs_entry='0',accs_view='0',accs_modify='0',accs_delete='0',stat='0' WHERE emp_id_sl='$emp_id_sl'");
	$getMenu=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE stat=1 ORDER BY sl");
	while($rowMenu=mysqli_fetch_array($getMenu)){
		$menu_sl=$rowMenu['sl'];
		if(isset($_POST['chk'.$menu_sl])){
			$chkval = $_POST['chk'.$menu_sl];
			foreach($chkval as $chksl){
				$chkarray=explode('@',$chksl);
				$menusl=$chkarray['0'];
				$menutyp=$chkarray['1'];

				if($menutyp=='a'){
					mysqli_query($conn,"UPDATE menu_accs SET accs_entry='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					$getParentMenu=mysqli_query($conn,"SELECT * FROM menu_accs WHERE stat=1 AND emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					while($rowParentMenu=mysqli_fetch_array($getParentMenu))
					{
						$parentMenuSl=$rowParentMenu['parent_menu'];
						if($parentMenuSl!=0)
						{
							mysqli_query($conn,"UPDATE menu_accs SET accs_entry='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$parentMenuSl'");
						}
					}
				}
				if($menutyp=='v')
				{
					mysqli_query($conn,"UPDATE menu_accs SET accs_view='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					$getParentMenu=mysqli_query($conn,"SELECT * FROM menu_accs WHERE stat=1 AND emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					while($rowParentMenu=mysqli_fetch_array($getParentMenu))
					{
						$parentMenuSl=$rowParentMenu['parent_menu'];
						if($parentMenuSl!=0)
						{
							mysqli_query($conn,"UPDATE menu_accs SET accs_view='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$parentMenuSl'");
						}
					}
				}
				if($menutyp=='u')
				{
					mysqli_query($conn,"UPDATE menu_accs SET accs_modify='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					$getParentMenu=mysqli_query($conn,"SELECT * FROM menu_accs WHERE stat=1 AND emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					while($rowParentMenu=mysqli_fetch_array($getParentMenu))
					{
						$parentMenuSl=$rowParentMenu['parent_menu'];
						if($parentMenuSl!=0)
						{
							mysqli_query($conn,"UPDATE menu_accs SET accs_modify='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$parentMenuSl'");
						}
					}
				}
				if($menutyp=='d')
				{
					mysqli_query($conn,"UPDATE menu_accs SET accs_delete='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					$getParentMenu=mysqli_query($conn,"SELECT * FROM menu_accs WHERE stat=1 AND emp_id_sl='$emp_id_sl' AND menu_id='$menusl'");
					while($rowParentMenu=mysqli_fetch_array($getParentMenu))
					{
						$parentMenuSl=$rowParentMenu['parent_menu'];
						if($parentMenuSl!=0)
						{
							mysqli_query($conn,"UPDATE menu_accs SET accs_delete='1', stat=1 WHERE emp_id_sl='$emp_id_sl' AND menu_id='$parentMenuSl'");
						}
					}
				}
			}
		}
	}
  $return['success'] = true;
  $return['msg'] = "Role assign successfully.";
  echo json_encode($return);
}
?>