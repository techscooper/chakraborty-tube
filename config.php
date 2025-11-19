<?php
include 'connect-db.php';
include 'functions.php';
date_default_timezone_set("Asia/Kolkata");
$smallYear=date('y');
$largYear=date('Y');
$currentDate=date('Y-m-d');
$currentDateTime=date('Y-m-d H:i:s');
$urlLink = "https://demome.in/";
$projectName = "Chakraborty Tubewell";

$ckadmin=0;
session_start();
$userAgentBrowser = mysqli_real_escape_string($conn,$_SERVER['HTTP_USER_AGENT']);
if(isset($_COOKIE["apiTokenKey"]) && $_COOKIE["apiTokenKey"]!=''){
	$apiTokenKey = mysqli_real_escape_string($conn,$_COOKIE["apiTokenKey"]);
	if (mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `login_api_keys` WHERE `api_key`='$apiTokenKey' AND `user_agent`='$userAgentBrowser' AND `stat`=1"))) {
		$sessionIDGet = session_id();
		mysqli_query($conn,"UPDATE `login_api_keys` SET `session_id`='$sessionIDGet' WHERE `api_key`='$apiTokenKey' AND `user_agent`='$userAgentBrowser' AND `stat`=1");
		$_SESSION["apiKey"] = $apiTokenKey;
	}
	else {
		session_destroy();
		session_unset();
		setcookie("apiTokenKey", "", time()-3600, "/", $urlLink, isset($_SERVER["HTTPS"]), true);
	}
}
if(isset($_SESSION["apiKey"]) && $_SESSION["apiKey"]!=''){
	$API_TOKEN = mysqli_real_escape_string($conn,$_SESSION["apiKey"]);
	$sessionIDGet = session_id();
	if (mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `login_api_keys` WHERE `api_key`='$API_TOKEN' AND `session_id`='$sessionIDGet' AND `user_agent`='$userAgentBrowser' AND `stat`=1"))) {
		$usersNameGet = userIDGet($API_TOKEN,$sessionIDGet,$conn);
		if ($usersNameGet!=false) {
			$idadmin = $usersNameGet;
			$get_ck_admin = mysqli_query($conn,"SELECT * FROM `login_tbl` WHERE `u_id`='$idadmin' AND `stat`=1");
		  if($row_ck_admin = mysqli_fetch_array($get_ck_admin)){
				$ckadmin=1;
		    $name_u_admin=$row_ck_admin['full_nm'];
		    $email_u_admin=$row_ck_admin['email'];
		    $mobile_no_u_admin=$row_ck_admin['mobile_no'];
				$llg_in_time_u_admin=$row_ck_admin['llg_in_time'];
				$stat_u_admin=$row_ck_admin['stat'];
				$lvl_u_admin=$row_ck_admin['lvl'];
				$dppic_u_admin=$row_ck_admin['dp_pic'];
			}
		}
		else {
			$ckadmin=0;
			session_destroy();
			session_unset();
			setcookie("apiTokenKey", "", time()-3600, "/", $urlLink, isset($_SERVER["HTTPS"]), true);
			session_start();
			session_regenerate_id();
			$sessionIDGet = session_id();
		}
	}
	else {
		$ckadmin=0;
		session_destroy();
		session_unset();
		setcookie("apiTokenKey", "", time()-3600, "/", $urlLink, isset($_SERVER["HTTPS"]), true);
		session_start();
		session_regenerate_id();
		$sessionIDGet = session_id();
	}
}
else {
	$ckadmin=0;
	session_destroy();
	session_unset();
	setcookie("apiTokenKey", "", time()-3600, "/", $urlLink, isset($_SERVER["HTTPS"]), true);
	session_start();
	$sessionIDGet = session_id();
}
$RootMenuLink_sl = $RootMenuLinkName = "";
$c_page_name = $_SERVER['REQUEST_URI'];
$short_url = str_replace("stockCTS/","",$c_page_name);
$short_url = "..$short_url";
$getRootMenuLink=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `menu_link`='$short_url'");
if($rowRootMenuLink=mysqli_fetch_array($getRootMenuLink)){
  $RootMenuLink_sl = $rowRootMenuLink['sl'];
  $RootMenuLinkName = $rowRootMenuLink['menu_nm'];
}
?>