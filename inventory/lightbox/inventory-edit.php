<?php
include '../../config.php';

$inv_uid = base64_decode($_REQUEST['inv_uid']);
$get_inventory_e=mysqli_query($conn,"SELECT * FROM  inventory_tbl WHERE unq_id='$inv_uid'");
while($row_inventory_e=mysqli_fetch_array($get_inventory_e))
{
  $category_id=$row_inventory_e['category_id'];
  $product_code=$row_inventory_e['product_code'];
  $product_name=$row_inventory_e['product_name'];
  $sale_rate=$row_inventory_e['sale_rate'];
  $product_descp=$row_inventory_e['product_descp'];
  $product_unit=$row_inventory_e['product_unit'];
  $cgst=$row_inventory_e['cgst'];
  $sgst=$row_inventory_e['sgst'];
  $igst=$row_inventory_e['igst'];
}
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Product Update</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
    <div class="modal-body">
      <form id="inv_edt_frm" name="inv_edt_frm" action="inventory-setup-code/inventory-edit-2.php" method="POST">
        <input type="hidden" name="inv_uid_edt" id="inv_uid_edt" value="<?php echo base64_encode($inv_uid);?>">
        <div class="row col-lg-12">
          <div class="form-group col-md-6">
            <label>Category <span class="text-danger">*</span></label>
            <select class="form-control" id="category_edit" name="category_edit">
              <option value="">-Select-</option>
              <?php
                $get_category = mysqli_query($conn,"SELECT * FROM inventory_category_table WHERE stat=1");
                while ($row_category = mysqli_fetch_array($get_category))
                {
                  $category_unq_id = $row_category['unq_id'];
                  $category_name = $row_category['category'];
                  ?><option value="<?php echo $category_unq_id;?>"<?php echo ($category_id == $category_unq_id) ? 'selected' : ''; ?>><?php echo $category_name;?></option><?php
                }
                ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Product Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Product Name *" name="product_nm_edit" id="product_nm_edit" value="<?php echo $product_name;?>">
          </div>
          <div class="form-group col-md-6">
            <label>Product Code <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Product Code" name="product_code_edit" id="product_code_edit" value="<?php echo $product_code;?>">
          </div>
          <div class="form-group col-md-6">
            <label>Sale Rate <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Sale Rate *" name="sale_rate_edit" id="sale_rate_edit" value="<?php echo $sale_rate;?>">
          </div>
          <div class="form-group col-md-6">
            <label>Unit <span class="text-danger">*</span></label>
            <select class="form-control" name="product_unit_edit" id="product_unit_edit">
              <option value="">-- Select --</option>
              <?php
              $getUnit=mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `stat`=1");
              while ($rowUnit=mysqli_fetch_array($getUnit)){
                $unit_unq_id = $rowUnit['unq_id'];
                $unit_short_name = $rowUnit['unit_short_name'];
                ?><option value="<?php echo $unit_unq_id;?>" <?php if($unit_unq_id==$product_unit){ echo 'selected';} ?>><?php echo $unit_short_name;?></option><?php
              }
              ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Description </label>
            <input type="text" class="form-control" placeholder="Description " name="descp_edit" id="descp_edit" value="<?php echo $product_descp;?>">
          </div>
          <div class="form-group col-md-6">
            <label>CGST </label>
            <input type="number" class="form-control" placeholder="0.00 " name="cgst_edit" id="cgst_edit" value="<?php echo $cgst;?>" onkeyup="load_data();">
          </div>
          <div class="form-group col-md-6">
            <label>SGST </label>
            <input type="number" class="form-control" placeholder="0.00 " name="sgst_edit" id="sgst_edit" value="<?php echo $sgst;?>" readonly>
          </div>
          <div class="form-group col-md-6">
            <label>IGST </label>
            <input type="number" class="form-control" placeholder="0.00 " name="igst_edit" id="igst_edit" value="<?php echo $igst;?>" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-sm" type="reset">Reset</button>
          <button class="btn btn-success btn-sm" type="submit" id="inv_edt_btn" name="inv_edt_btn">Save Changes</button>
        </div>
      </form>
		</div>
	</div>
</div>
<!--Code page Link-->
<script src="../assets/js/pcoded.min.js"></script>
<script type="text/javascript" src="inventory-setup-js/inventory-edit.js"></script>
<script type="text/javascript">
function load_data()
{
  var cgst = $('#cgst').val();
  var sgst = $('#cgst').val();
  var igst = parseInt(cgst) + parseInt(sgst);
  $("#sgst").val(cgst);
  $("#igst").val(igst);

}
</script>
