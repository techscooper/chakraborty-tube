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
    <title>Billing Statement || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Dashboard</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <label><b>Ledger</b></label>
                      <select class="form-control form-control-sm" name="ledger_id" id="ledger_id">
                        <option value="">-- All --</option>
                        <?php
                        $getLedger = mysqli_query($conn,"SELECT * FROM `expense_ledger` WHERE `stat`=1 ORDER BY `edit_stat` DESC, `ledger_name`");
                        while ($rowLedger = mysqli_fetch_array($getLedger)) {
                          $ledger_unq_id = $rowLedger['unq_id'];
                          $ledger_name = $rowLedger['ledger_name'];
                          ?><option value="<?php echo $ledger_unq_id; ?>"><?php echo $ledger_name; ?></option><?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label>From Date</label>
                      <input type="date" name="fdt" id="fdt" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                      <label>To Date</label>
                      <input type="date" name="tdt" id="tdt" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2" style="padding-top:29px;">
                      <a href="javascript:void(0);" class="btn btn-sm btn-info" id="cutting_received_button" onclick="show_list_div();">Show</a>
                    </div>
                  </div>
                  <div id="list_div" class="pt-2"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript">
    $(document).ready(function(){
      show_list_div();
    });
    function show_list_div(){
      var ledger_id = $('#ledger_id').val();
      var fdt = encodeURIComponent($('#fdt').val());
      var tdt = encodeURIComponent($('#tdt').val());
      $("#list_div").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#list_div").load("jquery-pages/expense-lists.php?ledger_id="+ledger_id+"&fdt="+fdt+"&tdt="+tdt).fadeIn("fast") }, 1000);
    }
    </script>
  </body>
</html>
<?php
}
?>
