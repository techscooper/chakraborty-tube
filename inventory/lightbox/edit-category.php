<?php
include '../../config.php';

$category_uid = base64_decode($_GET['category_uid']);

$get_category_e=mysqli_query($conn,"SELECT * FROM  inventory_category_table WHERE unq_id='$category_uid'");
while($row_category_e=mysqli_fetch_array($get_category_e))
{
  $category_edt=$row_category_e['category'];
}
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Category Update</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
    <div class="modal-body">
      <form id="category_edt_frm" name="category_edt_frm" action="inventory-setup-code/category-edit-2.php" method="POST">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label for="">Category Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="category Name *" name="category_edt" id="category_edt" value="<?php echo $category_edt;?>">
            </div>
          </div>
        </div>
        <div class="modal-footer">
        <input type="hidden" name="category_uid_edt" id="category_uid_edt" value="<?php echo base64_encode($category_uid);?>">
        <button class="btn btn-primary btn-sm" type="reset">Reset</button>
        <button class="btn btn-success btn-sm" type="submit" id="category_edt_btn" name="category_edt_btn">Save Changes</button>
        </div>
      </form>
		</div>
	</div>
</div>
<!--Code page Link-->
<script src="../assets/js/pcoded.min.js"></script>
<script type="text/javascript" src="inventory-setup-js/category-edit.js"></script>
