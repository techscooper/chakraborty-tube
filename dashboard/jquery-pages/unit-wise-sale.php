<?php
include '../../config.php';
$dashboard_unit=mysqli_real_escape_string($conn,$_REQUEST['dashboard_unit']);
if($dashboard_unit!=""){
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-sm table-hover mb-0 c_table">
          <tr>
           <th class="text-center" style="width:5%;">#</th>
           <th class="text-center" style="width:35%;">Product</th>
           <th class="text-center" style="width:20%;">Quantity</th>
           <th class="text-center" style="width:20%;">Rate</th>
           <th class="text-center" style="width:20%;">Price</th>
         </tr>
        <?php
        $productUnit='';
        $stockCnt = $product_stock_qty = $totalQnty = $totalAmount = 0;
        $getStock=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 AND `unit_id`='$dashboard_unit' ORDER BY `sl`");
        while ($rowStock=mysqli_fetch_array($getStock)){
          $product_unq_id=$rowStock['unq_id'];
          $product_name=$rowStock['product_name'];
          $hsn_code=$rowStock['hsn_code'];
          $unit_id=$rowStock['unit_id'];
          $sale_rate=$rowStock['sale_rate'];
          $getStock1=mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stock_qty` FROM `stock_master` WHERE `typ`=40 AND `product_id`='$product_unq_id' AND `stk_dt`='$currentDate' ORDER BY `sl`");
          while ($rowStock1=mysqli_fetch_array($getStock1)){
            $product_stock_qty = $rowStock1['stock_qty'];
          }
          $saleAmount = $sale_rate * $product_stock_qty;
          $totalQnty = $totalQnty + $product_stock_qty;
          $totalAmount = $totalAmount + $saleAmount;
          $productUnit = get_single_value('unit_tbl','unq_id',$unit_id,'unit_short_name','');
          if($product_stock_qty!=0){
            $stockCnt++;
            ?>
            <tr>
              <td class="text-center"><?php echo $stockCnt; ?></td>
              <td class="text-left"><?php echo "$product_name ($hsn_code)"; ?></td>
              <td class="text-center"><?php echo $product_stock_qty.' '.$productUnit; ?></td>
              <td class="text-right"><?php echo number_format($sale_rate,2); ?></td>
              <td class="text-right"><?php echo number_format($saleAmount,2); ?></td>
            </tr>
            <?php
          }
        }
        ?>
        <tr>
          <td colspan="2"></td>
          <td class="text-center"><b><?php echo $totalQnty.' '.$productUnit; ?></b></td>
          <td class="text-right"></td>
          <td class="text-right"><b><?php echo number_format($totalAmount,2); ?></b></td>
        </tr>
        </table>
      </div>
    </div>
  </div>
  <?php
}
?>