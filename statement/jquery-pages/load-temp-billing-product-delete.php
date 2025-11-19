<?php
include '../../config.php';
$invoice_no=$_REQUEST['invoice_no'];
$tempProductCnt = $gAmount = 0;
$getTempProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_update` WHERE `stat`=0 AND `invoice_no`='$invoice_no'");
if(mysqli_num_rows($getTempProduct)>0){
?>
<table class="table table-sm table-bordered">
  <thead>
    <tr>
      <th class="text-center" style="width:5%;">#</th>
      <th class="text-center" style="width:40%;">Product</th>
      <th class="text-center" style="width:15%;">Quantity</th>
      <th class="text-center" style="width:15%;">Price</th>
      <th class="text-center" style="width:15%;">Total</th>
      <th class="text-center" style="width:20%;">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($rowTempProduct=mysqli_fetch_array($getTempProduct)){
      $tAmount = 0;
      $tempProductCnt++;
      $tmpProductSl = $rowTempProduct['sl'];
      $product_id = $rowTempProduct['product_id'];
      $quantity = $rowTempProduct['quantity'];
      $amount = $rowTempProduct['amount'];
      $productName = get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
      $productCode = get_single_value('inventory_tbl','unq_id',$product_id,'product_code','');
      $product_unit = get_single_value('inventory_tbl','unq_id',$product_id,'product_unit','');
      $productUnit = get_single_value('unit_tbl','unq_id',$product_unit,'unit_short_name','');

      $tAmount = $amount * $quantity;
      $gAmount = $gAmount + $tAmount;
      ?>
      <tr>
        <td class="text-center"><?php echo $tempProductCnt; ?></td>
        <td class="text-left"><?php echo "$productName ($productCode)"; ?></td>
        <td class="text-center"><?php echo "$quantity $productUnit"; ?></td>
        <td class="text-right"><?php echo number_format($amount,2); ?></td>
        <td class="text-right"><?php echo number_format($tAmount,2); ?></td>
        <td class="text-center"><a href="javascript:void(0);" onclick="getTempProduct('<?php echo $invoice_no; ?>','<?php echo $tmpProductSl;?>','1')" style="color:red;"><b>Restore</b></a></td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td class="text-left" colspan="4"><b>Total</b></td>
      <td class="text-right"><b><?php echo number_format($gAmount,2);?></b></td>
      <td></td>
    </tr>
  </tbody>
</table>
<?php
}
else{
  echo "<div class=\"text-center\"><h6>No Product</h6></div>";
}
?>