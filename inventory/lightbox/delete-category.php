<?php
include '../../config.php';

$category_uid_d = base64_decode($_GET['category_uid']);

?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Category Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<div class="modal-body">
  <form id="category_delete_frm" name="category_delete_frm" action="inventory-setup-code/category-delete-2.php" method="POST">
    <div class="row">
      <div class="col s12">
        <h5 style="category:red;">Are You Sure To Delete This ?</h5>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="category_del_id" id="category_del_id" value="<?php echo base64_encode($category_uid_d);?>">
      <button class="btn btn-danger btn-flat" type="submit" id="category_del_btn" name="category_del_btn">Confirm</button>
    </div>
  </form>
</div>
	</div>
</div>
<!--Code page Link-->
<script type="text/javascript" src="inventory-setup-js/category-delete.js"></script>
