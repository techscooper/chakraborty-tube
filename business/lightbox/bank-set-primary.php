<?php
include '../../config.php';
$bank_info_unq_id=mysqli_real_escape_string($conn,base64_decode($_REQUEST['bank_uid']));
$vl=mysqli_real_escape_string($conn,$_REQUEST['vl']);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Bank Primary</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<div class="modal-body">
  <form id="set_primary_frm" name="set_primary_frm" action="business-code/bank-set-primary-2.php" method="POST">
    <div class="row">
      <div class="col s12">
        <h5 style="color:red;">Are You Sure To Primary This ?</h5>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="bank_info_u_id" id="bank_info_u_id" value="<?php echo base64_encode($bank_info_unq_id);?>">
      <input type="hidden" name="bank_primary_vl" id="bank_primary_vl" value="<?php echo $vl;?>">
      <button class="btn btn-primary btn-flat" type="submit" id="set_primary_btn" name="set_primary_btn">Confirm</button>
    </div>
  </form>
</div>
	</div>
</div>
<script type="text/javascript" src="business-js/bank-set-primary.js"></script>