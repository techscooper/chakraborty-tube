<?php
include '../../config.php';
$bank_info_unq_id=mysqli_real_escape_string($conn,base64_decode($_REQUEST['bank_info_unq_id']));
$get_bank_info_e=mysqli_query($conn,"SELECT * FROM  bank_information_tbl WHERE unq_id='$bank_info_unq_id'");
while($row_bank_info_e=mysqli_fetch_array($get_bank_info_e)){
  $bank_holder_name_edt=$row_bank_info_e['bank_holder_nm'];
  $bank_name_edt=$row_bank_info_e['bank_nm'];
  $bank_account_number_edt=$row_bank_info_e['bank_ac_number'];
  $branch_name_edt=$row_bank_info_e['branch_nm'];
  $ifsc_code_edt=$row_bank_info_e['ifsc_code'];
}
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Bank Information Update</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
    <div class="modal-body">
      <form id="bank_info_edt_frm" name="bank_info_edt_frm" action="business-code/bank-info-edit-2.php" method="POST">
      <div class="row">
        <div class="form-group col-md-4">
        <label for="">Bank Holder Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Bank Holder Name *" name="bank_h_nm_e" id="bank_h_nm_e" value="<?php echo $bank_holder_name_edt; ?>">
        </div>
        <div class="form-group col-md-4">
        <label for="">Bank Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Bank Name *" name="bank_nm_e" id="bank_nm_e" value="<?php echo $bank_name_edt; ?>">
        </div>
        <div class="form-group col-md-4">
        <label for="">Bank A/C Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Bank A/C Number *" name="bank_ac_no_e" id="bank_ac_no_e" value="<?php echo $bank_account_number_edt; ?>">
        </div>
        <div class="form-group col-md-4">
        <label for="">Branch Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Branch Name *" name="branch_nm_e" id="branch_nm_e" value="<?php echo $branch_name_edt; ?>">
        </div>
        <div class="form-group col-md-4">
        <label for="">IFSC Code <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="IFSC Code *" name="ifsc_code_e" id="ifsc_code_e" value="<?php echo $ifsc_code_edt; ?>">
        </div>
    </div>
        <div class="modal-footer">
        <input type="hidden" name="bank_info_unq_id" id="bank_info_unq_id" value="<?php echo base64_encode($bank_info_unq_id);?>">
        <button class="btn btn-primary btn-sm" type="reset">Reset</button>
        <button class="btn btn-success btn-sm" type="submit" id="bank_info_edt_btn" name="bank_info_edt_btn">Save Changes</button>
        </div>
      </form>
		</div>
	</div>
</div>
<script src="../assets/js/pcoded.min.js"></script>
<script type="text/javascript" src=""></script>
<script type="text/javascript" src="business-js/bank-info-edit.js"></script>