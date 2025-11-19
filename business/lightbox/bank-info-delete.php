<?php
include '../../config.php';
$bank_info_unq_id=mysqli_real_escape_string($conn,base64_decode($_REQUEST['bank_info_unq_id']));
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Bank Information Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<div class="modal-body">
  <form id="bank_info_delete_frm" name="worker_delete_frm" action="business-code/bank-info-delete-2.php" method="POST">
    <div class="row">
      <div class="col s12">
        <h5 style="color:red;">Are You Sure To Delete This ?</h5>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="bank_info_unq_id" id="bank_info_unq_id" value="<?php echo base64_encode($bank_info_unq_id);?>">
      <button class="btn btn-danger btn-flat" type="submit" id="bank_info_del_btn" name="bank_info_del_btn">Confirm</button>
    </div>
  </form>
</div>
	</div>
</div>
<!--Code page Link-->
<script type="text/javascript" src="business-js/bank-info-delete.js"></script>
