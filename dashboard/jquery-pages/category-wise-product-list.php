<?php
include '../../config.php';
$catuid=mysqli_real_escape_string($conn,$_REQUEST['catuid']);
if($catuid!=""){
  ?>
  <div class="row">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-sm table-hover mb-0 c_table">
          <tr>
           <th class="text-center" style="width:10%;">#</th>
           <th class="text-center" style="width:60%;">Product</th>
           <th class="text-center" style="width:30%;">Available</th>
         </tr>
         <?php
         $productUnit = '';
          $cntCat = $currentStock = $currentStockTotal = 0;
          $getCat=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 AND `category_id`='$catuid' ORDER BY `product_name`");
          while ($rowCat=mysqli_fetch_array($getCat)){
            $productUnqID=$rowCat['unq_id'];
            $product_name=$rowCat['product_name'];
            $hsn_code=$rowCat['hsn_code'];
            $unit_id=$rowCat['unit_id'];
            $productUnit=get_single_value('unit_tbl','unq_id',$unit_id,'unit_short_name','');
            $currentStock=getProductWiseStock($productUnqID,$currentDate);
            $currentStockTotal+=$currentStock;
            if($currentStock!=0){
              $cntCat++;
              ?>
              <tr>
                <td class="text-center"><?php echo $cntCat; ?></td>
                <td><?php echo "$product_name $hsn_code"; ?></td>
                <td class="text-center"><?php echo "$currentStock $productUnit"; ?></td>
              </tr>
              <?php
            }
          }
          ?>
          <tr>
            <td colspan="2"></td>
            <td class="text-center"><b><?php echo "$currentStockTotal $productUnit"; ?></b></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <?php
}
?>