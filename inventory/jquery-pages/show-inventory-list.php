<?php
include '../../config.php';
if($ckadmin==1){
  $category_id=mysqli_real_escape_string($conn,$_REQUEST['category_id']);
  $allsrc=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['allsrc']));
  $af="%".$allsrc."%";
  if($allsrc!=''){ $a2=" AND (`product_name` LIKE '$af' OR `product_code` LIKE '$af')"; }else{ $a2=''; }
  if($category_id!=""){ $categoryID="AND `category_id`='$category_id'"; }else{ $categoryID=""; }
  $getInventory=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 $categoryID $a2 ORDER BY `product_name`");
  if(mysqli_num_rows($getInventory)>0){
  ?>
  <div class="dt-responsive table-responsive">
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">Action</th>
          <th class="text-center">Product Details</th>
          <th class="text-center">Sales Details</th>
          <th class="text-center">Description</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $cntInventory=0;
        while($rowInventory=mysqli_fetch_array($getInventory)){
          $cntInventory++;
          $inventoryUnqID=$rowInventory['unq_id'];
          $category_id=$rowInventory['category_id'];
          $product_name=$rowInventory['product_name'];
          $product_descp=$rowInventory['product_descp'];
          $unit_id=$rowInventory['unit_id'];
          $igst=$rowInventory['igst'];
          $purchase_rate=$rowInventory['purchase_rate'];
          $sale_rate=$rowInventory['sale_rate'];
          $categoryName=get_single_value('inventory_category','unq_id',$category_id,'category_name','');
          $productUnit=get_single_value('unit_tbl','unq_id',$unit_id,'unit_short_name','');
          ?>
          <tr>
            <td class="text-center"><?php echo $cntInventory; ?></td>
            <td class="text-center">
              <a href="javascript:void(0);" onclick="inventoryUpdate('<?php echo base64_encode($inventoryUnqID);?>')">
                <i class="fa fa-edit fa-lg" title="Click to Update"></i>
              </a>
            </td>
            <td>
              Product Name : <b><?php echo $product_name; ?></b><br>
              Category : <b><?php echo $categoryName; ?></b><br>
              Unit : <b><?php echo $productUnit; ?></b>
            </td>
            <td>
              Purchase Rate : <b><?php echo number_format($purchase_rate,2);?></b><br>
              Sales Rate : <b><?php echo number_format($sale_rate,2);?></b><br>
              IGST : <b><?php echo $igst.' %'; ?></b>
            </td>
            <td><?php echo $product_descp;?></td>
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
    ?><div><?php echo "No Data Available"; ?></div><?php
  }
}
?>