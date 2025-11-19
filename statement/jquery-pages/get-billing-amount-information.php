<?php
include '../../config.php';
$invoice_no = $_REQUEST['invoice_no'];
$getUpdate1=mysqli_query($conn,"SELECT * FROM `billing` WHERE `invoice_no`='$invoice_no'");
while($rowUpdate1=mysqli_fetch_array($getUpdate1)) {
  $billing_disc_type=$rowUpdate1['disc_type'];
  $billing_dis_per=$rowUpdate1['dis_per'];
  $billing_dis_amnt=$rowUpdate1['dis_amnt'];
}
$getUpdate2=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `invoice_no`='$invoice_no' AND `type`=2 AND `level`=1");
while ($rowUpdate2=mysqli_fetch_array($getUpdate2)) {
  $taxable_value=$rowUpdate2['taxable_value'];
  $net_amount=$rowUpdate2['net_amount'];
}
$getUpdate2=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `invoice_no`='$invoice_no' AND `type`=2 AND `level`=4");
while ($rowUpdate2=mysqli_fetch_array($getUpdate2)) {
  $shipping_charge=$rowUpdate2['net_amount'];
}
$removeItemAmount = $removeItemAmountTotal = 0;
$getRemoveItem=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `invoice_no`='$invoice_no' AND `stat`=0");
while($rowRemoveItem=mysqli_fetch_array($getRemoveItem)) {
  $quantity=$rowRemoveItem['quantity'];
  $amount=$rowRemoveItem['amount'];
  $removeItemAmount=$quantity*$amount;
  $removeItemAmountTotal+=$removeItemAmount;
}
?>
<div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Amount Information [Before Return]</h5></div></div>
<div class="row">
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Subtotal</b></label>
      <div class="input-group">
        <input type="text" value="<?php echo $taxable_value; ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label><b>Shipping Charge</b></label>
      <input type="text" value="<?php echo $shipping_charge; ?>" class="form-control form-control-sm" min="0" readonly>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Disc Type</b></label>
      <div class="input-group">
        <input type="text" value="<?php if($billing_disc_type==1){ echo "Percentage"; }else{ echo "Fixed"; } ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Disc Rate</b></label>
      <div class="input-group">
        <input type="text" value="<?php echo $billing_dis_per; ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Disc Price</b></label>
      <div class="input-group">
        <input type="text" value="<?php echo $billing_dis_amnt; ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Net Price</b></label>
      <div class="input-group">
        <input type="text" name="n_amnt" id="n_amnt" class="form-control form-control-sm" value="<?php echo $net_amount; ?>" readonly>
      </div>
    </div>
  </div>
</div>
<div class="row"><div class="col-md-12 pt-2"><h5 class="text-info"><hr>Amount Information [After Return]</h5></div></div>
<div class="row">
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Subtotal</b></label>
      <div class="input-group">
        <input type="text" value="<?php echo $taxable_value-$removeItemAmountTotal; ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label><b>Shipping Charge</b></label>
      <input type="text" value="<?php echo $shipping_charge; ?>" class="form-control form-control-sm" min="0" readonly>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Disc Type</b></label>
      <div class="input-group">
        <input type="text" value="<?php if($billing_disc_type==1){ echo "Percentage"; }else{ echo "Fixed"; } ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Disc Rate</b></label>
      <div class="input-group">
        <input type="text" value="<?php echo $billing_dis_per; ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Disc Price</b></label>
      <div class="input-group">
        <input type="text" value="<?php echo $billing_dis_amnt; ?>" class="form-control form-control-sm" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="form-group">
      <label><b>Net Price</b></label>
      <div class="input-group">
        <input type="text" name="n_amnt" id="n_amnt" class="form-control form-control-sm" value="<?php echo $net_amount-$removeItemAmountTotal; ?>" readonly>
      </div>
    </div>
  </div>
</div>