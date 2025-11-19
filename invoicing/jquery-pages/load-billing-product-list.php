<?php
include '../../config.php';
if($ckadmin==1){
  $product_typ=mysqli_real_escape_string($conn,$_REQUEST['product_typ']);
  $product_src=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['product_src']));
  if($product_typ!=''){ $productType="AND `category_id`='$product_typ'"; }else{ $productType=""; }
  $af="%".$product_src."%";
  if($product_src!=''){ $a2=" AND (`product_name` LIKE '$af')"; }else{ $a2=''; }
  $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 $productType $a2 ORDER BY `product_name`");
  if(mysqli_num_rows($getProduct)>0){
    ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center" style="width:25%;">Product</th>
          <th class="text-center" style="width:10%;">HSN Code</th>
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
          while($rowProduct=mysqli_fetch_array($getProduct)){
            $productUnqId=$rowProduct['unq_id'];
            $product_name=$rowProduct['product_name'];
            $hsn_code=$rowProduct['hsn_code'];
            $unit_id=$rowProduct['unit_id'];
            $productUnit=get_single_value("unit_tbl","unq_id",$unit_id,"unit_short_name","");
            $qtyTempStk=get_single_value("billing_product_item_temp","product_id",$productUnqId,"quantity","AND `member_id`='$idadmin'");
            $amnTempStk=get_single_value("inventory_tbl","unq_id",$productUnqId,"sale_rate","");
            $tAmnt=((float)$qtyTempStk * (float)$amnTempStk);
            ?>
            <tr>
              <td style="width:25%;"><?php echo $product_name; ?></td>
              <td style="width:10%;"><?php echo $hsn_code; ?></td>
              <td style="width:20%;">
              <div class="input-group mb-3">
                <input type="number" name="qty<?php echo $productUnqId;?>" id="qty<?php echo $productUnqId;?>" value="<?php echo $qtyTempStk; ?>" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>')" onclick="select()" class="form-control">
                <div class="input-group-append"><span class="input-group-text"><?php echo $productUnit; ?></span></div>
              </div>
            </td>
            <td style="width:20%;">
              <div class="input-group mb-3">
                <input type="text" name="amnt<?php echo $productUnqId;?>" id="amnt<?php echo $productUnqId;?>" value="<?php echo $amnTempStk; ?>" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>')" onclick="select()" class="form-control">
              </div>
            </td>
            <td style="width:20%;">
              <div class="input-group mb-3">
                <input type="text" name="tamnt<?php echo $productUnqId;?>" id="tamnt<?php echo $productUnqId;?>" value="<?php echo number_format($tAmnt,2); ?>" class="form-control" readonly>
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
  else{
    ?>
    <div class="text-center">
      <table class="table table-bordered">
        <tr>
          <td><?php if($product_src!=""){echo "Your search - <b>$product_src</b> - doesn't match any product.";} ?></td>
        </tr>
      </table>
    </div>
    <?php
  }
}
?>