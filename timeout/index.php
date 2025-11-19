<?php
include '../config.php';
if($ckadmin==1){
	header('location:../dashboard/index.php');
	header("X-XSS-Protection: 0");
}
else{
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Timeout :: <?php echo $projectName; ?></title>
		<?php require_once('../stylesheet.php');?>
	</head>
	<body class="theme-blue auth-page">
		<div class="vh100 d-flex align-items-center">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4">
						<div class="card mb-0">
							<div class="card-body">
								<h1><strong>Timeout</strong></h1>
								<a href="../login" class="btn btn-block btn-slack btn-icon-label">Sign in again</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once('../javascripts.php');?>
	</body>
</html>
<?php
}
?>