<?php
include '../../config.php';
if($ckadmin==1){
  $temp_sl=mysqli_real_escape_string($conn,$_REQUEST['temp_sl']);
  $price_amount=get_single_value("billing_product_item_temp","sl",$temp_sl,"amount","");
?>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Price (Update)</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
    </div>
    <form id="updatePriceFrm" name="updatePriceFrm" action="invoicing-code/billing-product-temp-price-update-2.php" method="POST">
      <input type="hidden" name="sl" id="sl" value="<?php echo $temp_sl;?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-7">
            <div class="form-group">
              <div class="input-group">
                <input type="text" name="price_amount" id="price_amount" placeholder="Price" class="form-control" value="<?php echo $price_amount; ?>" onclick="select()">
                <div class="input-group-append"><span class="input-group-text">Per Piece</span></div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <div class="input-group">
                <button type="submit" class="btn btn-success" id="updatePriceBtn" name="updatePriceBtn">Save Changes</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="invoicing-js/billing-product-temp-price-update.js"></script>
<?php
}
?>