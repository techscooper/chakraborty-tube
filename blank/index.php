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
<link rel="icon" href="favicon.ico" type="image/x-icon">
<title>Blank || Page</title>
<?php require_once('../stylesheet.php');?>
</head>
<body class="theme-blue">
<?php require_once('../navbar/index.php');?>
<div class="main_content">
	<?php
	require_once('../sidebar/left_sidebar.php');
	require_once('../sidebar/right_sidebar.php');
	?>
	<div class="page">
		<div class="container-fluid">
			<div class="page_header">
				<div class="left">
					<h1>Dashboard</h1>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
						<li class="breadcrumb-item">Form</li>
						<li class="breadcrumb-item active">Blank</li>
					</ol>
				</div>
				<div class="right">
					<button type="button" class="btn btn-primary btn-animated btn-animated-y">
						<span class="btn-inner--visible">Create New</span>
						<span class="btn-inner--hidden"><i class="fa fa-plus"></i></span>
					</button>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12">
					<div class="card">
						<div class="header"><h2><i class="fa fa-circle"></i> Blank example</h2></div>
						<div class="body">
							<div class="row">
								<div class="col-md-6">
									<div class="input-group mb-3">
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">@</span></div>
										<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group mb-3">
										<input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
										<div class="input-group-append"><span class="input-group-text" id="basic-addon2">@example.com</span></div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="input-group mb-3">
										<div class="input-group-prepend"><span class="input-group-text">With textarea</span></div>
										<textarea class="form-control" aria-label="With textarea"></textarea>
									</div>
								</div>
								<div class="col-md-12 text-right">
									<input type="submit" id="btn" name="btn" class="btn btn-success">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12">
					<div class="card">
						<div class="header"><h2><i class="fa fa-list"></i> Blank example</h2></div>
						<div class="body">
							<div class="table-responsive">
								<table class="table mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Patients</th>
											<th>Adress</th>
											<th>START Date</th>
											<th>END Date</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td><span>John</span></td>
											<td><span class="text-info">70 Bowman St. South Windsor, CT 06074</span></td>
											<td>Sept 13, 2017</td>
											<td>Sept 16, 2017</td>
											<td><span class="badge badge-success text-uppercase">Admit</span></td>
										</tr>
										<tr>
											<td>2</td>
											<td><span>Jack Bird</span></td>
											<td><span class="text-info">123 6th St. Melbourne, FL 32904</span></td>
											<td>Sept 13, 2017</td>
											<td>Sept 22, 2017</td>
											<td><span class="badge badge-secondary text-uppercase">Discharge</span></td>
										</tr>
										<tr>
											<td>3</td>
											<td><span>Dean Otto</span></td>
											<td><span class="text-info">123 6th St. Melbourne, FL 32904</span></td>
											<td>Sept 13, 2017</td>
											<td>Sept 23, 2017</td>
											<td><span class="badge badge-success text-uppercase">Admit</span></td>
										</tr>
										<tr>
											<td>4</td>
											<td><span>Jack Bird</span></td>
											<td><span class="text-info">4 Shirley Ave. West Chicago, IL 60185</span></td>
											<td>Sept 17, 2017</td>
											<td>Sept 16, 2017</td>
											<td><span class="badge badge-secondary text-uppercase">Discharge</span></td>
										</tr>
										<tr>
											<td>5</td>
											<td><span>Hughe L.</span></td>
											<td><span class="text-info">4 Shirley Ave. West Chicago, IL 60185</span></td>
											<td>Sept 18, 2017</td>
											<td>Sept 18, 2017</td>
											<td><span class="badge badge-success text-uppercase">Admit</span></td>
										</tr>
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
<!-- Required Js -->
<?php require_once('../javascripts.php');?>
</body>
</html>
<?php
}
?>
