<?php
include '../config.php';

if ($ckadmin==0)
{
  header('location:../login');
}
else
{
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Manage Customer | <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Customer List</h1></div>
            <div class="right">
              <a href="add-customer.php" class="btn btn-primary btn-animated btn-animated-y">
              	<span class="btn-inner--visible">Add New</span>
              	<span class="btn-inner--hidden"><i class="fa fa-plus"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                      <input type="text" name="allsrc" id="allsrc" value="" placeholder="Search keyword" class="form-control" onkeyup="show_list()">
                    </div>
                  </div>
                  <div class="row pt-3">
                    <div class="col-md-12">
                      <div id="list_div">

                      </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php require_once('../javascripts.php');?>
<script type="text/javascript">
$(document).ready(function() {
  show_list()
});
function show_list(){
  var allsrc = encodeURIComponent($('#allsrc').val());
  $("#list_div").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
  setTimeout(function(){ $("#list_div").load("jquery-pages/get-customer-list.php?allsrc="+allsrc).fadeIn("fast") }, 100);
}

function customer_edit(c_uid){
  $('#div_lightbox').load("lightbox/customer-edit.php?c_uid="+c_uid).fadeIn("fast");
  $('#modal-report').modal('show');
}
function customer_delete(c_uid){
  $("#div_lightbox").load("lightbox/customer-delete.php?c_uid="+c_uid).fadeIn("fast");
  $('#modal-report').modal('show');
}
</script>
</body>
</html>
<?php
}
?>
