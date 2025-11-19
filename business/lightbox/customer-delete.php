<?php
include '../../config.php';
$c_uid_d=mysqli_real_escape_string($conn,base64_decode($_REQUEST['c_uid']));
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Customer Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<div class="modal-body">
  <form id="customer_delete_frm" name="customer_delete_frm" action="business-code/customer-delete-2.php" method="POST">
    <div class="row">
      <div class="col s12">
        <h5 style="color:red;">Are You Sure To Delete This ?</h5>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="customer_del_id" id="customer_del_id" value="<?php echo base64_encode($c_uid_d);?>">
      <button class="btn btn-danger btn-flat" type="submit" id="customer_del_btn" name="customer_del_btn">Confirm</button>
    </div>
  </form>
</div>
	</div>
</div>
<!--Code page Link-->
<script type="text/javascript" src="business-js/customer-delete.js"></script>
