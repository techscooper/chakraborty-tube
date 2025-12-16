<?php
include '../../config.php';
if($ckadmin==1){
?>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5><i class="fa fa-plus-circle"></i> Add New Product</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
        <form action="../inventory/inventory-code/inventory-add-2.php" method="post" id="addInventoryFrm">
            <div class="row">
                <div class="col-md-4">
                <div class="form-group">
                    <label><b>Category <span class="text-danger">*</span></b></label>
                    <select class="form-control" id="category_id" name="category_id">
                    <option value="">-- Select --</option>
                    <?php
                        $getCategory=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1 ORDER BY `category_name`");
                        while ($rowCategory=mysqli_fetch_array($getCategory)){
                        $categoryUnqID=$rowCategory['unq_id'];
                        $categoryName=$rowCategory['category_name'];
                        ?>
                    <option value="<?php echo $categoryUnqID;?>"><?php echo $categoryName; ?></option>
                    <?php
                        }
                        ?>
                    </select>
                </div>
                </div>
                <div class="col-md-8">
                <div class="form-group">
                    <label><b>Product Name <span class="text-danger">*</span></b></label>
                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label><b>Unit <span class="text-danger">*</span></b></label>
                    <select class="form-control" name="unit_id" id="unit_id">
                    <option value="">-- Select --</option>
                    <?php
                        $getUnit=mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `stat`=1");
                        while ($rowUnit=mysqli_fetch_array($getUnit)){
                        $unit_unq_id = $rowUnit['unq_id'];
                        $unit_short_name = $rowUnit['unit_short_name'];
                        ?>
                    <option value="<?php echo $unit_unq_id;?>"><?php echo $unit_short_name;?></option>
                    <?php
                        }
                        ?>
                    </select>
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label><b>Purchase Rate <span class="text-danger">*</span></b></label>
                    <input type="text" name="purchase_rate" id="purchase_rate" value="0" class="form-control" placeholder="Purchase Rate" onclick="select()">
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label><b>Sale Rate <span class="text-danger">*</span></b></label>
                    <input type="text" name="sale_rate" id="sale_rate" value="0" class="form-control" placeholder="Sale Rate" onclick="select()">
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label><b>HSN Code</b> <small><a href="https://services.gst.gov.in/services/searchhsnsac" target="_blank"><i class="fa fa-info-circle"></i> Find HSN Code</a></small></label>
                    <input type="text" name="hsn_code" id="hsn_code" class="form-control">
                    
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label><b>CGST</b></label>
                    <input type="number" name="cgst" id="cgst" value="0" class="form-control" onkeyup="getGSTCalculator()" onclick="select()">
                </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                    <label><b>SGST</b></label>
                    <input type="number" name="sgst" id="sgst" value="0" class="form-control" readonly>
                </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                    <label><b>IGST</b></label>
                    <input type="number" name="igst" id="igst" value="0" class="form-control" readonly>
                </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                    <label><b>Opening Stock</b></label>
                    <input type="number" name="opening_stock" id="opening_stock" value="0" class="form-control" readonly>
                </div>
                </div>
                <div class="col-12">
                <div class="form-group">
                    <label><b>Product Description</b></label>
                    <input type="text" name="product_descp" id="product_descp" class="form-control" placeholder="Description">
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                <button class="btn btn-success" type="submit" id="addInventoryBtn">Confirm</button>
                </div>
            </div>
            </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="../inventory/inventory-js/inventory-add.js"></script>
<script>
    function getGSTCalculator(){
    let cgst = parseFloat($('#cgst').val());
    let igst = cgst + cgst;
    $('#sgst').val(cgst);
    $('#igst').val(igst);
    }
</script>
<?php
  }
  ?>