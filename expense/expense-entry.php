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
  <title>Expense || <?php echo $projectName; ?></title>
  <?php require_once('../stylesheet.php');?>
</head>
<body class="theme-blue">
  <?php require_once('../navbar/index.php');?>
  <div class="main_content">
    <?php require_once('../sidebar/left-sidebar.php'); ?>
    <div class="page">
      <div class="container-fluid">
        <div class="page_header">
          <div class="left"><h1>Expense Entry</h1></div>
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
                <form action="expense-code/expense-entry-2.php" method="post" id="addExpenseFrm">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label><b>Ledger <span class="text-danger">*</span></b></label>
                    <select class="form-control form-control-sm" name="ledger_id" id="ledger_id">
                      <option value="">-- Select --</option>
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
                  <div class="form-group col-md-3">
                    <label><b>Group <span class="text-danger">*</span></b></label>
                    <select class="form-control form-control-sm" name="expense_group_id" id="expense_group_id">
                      <option value="">-- Select --</option>
                      <?php
                      $getGroup = mysqli_query($conn,"SELECT * FROM `expense_group` WHERE `stat`=1 ORDER BY `sl`");
                      while ($rowGroup = mysqli_fetch_array($getGroup)) {
                        $group_unq_id = $rowGroup['unq_id'];
                        $group_name = $rowGroup['group_name'];
                        ?><option value="<?php echo $group_unq_id; ?>"><?php echo $group_name; ?></option><?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label><b>Date <span class="text-danger">*</span></b></label>
                    <input type="date" name="bill_date" id="bill_date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm" placeholder="DD/MM/YYYY">
                  </div>
                  <div class="form-group col-md-3">
                    <label><b>Amount <span class="text-danger">*</span></b></label>
                    <input type="number" name="net_amount" id="net_amount" value="" class="form-control form-control-sm" placeholder="">
                  </div>
                  <div class="form-group col-md-12">
                    <label><b>Remark</b></label>
                    <input type="text" name="remark" id="remark" value="" class="form-control form-control-sm" placeholder="Remark">
                  </div>
                  <div class="form-group col-md-12 text-right">
                    <button class="btn btn-sm btn-success" type="submit" id="addExpenseBtn" name="addExpenseBtn">Confirm</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('../javascripts.php');?>
  <script type="text/javascript" src="expense-js/expense-entry.js"></script>
</body>
</html>
<?php
}
?>
