<?php
include '../../config.php';
if($ckadmin==1){
  $tempProductCnt = $grandQuantity = $grandTaxableAmount = $grandGstValue = $grandTotalAmount = 0;
  $getTempProduct=mysqli_query($conn,"SELECT * FROM `billing_product_item_temp` WHERE `quantity`!='0' AND `product_rate`!='0' AND `member_id`='$idadmin'");
  if(mysqli_num_rows($getTempProduct)>0){
?>
<table class="table table-sm table-bordered">
  <thead>
    <tr>
      <th class="text-center" style="width:2%;">#</th>
      <th class="text-center" style="width:18%;">Product</th>
      <th class="text-center" style="width:10%;">HSN Code</th>
      <th class="text-center" style="width:10%;">Qty</th>
      <th class="text-center" style="width:10%;">Rate</th>
      <th class="text-center" style="width:10%;">Taxable</th>
      <th class="text-center" style="width:10%;">GST(%)</th>
      <th class="text-center" style="width:10%;">GST Value</th>
      <th class="text-center" style="width:10%;">Net Amount</th>
      <th class="text-center" style="width:10%;">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($rowTempProduct=mysqli_fetch_array($getTempProduct)){
      $productRate = $taxableAmount = $igstPercentage = $igstValue = $netAmount = 0;
      $tempProductCnt++;
      $tmpProductSl=$rowTempProduct['sl'];
      $product_id=$rowTempProduct['product_id'];
      $quantity=$rowTempProduct['quantity'];
      $productRate=$rowTempProduct['product_rate'];
      $productName=get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
      $hsnCode=get_single_value('inventory_tbl','unq_id',$product_id,'hsn_code','');
      $gstPercentage=get_single_value('inventory_tbl','unq_id',$product_id,'igst','');
      $product_unit=get_single_value('inventory_tbl','unq_id',$product_id,'unit_id','');
      $productUnit=get_single_value('unit_tbl','unq_id',$product_unit,'unit_short_name','');
      $taxableAmount = $productRate * $quantity;
      $gstValue=round((($taxableAmount*$gstPercentage)/100),2);
      $netAmount=$taxableAmount+$gstValue;
      
      $grandQuantity+=$quantity;
      $grandTaxableAmount+=$taxableAmount;
      $grandGstValue+=$gstValue;
      $grandTotalAmount+=$netAmount;
      ?>
      <tr>
        <td class="text-center"><?php echo $tempProductCnt; ?></td>
        <td class="text-left"><?php echo $productName; ?></td>
        <td class="text-left"><?php echo $hsnCode; ?></td>
        <td class="text-center"><?php echo "$quantity $productUnit"; ?></td>
        <td class="text-right"><?php echo number_format($productRate,2); ?></td>
        <td class="text-right"><?php echo number_format($taxableAmount,2); ?></td>
        <td class="text-right"><?php echo number_format($gstPercentage,2); ?></td>
        <td class="text-right"><?php echo number_format($gstValue,2); ?></td>
        <td class="text-right"><?php echo number_format($netAmount,2); ?></td>
        <td class="text-center"><a href="javascript:void(0);" onclick="del_tmp_product('<?php echo $tmpProductSl; ?>','getTempProduct','billing_product_item_temp')" style="color:red;"><b>Delete</b></a></td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td class="text-left" colspan="3"><b>Total</b></td>
      <td class="text-center"><b><?php echo "$grandQuantity $productUnit";?></b></td>
      <td></td>
      <td class="text-right"><b><?php echo number_format($grandTaxableAmount,2);?></b></td>
      <td></td>
      <td class="text-right"><b><?php echo number_format($grandTotalAmount,2);?></b></td>
      <td class="text-right"><b><?php echo number_format($grandTotalAmount,2);?></b></td>
      <td></td>
    </tr>
  </tbody>
</table>
<?php
  }
  else{
    echo "<div class=\"text-center\"><h6>No Product</h6></div>";
  }
}
?>