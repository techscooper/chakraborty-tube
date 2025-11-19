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
<meta charset="utf-8">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<title>Daily Report | <?php echo $projectName; ?></title>
<?php require_once('../stylesheet.php');?>
</head>
<body class="theme-blue">
<?php require_once('../navbar/index.php');?>
<div class="main_content">
	<?php require_once('../sidebar/left-sidebar.php'); ?>
	<div class="page">
		<div class="container-fluid">
			<div class="page_header">
				<div class="left"><h3>Daily Report</h3></div>
        <div class="right">
          <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
            <span class="btn-inner--visible">Back</span>
            <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
          </a>
        </div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card bg-cyan">
						<div class="body">
							<div class="row">
                <div class="col-md-3">
                  <input type="date" name="opening_date_frm" id="opening_date_frm" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                  <input type="date" name="opening_date_to" id="opening_date_to" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                  <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="show_list_div()">Show</a>
                  <!-- <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="billingExport()">Export</a> -->
								</div>
							</div>
              <div class="mt-4" id="list_div"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once('../javascripts.php');?>
<script type="text/javascript">
$(document).ready(function(){ show_list_div(); });
function show_list_div(){
  var opening_date_frm = encodeURIComponent($('#opening_date_frm').val());
  var opening_date_to = encodeURIComponent($('#opening_date_to').val());
  if(opening_date_frm=="") {
    toast('warning','Warning!','','Please select from date');
  }
  else if (opening_date_to=="") {
    toast('warning','Warning!','','Please select to date');
  }
  else{
    $("#list_div").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
    setTimeout(function(){ $("#list_div").load("jquery-pages/daily-report-lists.php?opening_date_frm="+opening_date_frm+"&opening_date_to="+opening_date_to).fadeIn("fast") }, 100);
  }
}
function billingExport(){
  var opening_date_frm = encodeURIComponent($('#opening_date_frm').val());
  var opening_date_to = encodeURIComponent($('#opening_date_to').val());
  if(opening_date_frm=="") {
    toast('warning','Warning!','','Please select from date');
  }
  else if (opening_date_to=="") {
    toast('warning','Warning!','','Please select to date');
  }
  else{
    document.location = "export/daily-report-lists-export.php?opening_date_frm="+opening_date_frm+"&opening_date_to="+opening_date_to;
  }
}
</script>
</body>
</html>
<?php
}
?>