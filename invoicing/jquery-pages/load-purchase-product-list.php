<?php
include '../../config.php';
if($ckadmin==1){
  $emp_id=mysqli_real_escape_string($conn,$_REQUEST['emp_id']);
  $product_typ=mysqli_real_escape_string($conn,$_REQUEST['product_typ']);
  $product_src=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['product_src']));
  $af="%".$product_src."%";
  if($product_src!=''){ $a2=" AND (`product_name` LIKE '$af' OR `hsn_code` LIKE '$af')"; }else{ $a2=''; }
  $product_cnt = 0;
  $productUnqId = $product_name = $product_unit = "";
  $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 AND `category_id`='$product_typ' $a2 ORDER BY `product_name`");
  if(mysqli_num_rows($getProduct)>0){
    ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center" style="width:5%;">#</th>
          <th class="text-center" style="width:35%;">
            Product <a href="javascript:void(0);" onclick="addProduct()"><i class="fa fa-plus-circle"></i> Add</a>
          </th>
          <th class="text-center" style="width:20%;">Quantity</th>
          <th class="text-center" style="width:15%;">Rate</th>
          <th class="text-center" style="width:15%;">Price</th>
        </tr>
      </thead>
    </table>
    <div style="height:300px; overflow: scroll;">
      <table class="table table-bordered">
       <tbody>
        <?php
        while($rowProduct=mysqli_fetch_array($getProduct)){
          $tAmnt=0;
          $product_cnt++;
          $productUnqId=$rowProduct['unq_id'];
          $product_name=$rowProduct['product_name'];
          $hsn_code=$rowProduct['hsn_code'];
          $unit_id=$rowProduct['unit_id'];
          $purchase_rate=$rowProduct['purchase_rate'];

          $productUnit=get_single_value("unit_tbl","unq_id",$unit_id,"unit_short_name","");
          $qtyStk=get_single_value("purchase_product_item_temp","product_id",$productUnqId,"quantity","");
          $qtyAmnt=get_single_value("purchase_product_item_temp","product_id",$productUnqId,"product_rate","");
          if($qtyAmnt==0 OR $qtyAmnt==''){ $qtyAmnt=$purchase_rate; }
          $tAmnt = ((float)$qtyStk * (float)$qtyAmnt);
          ?>
          <tr>
            <td style="width:5%;" class="text-center"><?php echo $product_cnt; ?></td>
            <td style="width:35%;"><?php echo $product_name.' ('.$hsn_code.')'; ?></td>
            <td style="width:20%;">
              <div class="input-group mb-3">
                <input type="number" name="qty<?php echo $productUnqId;?>" id="qty<?php echo $productUnqId;?>" value="<?php echo $qtyStk; ?>" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>')" onclick="select()" class="form-control" min="0">
                <div class="input-group-append"><span class="input-group-text"><?php echo $productUnit; ?></span></div>
              </div>
            </td>
            <td style="width:15%;">
              <input type="number" name="amnt<?php echo $productUnqId;?>" id="amnt<?php echo $productUnqId;?>" value="<?php echo $qtyAmnt; ?>" onblur="saveSingleProductTemp('<?php echo $productUnqId;?>')" onclick="select()" class="form-control">
            </td>
            <td style="width:15%;">
              <input type="number" name="tamnt<?php echo $productUnqId;?>" id="tamnt<?php echo $productUnqId;?>" value="<?php echo $tAmnt; ?>" class="form-control" readonly>
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
          <td><?php if($product_src!=''){echo "Your search - <b>$product_src</b> - doesn't match any product.";} ?></td>
        </tr>
      </table>
    </div>
    <?php
  }
}
?>