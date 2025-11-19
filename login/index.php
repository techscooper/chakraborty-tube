<?php
include '../config.php';
if ($ckadmin == 1){
	header('location:../dashboard/index.php');
	header("X-XSS-Protection: 0");
}
else {
	$captchaCode = generateCaptcha('6');
	mysqli_query($conn,"INSERT INTO `session_robot_checker`(`sl`, `session_id`, `captcha`, `date_time`, `stat`) VALUES (NULL,'$sessionIDGet','$captchaCode','$currentDateTime','1')");
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Sign In :: <?php echo $projectName; ?></title>
		<?php require_once('../stylesheet.php');?>
	</head>
	<body oncontextmenu="return false" oncopy="return false" oncut="return false" onpaste="return false" class="theme-blue auth-page">
		<div class="vh100 d-flex align-items-center">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4">
						<div class="card mb-0">
							<div class="card-body">
								<h5 class="heading h5 pt-3">Welcome,</strong></h5>
								<h4 class="heading h3 pb-3"><strong><?php echo $projectName; ?></strong></h4>
								<form action="login-code/login-2.php" method="post" id="login_frm" class="form-primary">
									<div class="form-group">
										<input type="text" id="signin_username" name="signin_username" class="form-control" placeholder="Username">
									</div>
									<div class="form-group">
										<input type="password" id="signin_password" name="signin_password" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text bg-info text-white input-group-sm" id="captchaauth" style="letter-spacing: 6px;"><?php echo $captchaCode;?></span>
											</div>
											<input type="text" class="form-control form-control" placeholder="Write Catcha" aria-label="Captcha" aria-describedby="captchaauth" name="signin_captcha" id="signin_captcha" autocomplete="off">
										</div>
									</div>
									<button type="submit" id="signin_btn" name="signin_btn" class="btn btn-block btn-slack btn-icon-label">
										<span class="btn-inner--text">Sign in <i class="fa fa-sign-in ml-2"></i></span>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once('../javascripts.php');?>
		<script src="login-js/login.js" charset="utf-8"></script>
		<script type="text/javascript">
			var auto_refresh = setInterval(function(){ $.get('../timeout/auto-check-login.php', function(data){ if(data>=120){ document.location.href='../timeout/index.php'; } }); }, 300000);
		</script>
	</body>
</html>
<?php
}
?>