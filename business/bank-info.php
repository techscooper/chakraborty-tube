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
    <title>Bank Information | <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left">
              <h1>Bank Information</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item">Business</li>
                <li class="breadcrumb-item active">Bank Information</li>
              </ol>
            </div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-12">
              <div class="card border-dark">
                <div class="card-header bg-secondary pt-2 pb-0 pl-1"><h4><i class="fa fa-circle"></i> Bank Information</h4></div>
                  <div class="card-body">
                    <form action="business-code/bank-info-2.php" method="post" id="bank_info_frm">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Holder Name <span class="text-danger">*</span></label>
                          <input type="text" name="bank_h_nm" id="bank_h_nm" class="form-control" placeholder="Account Holder Name *" autofocus>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Bank Name <span class="text-danger">*</span></label>
                          <input type="text" name="bank_nm" id="bank_nm" class="form-control" placeholder="Bank Name *">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Bank A/C Number <span class="text-danger">*</span></label>
                          <input type="text" name="bank_ac_no" id="bank_ac_no" class="form-control" placeholder="Bank A/C Number *">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Branch Name <span class="text-danger">*</span></label>
                          <input type="text" name="branch_nm" id="branch_nm" class="form-control" placeholder="Branch Name *">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>IFSC Code <span class="text-danger">*</span></label>
                          <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" placeholder="IFSC Code *">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>UPI No</label>
                          <input type="text" name="upi_no" id="upi_no" class="form-control" placeholder="IFSC Code">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>QR Code</label>
                          <input type="file" name="qr_code" id="qr_code" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 text-right">
                        <button class="btn btn-success" type="submit" id="bank_info_btn">Confirm</button>
                      </div>
                    </div>
                    </form>
                  </div>
              </div>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-12">
              <div class="card border-dark">
                <div class="card-header bg-secondary pt-2 pb-0 pl-1"><h4><i class="fa fa-list"></i> <b>Bank List</b></h4></div>
                <div class="card-body p-0">
                  <div id="divBankList"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="business-js/bank-info.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){ getBankInfo(); });
    function getBankInfo(){
      $("#divBankList").load("jquery-pages/show-bank-info-list.php").fadeIn("fast");
    }
    function bank_info_edit(bank_info_unq_id){
      $('#div_lightbox').load("lightbox/bank-info-edit.php?bank_info_unq_id="+bank_info_unq_id).fadeIn("fast");
      $('#modal-report').modal('show');
    }
    function bank_info_delete(bank_info_unq_id){
      $("#div_lightbox").load("lightbox/bank-info-delete.php?bank_info_unq_id="+bank_info_unq_id).fadeIn("fast");
      $('#modal-report').modal('show');
    }
    function bank_set_primary(bank_uid,vl){
      $("#div_lightbox").load("lightbox/bank-set-primary.php?bank_uid="+bank_uid+'&vl='+vl).fadeIn("fast");
      $('#modal-report').modal('show');
    }
    </script>
  </body>
</html>
<?php
}
?>