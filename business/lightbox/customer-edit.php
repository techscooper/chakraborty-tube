<?php
include '../../config.php';
$c_uid=mysqli_real_escape_string($conn,base64_decode($_REQUEST['c_uid']));
$get_customer_e=mysqli_query($conn,"SELECT * FROM `customer_tbl` WHERE `unq_id`='$c_uid'");
while($row_customer_e=mysqli_fetch_array($get_customer_e)){
  $customer_nm_edt=$row_customer_e['customer_nm'];
  $email_id_edt=$row_customer_e['email_id'];
  $mobile_no_edt=$row_customer_e['mobile_no'];
  $date_of_birth_edt=$row_customer_e['date_of_birth'];
  $gst_no_edt=$row_customer_e['gst_no'];
  $pan_no_edt=$row_customer_e['pan_no'];
  $customer_state_id_edt=$row_customer_e['customer_state_id'];
  $address_1_edt=$row_customer_e['address_1'];
  $address_2_edt=$row_customer_e['address_2'];
  $zip_code_edt=$row_customer_e['zip_code'];
}
if($date_of_birth_edt!=''){$date_of_birth_edt = date('d-m-Y',strtotime($date_of_birth_edt));}
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Customer Update</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
    <div class="modal-body">
      <form id="customer_edt_frm" name="customer_edt_frm" action="business-code/customer-edit-2.php" method="POST">
        <input type="hidden" name="c_uid_edt" id="c_uid_edt" value="<?php echo base64_encode($c_uid);?>">
        <div class="row col-lg-12">
          <div class="form-group col-md-3">
            <label>Customer Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Customer Name *" name="customer_nm" id="customer_nm" value="<?php echo $customer_nm_edt;?>">
          </div>
          <div class="form-group col-md-3">
            <label>Email ID </label>
            <input type="email" class="form-control" placeholder="Email ID " name="email_id" id="email_id" value="<?php echo $email_id_edt;?>" onkeypress="return check3(event)">
          </div>
          <div class="form-group col-md-3">
            <label>Mobile Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Mobile Number *" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no_edt;?>" onkeypress="return check(event)" maxlength="10">
          </div>
          <div class="form-group col-md-3">
            <label>Date of Birth</label>
            <input type="text" class="form-control" placeholder="Date of Birth " name="dob" id="dob" value="<?php echo $date_of_birth_edt;?>" data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
          </div>
          <div class="form-group col-md-6">
            <label>Address 1</label>
            <input type="text" class="form-control" name="address_1" id="address_1" placeholder="Address 1 *" value="<?php echo $address_1_edt;?>">
          </div>
          <div class="form-group col-md-6">
            <label>Address 2</label>
            <input type="text" class="form-control" name="address_2" id="address_2" placeholder="Address 2 " value="<?php echo $address_2_edt;?>">
          </div>
          <div class="form-group col-md-3">
            <label>State</label>
            <select class="form-control" id="customer_state" name="customer_state">
              <option value="">-Select-</option>
              <?php
                $get_state = mysqli_query($conn,"SELECT * FROM states WHERE country_id='101' ORDER BY state_nm ASC");
                while ($row_state = mysqli_fetch_array($get_state))
                {
                  $state_serial = $row_state['sl'];
                  $state_name = $row_state['state_nm'];
                  ?><option value="<?php echo $state_serial;?>"<?php echo ($customer_state_id_edt == $state_serial) ? 'selected' : ''; ?>><?php echo $state_name;?></option><?php
                }
                ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label>Zip Code</label>
            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code " value="<?php echo $zip_code_edt;?>">
          </div>
          <div class="form-group col-md-3">
            <label>PAN No.</label>
            <input type="text" class="form-control" placeholder="PAN No." name="pan_no" id="pan_no" value="<?php echo $pan_no_edt;?>">
          </div>
          <div class="form-group col-md-3">
            <label>GST No.</label>
            <input type="text" class="form-control" placeholder="GST No." name="gst_no" id="gst_no" value="<?php echo $gst_no_edt;?>">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-sm" type="reset">Reset</button>
          <button class="btn btn-success btn-sm" type="submit" id="c_edt_btn" name="c_edt_btn">Save Changes</button>
        </div>
      </form>
		</div>
	</div>
</div>
<!--Code page Link-->
<script src="../assets/js/pcoded.min.js"></script>
<script type="text/javascript" src="business-js/customer-edit.js"></script>
