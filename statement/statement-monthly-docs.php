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
    <title>Monthly Docs || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Monthly Docs</h1></div>
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
                    <div class="col-md-2">
                      <label>Month</label>
                      <?php
                      $currentMonth = date('n');
                      $currentYear = date('Y');
                      $months = array(1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November',12 => 'December');
                      echo '<select name="year" name="report_month" id="report_month" class="form-control form-control-sm">';
                      foreach ($months as $monthNumber => $monthName) {
                        $selected = ($monthNumber == $currentMonth) ? 'selected' : '';
                        echo '<option value="'.$monthNumber.'"'.$selected.'>'.$monthName.' - '.$currentYear.'</option>';
                      }
                      echo '</select>';
                      ?>
                    </div>
                    <div class="col-md-2" style="padding-top:29px;">
                      <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="getListExport()">Download</a>
                    </div>
                  </div>
                  <div id="divList" class="pt-3"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript">
    $(document).ready(function(){ getListShow(); });
    function getListShow(){
      var fdt=encodeURIComponent($('#fdt').val());
      var tdt=encodeURIComponent($('#tdt').val());
      $("#divList").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
      setTimeout(function(){ $("#divList").load("jquery-pages/load-statement-b2c.php?fdt="+fdt+"&tdt="+tdt).fadeIn("fast") }, 1000);
    }
    function getListExport(){
      var fdt=encodeURIComponent($('#fdt').val());
      var tdt=encodeURIComponent($('#tdt').val());
      //document.location="export/export-hsn-code-wise.php?product_id="+product_id+"&fdt="+fdt+"&tdt="+tdt;
    }
    </script>
  </body>
</html>
<?php
}
?>