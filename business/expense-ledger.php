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
  <title>Add Expense Ledger || <?php echo $projectName; ?></title>
  <?php require_once('../stylesheet.php');?>
</head>
<body class="theme-blue">
  <?php require_once('../navbar/index.php');?>
  <div class="main_content">
    <?php require_once('../sidebar/left-sidebar.php'); ?>
    <div class="page">
      <div class="container-fluid">
        <div class="page_header">
          <div class="left"><h1>Create Expense Ledger</h1></div>
          <div class="right">
            <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
              <span class="btn-inner--visible">Back</span>
              <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card bg-secondary">
              <div class="card-body">
                <form action="business-code/expense-ledger-2.php" method="post" id="addExpenseFrm">
                <div class="row">
                  <div class="form-group col-md-4">
                    <label><b>Ledger Name <span class="text-danger">*</span></b></label>
                    <input type="text" name="ledger_name" id="ledger_name" value="" class="form-control form-control-sm" placeholder="Ledger Name" onkeyup="ledgerList()">
                  </div>
                  <div class="form-group col-md-3">
                    <label><b>Opening Balance<span class="text-danger">*</span></b></label>
                    <input type="number" name="opening_balance" id="opening_balance" value="" class="form-control form-control-sm" placeholder="Opening Balance">
                  </div>
                  <div class="form-group col-md-3" style="padding-top:30px;">
                    <button class="btn btn-sm btn-success" type="submit" id="addExpenseBtn" name="addExpenseBtn">Confirm</button>
                  </div>
                </div>
                </form>
                <div id="divList"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('../javascripts.php');?>
  <script type="text/javascript" src="business-js/expense-ledger.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    ledgerList()
  });
  function ledgerList(){
    var ledger_name = encodeURIComponent($('#ledger_name').val());
    $("#divList").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
    setTimeout(function(){ $("#divList").load("jquery-pages/expense-ledger-list.php?ledger_name="+ledger_name).fadeIn("fast") }, 500);
  }
  function act_dact_level(tbl_nm,act_field,act_value,unq_field,unq_value){
    $("#div"+unq_value).load("../all-active-deactive.php?tbl_nm="+tbl_nm+"&act_field="+act_field+"&act_value="+act_value+"&unq_field="+unq_field+"&unq_value="+unq_value).fadeIn("fast");
  }
  function updateExpense(unq_id){
    $("#div_lightbox").load("lightbox/expense-ledger-update.php?unq_id="+unq_id).fadeIn("fast");
    $('#modal-report').modal('show');
  }
  </script>
</body>
</html>
<?php
}
?>
