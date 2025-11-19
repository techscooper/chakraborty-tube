<?php
include '../../config.php';
$s_uid_d=mysqli_real_escape_string($conn,base64_decode($_REQUEST['s_uid']));
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Supplier Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<div class="modal-body">
  <form id="supplier_delete_frm" name="supplier_delete_frm" action="business-code/supplier-delete-2.php" method="POST">
    <div class="row">
      <div class="col s12">
        <h5 style="color:red;">Are You Sure To Delete This ?</h5>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="supplier_del_id" id="supplier_del_id" value="<?php echo base64_encode($s_uid_d);?>">
      <button class="btn btn-danger btn-flat" type="submit" id="supplier_del_btn" name="supplier_del_btn">Confirm</button>
    </div>
  </form>
</div>
	</div>
</div>
<script type="text/javascript" src="business-js/supplier-delete.js"></script>