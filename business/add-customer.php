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
  <title>Add New Customer || <?php echo $projectName; ?></title>
  <?php require_once('../stylesheet.php');?>
</head>
<body class="theme-blue">
  <?php require_once('../navbar/index.php');?>
  <div class="main_content">
    <?php require_once('../sidebar/left-sidebar.php'); ?>
    <div class="page">
      <div class="container-fluid">
        <div class="page_header">
          <div class="left"><h1>Add New Customer</h1></div>
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
              <form  action="business-code/add-customer-2.php" method="post" id="add_customer_frm">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Customer Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Customer Name" name="customer_nm" id="customer_nm" value="">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Mobile Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_no" id="mobile_no" value="" onkeypress="return check(event)" maxlength="10">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Email ID </label>
                      <input type="email" class="form-control" placeholder="Email ID" name="email_id" id="email_id" value="" onkeypress="return check3(event)">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Date of Birth </label>
                      <input type="date" class="form-control" placeholder="Date of Birth" name="dob" id="dob" value="">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Address 1</label>
                      <input type="text" class="form-control" name="address_1" id="address_1" placeholder="Address 1" value="">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Address 2</label>
                      <input type="text" class="form-control" name="address_2" id="address_2" placeholder="Address 2" value="">
                    </div>
                    <div class="form-group col-md-3">
                      <label>State</label>
                      <select class="form-control" id="customer_state" name="customer_state">
                        <option value="">-Select-</option>
                        <?php
                        $get_state = mysqli_query($conn,"SELECT * FROM `states` WHERE `country_id`='101' ORDER BY `state_nm` ASC");
                        while ($row_state = mysqli_fetch_array($get_state)){
                          $state_serial = $row_state['sl'];
                          $state_name = $row_state['state_nm'];
                          ?><option value="<?php echo $state_serial;?>"><?php echo $state_name;?></option><?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Zip Code </label>
                      <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code" value="">
                    </div>
                    <div class="form-group col-md-3">
                      <label>PAN No. </label>
                      <input type="text" class="form-control" placeholder="PAN No. " name="pan_no" id="pan_no" value="">
                    </div>
                    <div class="form-group col-md-3">
                      <label>GST No. </label>
                      <input type="text" class="form-control" placeholder="GST No. " name="gst_no" id="gst_no" value="">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 text-right">
                      <button class="btn btn-success" type="submit" id="add_customer_btn" name="add_customer_btn">Confirm</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('../javascripts.php');?>
  <script type="text/javascript" src="business-js/add-customer.js"></script>
</body>
</html>
<?php
}
?>
