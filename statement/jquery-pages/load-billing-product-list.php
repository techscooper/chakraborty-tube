<?php
include '../../config.php';
$product_typ=mysqli_real_escape_string($conn,$_REQUEST['product_typ']);
$emp_id=mysqli_real_escape_string($conn,$_REQUEST['emp_id']);
$product_src=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['product_src']));
$af="%".$product_src."%";
if($product_src!=''){$a2=" AND (`product_name` LIKE '$af' OR `product_code` LIKE '$af')";}else{$a2='';}
$product_cnt = 0;
$getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 AND `category_id`='$product_typ' $a2 ORDER BY `product_name`");
$rcntProduct=mysqli_num_rows($getProduct);
if($rcntProduct>0){
?>
<table class="table table-bordered">
 <thead>
   <tr>
     <th class="text-center" style="width:5%;">#</th>
     <th class="text-center" style="width:25%;">Product</th>
     <th class="text-center" style="width:10%;">Available</th>
     <th class="text-center" style="width:20%;">Quantity</th>
     <th class="text-center" style="width:20%;">Rate</th>
     <th class="text-center" style="width:20%;">Price</th>
   </tr>
 </thead>
</table>
<div style="height:300px; overflow: scroll;">
<table class="table table-bordered">
 <tbody>
<?php
while ($rowProduct=mysqli_fetch_array($getProduct)){
  $product_cnt++;
  $productUnqId = $rowProduct['unq_id'];
  $product_name = $rowProduct['product_name'];
  $product_code = $rowProduct['product_code'];
  $product_unit = $rowProduct['product_unit'];

  $tAmnt = $tStock_in = $tStock_out = $eStock_in = $eStock_out = 0;
  $getStockIn = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockin` FROM `stock_master` WHERE `stat`=1 AND `typ`=10 AND `product_id`='$productUnqId'");
  while($rowStockIn = mysqli_fetch_array($getStockIn)){
    $tStock_in = $rowStockIn['stockin'];
  }

  $getStockOut = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockout` FROM `stock_master` WHERE `stat`=1 AND `typ`=20 AND `product_id`='$productUnqId'");
  while($rowStockOut = mysqli_fetch_array($getStockOut)){
    $tStock_out = $rowStockOut['stockout'];
  }

  $productUnit = get_single_value("unit_tbl","unq_id",$product_unit,"unit_short_name","",$conn);
  $amnTempStk = get_single_value("inventory_tbl","unq_id",$productUnqId,"sale_rate","",$conn);
  $avStk = $tStock_in-$tStock_out;
  ?>
  <tr>
    <td style="width:5%;" class="text-center"><?php echo $product_cnt; ?></td>
    <td style="width:25%;"><?php echo $product_name.' ('.$product_code.')'; ?></td>
    <td style="width:10%;" class="text-center"><?php echo $avStk." ".$productUnit; ?></td>
    <td style="width:20%;">
      <div class="input-group mb-3">
        <input type="number" name="qty<?php echo $productUnqId;?>" id="qty<?php echo $productUnqId;?>" value="<?php echo $qtyTempStk; ?>" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>','<?php echo $avStk; ?>')" onclick="select()" class="form-control" min="0" placeholder="00">
        <div class="input-group-append"><span class="input-group-text"><?php echo $productUnit; ?></span></div>
      </div>
    </td>
    <?php
    if($lvl_u_admin<0)
    {
      ?>
      <td style="width:20%;">
        <div class="input-group mb-3">
          <input type="text" name="amnt<?php echo $productUnqId;?>" id="amnt<?php echo $productUnqId;?>" value="<?php echo $amnTempStk; ?>" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>','<?php echo $avStk; ?>')" onclick="select()" class="form-control" placeholder="00.00">
        </div>
      </td>
      <?php
    }
    else
    {
      ?>
      <td style="width:20%;">
        <div class="input-group mb-3">
          <input type="text" name="amnt<?php echo $productUnqId;?>" id="amnt<?php echo $productUnqId;?>" value="<?php echo $amnTempStk; ?>" class="form-control" placeholder="00.00" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>','<?php echo $avStk; ?>')">
        </div>
      </td>
      <?php
    }
    ?>
    <td style="width:20%;">
      <div class="input-group mb-3">
        <input type="text" name="tamnt<?php echo $productUnqId;?>" id="tamnt<?php echo $productUnqId;?>" value="<?php echo number_format($tAmnt,2); ?>" class="form-control" placeholder="00.00" readonly>
      </div>
    </td>
  </tr>
  <?php
}
?>
</tbody>
</table>
</div>
<?php
}
else
{
  ?>
  <div class="text-center">
    <table class="table table-bordered">
      <tr>
        <td><?php if($product_src!=""){echo "Your search - <b>$product_src</b> - doesn't match any product.";} ?></td>
      </tr>
    </table>
  </div><?php
}
?>