<?php
include '../../config.php';
if($ckadmin==1){
  $inventoryUnqID=mysqli_real_escape_string($conn,base64_decode($_REQUEST['inventoryUnqID']));
  $category_id = $product_code = $product_name = $purchase_rate = $sale_rate = $product_descp = $unit_id = $hsn_code = $cgst = $sgst = $igst = '';
  $getInventoryUpdate=mysqli_query($conn,"SELECT * FROM  `inventory_tbl` WHERE `unq_id`='$inventoryUnqID'");
  while($rowInventoryUpdate=mysqli_fetch_array($getInventoryUpdate)){
    $category_id=$rowInventoryUpdate['category_id'];
    $product_code=$rowInventoryUpdate['product_code'];
    $product_name=$rowInventoryUpdate['product_name'];
    $purchase_rate=$rowInventoryUpdate['purchase_rate'];
    $sale_rate=$rowInventoryUpdate['sale_rate'];
    $product_descp=$rowInventoryUpdate['product_descp'];
    $unit_id=$rowInventoryUpdate['unit_id'];
    $hsn_code=$rowInventoryUpdate['hsn_code'];
    $cgst=$rowInventoryUpdate['cgst'];
    $sgst=$rowInventoryUpdate['sgst'];
    $igst=$rowInventoryUpdate['igst'];
  }
  ?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="inventoryUpdateFrm" action="inventory-code/inventory-update-2.php" method="POST">
        <input type="hidden" name="inventoryUnqID" id="inventoryUnqID" value="<?php echo base64_encode($inventoryUnqID);?>">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Product Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label><b>Product Name <span class="text-danger">*</span></b></label>
                <input type="text" name="product_name_update" id="product_name_update" value="<?php echo $product_name; ?>" class="form-control" placeholder="Product Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Category <span class="text-danger">*</span></label>
                <select id="category_id_update" name="category_id_update" class="form-control">
                  <option value="">-Select-</option>
                  <?php
                  $getCategory=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1");
                  while($rowCategory=mysqli_fetch_array($getCategory)){
                    $categoryUnqID=$rowCategory['unq_id'];
                    $categoryName=$rowCategory['category_name'];
                    ?><option value="<?php echo $categoryUnqID;?>"<?php echo ($categoryUnqID==$category_id) ? 'selected' : ''; ?>><?php echo $categoryName; ?></option><?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Unit <span class="text-danger">*</span></b></label>
                <select name="unit_id_update" id="unit_id_update" class="form-control">
                  <option value="">-- Select --</option>
                  <?php
                  $getUnit=mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `stat`=1");
                  while($rowUnit=mysqli_fetch_array($getUnit)){
                    $unit_unq_id=$rowUnit['unq_id'];
                    $unit_short_name=$rowUnit['unit_short_name'];
                    ?><option value="<?php echo $unit_unq_id; ?>" <?php if($unit_unq_id==$unit_id){ echo 'SELECTED'; }?>><?php echo $unit_short_name;?></option><?php
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Purchase Rate <span class="text-danger">*</span></b></label>
                <input type="text" name="purchase_rate_update" id="purchase_rate_update" value="<?php echo $purchase_rate; ?>" class="form-control" placeholder="Purchase Rate" onclick="select()">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Sale Rate <span class="text-danger">*</span></b></label>
                <input type="text" name="sale_rate_update" id="sale_rate_update" value="<?php echo $sale_rate; ?>" class="form-control" placeholder="Sale Rate" onclick="select()">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>HSN Code</b></label>
                <input type="text" name="hsn_code_update" id="hsn_code_update" value="<?php echo $hsn_code; ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>CGST</b></label>
                <input type="number" name="cgst_update" id="cgst_update" value="<?php echo $cgst; ?>" class="form-control" onkeyup="getGSTCalculator()" onclick="select()">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>SGST</b></label>
                <input type="number" name="sgst_update" id="sgst_update" value="<?php echo $sgst; ?>" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>IGST</b></label>
                <input type="number" name="igst_update" id="igst_update" value="<?php echo $igst; ?>" class="form-control" readonly>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label><b>Product Description</b></label>
                <input type="text" name="product_descp_update" id="product_descp_update" value="<?php echo $product_descp; ?>" class="form-control" placeholder="Description">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-primary">Reset</button>
          <button type="submit" class="btn btn-success" id="inventoryUpdateBtn">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
  <script src="../assets/js/pcoded.min.js"></script>
  <script type="text/javascript" src="inventory-js/inventory-update.js"></script>
  <script type="text/javascript">
    function getGSTCalculator(){
      var cgst=$('#cgst_update').val();
      var igst=parseInt(cgst) + parseInt(cgst);
      $("#sgst_update").val(cgst);
      $("#igst_update").val(igst);
    }
  </script>
<?php
}
?>