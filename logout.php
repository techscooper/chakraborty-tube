<?php
include 'config.php';
if ($ckadmin == '1') {
	$llg_out = date('Y-m-d H:i:s', time());
	$get = mysqli_query($conn,"SELECT * FROM `login_tbl` where `u_id`='$id1_admin'");
	if($row=mysqli_fetch_array($get)){
		$llg = $row['llg_in'];
	}
	mysqli_query($conn,"UPDATE `login_api_keys` SET `stat`='0' WHERE `session_id`='$sessionIDGet'");
	mysqli_query($conn,"UPDATE `login_tbl` SET `llg_out`='$llg_out', `llg_in_time`='$llg' WHERE `u_id`='$id1_admin'");
}
setcookie( "apiTokenKey", "", time()-3600, "/", $urlLink, isset($_SERVER["HTTPS"]), true);
session_unset();
session_destroy();
session_start();
session_regenerate_id();
header('location:login');
header("X-XSS-Protection: 0");
?>
