<?php
include '../../config.php';
$s_uid=mysqli_real_escape_string($conn,base64_decode($_REQUEST['s_uid']));
$get_supplier_e=mysqli_query($conn,"SELECT * FROM supplier_tbl WHERE unq_id='$s_uid'");
while($row_supplier_e=mysqli_fetch_array($get_supplier_e)){
  $supplier_nm_edt=$row_supplier_e['supplier_nm'];
  $email_id_edt=$row_supplier_e['email_id'];
  $mobile_no_edt=$row_supplier_e['mobile_no'];
  $gst_no_edt=$row_supplier_e['gst_no'];
  $supplier_state_id_edt=$row_supplier_e['supplier_state_id'];
  $address_1_edt=$row_supplier_e['address_1'];
  $address_2_edt=$row_supplier_e['address_2'];
  $zip_code_edt=$row_supplier_e['zip_code'];
}
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Supplier Update</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
    <div class="modal-body">
      <form id="supplier_edt_frm" name="supplier_edt_frm" action="business-code/supplier-edit-2.php" method="POST">
        <input type="hidden" name="s_uid_edt" id="s_uid_edt" value="<?php echo base64_encode($s_uid);?>">
        <div class="row col-lg-12">
          <div class="form-group col-md-4">
            <label>Supplier Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Supplier Name *" name="supplier_nm" id="supplier_nm" value="<?php echo $supplier_nm_edt;?>">
          </div>
          <div class="form-group col-md-4">
            <label>Email ID </label>
            <input type="email" class="form-control" placeholder="Email ID" name="email_id" id="email_id" value="<?php echo $email_id_edt;?>" onkeypress="return check3(event)">
          </div>
          <div class="form-group col-md-4">
            <label>Mobile Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Mobile Number *" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no_edt;?>" onkeypress="return check(event)" maxlength="10">
          </div>
          <div class="form-group col-md-6">
            <label>Address 1</label>
            <input type="text" class="form-control" name="address_1" id="address_1" placeholder="Address 1" value="<?php echo $address_1_edt;?>">
          </div>
          <div class="form-group col-md-6">
            <label>Address 2</label>
            <input type="text" class="form-control" name="address_2" id="address_2" placeholder="Address 2" value="<?php echo $address_2_edt;?>">
          </div>
          <div class="form-group col-md-4">
            <label>State</label>
            <select class="form-control" id="supplier_state" name="supplier_state">
              <option value="">-Select-</option>
              <?php
                $get_state = mysqli_query($conn,"SELECT * FROM states WHERE country_id='101' ORDER BY state_nm ASC");
                while ($row_state = mysqli_fetch_array($get_state))
                {
                  $state_serial = $row_state['sl'];
                  $state_name = $row_state['state_nm'];
                  ?><option value="<?php echo $state_serial;?>"<?php echo ($supplier_state_id_edt == $state_serial) ? 'selected' : ''; ?>><?php echo $state_name;?></option><?php
                }
                ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label>Zip Code </label>
            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php echo $zip_code_edt;?>">
          </div>
          <div class="form-group col-md-4">
            <label>GST No. </label>
            <input type="text" class="form-control" placeholder="GST No." name="gst_no" id="gst_no" value="<?php echo $gst_no_edt;?>">
          </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-primary btn-sm" type="reset">Reset</button>
        <button class="btn btn-success btn-sm" type="submit" id="s_edt_btn" name="s_edt_btn">Save Changes</button>
        </div>
      </form>
		</div>
	</div>
</div>
<script src="../assets/js/pcoded.min.js"></script>
<script type="text/javascript" src="business-js/supplier-edit.js"></script>
