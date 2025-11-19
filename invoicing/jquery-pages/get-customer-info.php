<?php
include '../../config.php';
if($ckadmin==1){
  $mobile_no=mysqli_real_escape_string($conn,$_REQUEST['mobile_no']);
  $customer_nm = $email_id = $gst_no = $customer_state_id = $address_1 = $address_2 = $zip_code = '';  
  $getCustomerInfo=mysqli_query($conn,"SELECT * FROM `customer_tbl` WHERE `stat`=1 AND `mobile_no`='$mobile_no'");
  while($rowCustomerInfo=mysqli_fetch_array($getCustomerInfo)) {
    $customer_nm=$rowCustomerInfo['customer_nm'];
    $email_id=$rowCustomerInfo['email_id'];
    $gst_no=$rowCustomerInfo['gst_no'];
    $pan_no=$rowCustomerInfo['pan_no'];
    $customer_state_id=$rowCustomerInfo['customer_state_id'];
    $address_1=$rowCustomerInfo['address_1'];
    $address_2=$rowCustomerInfo['address_2'];
    $zip_code=$rowCustomerInfo['zip_code'];
  }
  ?>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label><b>Customer Name</b><span class="text-danger"> *</span></label>
        <input type="text" name="customer_nm" id="customer_nm" value="<?php echo $customer_nm; ?>" class="form-control form-control-sm">
        </td>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label><b>Email ID</b><span class="text-danger"> *</span></label>
        <input type="text" name="email_id" id="email_id" value="<?php echo $email_id; ?>" class="form-control form-control-sm">
        </td>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label><b>GST No</b></label>
        <input type="text" name="gst_no" id="gst_no" value="<?php echo $gst_no; ?>" class="form-control form-control-sm">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label><b>Pan No</b></label>
        <input type="text" name="pan_no" id="pan_no" value="<?php echo $pan_no; ?>" class="form-control form-control-sm">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label><b>ZIP Code</b></label>
        <input type="text" name="zip_code" id="zip_code" value="<?php echo $zip_code; ?>" class="form-control form-control-sm">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><b>Address Line 1</b></label>
        <input type="text" name="address_1" id="address_1" value="<?php echo $address_1; ?>" class="form-control form-control-sm">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><b>Address Line 2</b></label>
        <input type="text" name="address_2" id="address_2" value="<?php echo $address_2; ?>" class="form-control form-control-sm">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label><b>State</b></label>
        <select name="customer_state_id" id="customer_state_id" class="form-control form-control-sm">
          <option value="">-- Select --</option>
          <?php
          $getCustomerState=mysqli_query($conn,"SELECT * FROM `states` WHERE `country_id`=101 ORDER BY `state_nm`");
          while($rowCustomerState=mysqli_fetch_array($getCustomerState)) {
            $customerStateSl=$rowCustomerState['sl'];
            $customerStateName=$rowCustomerState['state_nm'];
            ?><option value="<?php echo $customerStateSl; ?>" <?php if($customerStateSl==$customer_state_id){ echo 'SELECTED'; } ?>><?php echo $customerStateName; ?></option><?php
          }
          ?>
        </select>
      </div>
    </div>
  </div>
 <?php
}
?>