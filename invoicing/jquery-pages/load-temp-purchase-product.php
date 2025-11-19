<?php
include '../../config.php';
if($ckadmin==1){
  $tempProductCnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = 0;
  $getTempProduct=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp` WHERE `quantity`>0 AND `net_amount`>=0 AND `supplier_id`='$idadmin' ORDER BY `sl`");
  if(mysqli_num_rows($getTempProduct)>0){
    ?>
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
          <th class="text-center" style="width:5%;">#</th>
          <th class="text-center" style="width:15%;">Product</th>
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
          $tAmount=0;
          $tempProductCnt++;
          $tmpProductSl=$rowTempProduct['sl'];
          $product_id=$rowTempProduct['product_id'];
          $quantity=$rowTempProduct['quantity'];
          $product_rate=$rowTempProduct['product_rate'];
          $taxable_amount=$rowTempProduct['taxable_amount'];
          $gst_percentage=$rowTempProduct['gst_percentage'];
          $gst_value=$rowTempProduct['gst_value'];
          $net_amount=$rowTempProduct['net_amount'];

          $productName=get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
          $hsnCode=get_single_value('inventory_tbl','unq_id',$product_id,'hsn_code','');
          $product_unit=get_single_value('inventory_tbl','unq_id',$product_id,'unit_id','');
          $productUnit=get_single_value('unit_tbl','unq_id',$product_unit,'unit_short_name','');

          $taxable_amountTotal+=$taxable_amount;
          $gst_valueTotal+=$gst_value;
          $net_amountTotal+=$net_amount;
          ?>
          <tr>
            <td class="text-center"><?php echo $tempProductCnt; ?></td>
            <td class="text-left"><?php echo $productName; ?></td>
            <td class="text-left"><?php echo $hsnCode; ?></td>
            <td class="text-center"><?php echo $quantity." ".$productUnit; ?></td>
            <td class="text-right"><?php echo number_format($product_rate,2); ?></td>
            <td class="text-right"><?php echo number_format($taxable_amount,2); ?></td>
            <td class="text-right"><?php echo number_format($gst_percentage,2); ?></td>
            <td class="text-right"><?php echo number_format($gst_value,2); ?></td>
            <td class="text-right"><?php echo number_format($net_amount,2); ?></td>
            <td class="text-center"><a href="javascript:void(0);" onclick="del_tmp_product('<?php echo $tmpProductSl;?>','getTempProduct','purchase_product_item_temp')" style="color:red;"><b>Delete</b></a></td>
          </tr>
          <?php
        }
        ?>
        <tr>
          <td class="text-left" colspan="5"><b>Total</b></td>
          <td class="text-right"><b><?php echo number_format($taxable_amountTotal,2);?></b></td>
          <td></td>
          <td class="text-right"><b><?php echo number_format($gst_valueTotal,2);?></b></td>
          <td class="text-right"><b><?php echo number_format($net_amountTotal,2);?></b></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <?php
  }
}
?>