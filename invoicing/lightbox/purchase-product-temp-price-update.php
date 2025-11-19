<?php
include '../../config.php';
if($ckadmin==1){
  $temp_sl=mysqli_real_escape_string($conn,$_REQUEST['temp_sl']);
  $amount=get_single_value("purchase_product_item_temp","sl",$temp_sl,"amount","");
?>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Price (Update)</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
    </div>
    <form id="updateFrm" name="updateFrm" action="invoicing-code/purchase-product-temp-price-update-2.php" method="POST">
      <input type="hidden" name="sl" id="sl" value="<?php echo $temp_sl;?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <input type="text" name="amount" id="amount" class="form-control form-control-sm" placeholder="Quantity" value="<?php echo $amount; ?>" onclick="select()">
          </div>
          <div class="col-md-6">
            <button type="submit" class="btn btn-success btn-sm" id="updateBtn" name="updateBtn">Save Changes</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="invoicing-js/purchase-product-temp-price-update.js"></script>
<?php
}
?>