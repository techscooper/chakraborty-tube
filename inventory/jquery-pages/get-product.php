<?php
include '../../config.php';
$cat_id=mysqli_real_escape_string($conn,$_REQUEST['cat_id']);
?>
<select class="form-control form-control-sm" name="product_id" id="product_id">
  <option value="">-- All --</option>
  <?php
  $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 AND `category_id`='$cat_id'");
  while($rowProduct=mysqli_fetch_array($getProduct)){
    $productID=$rowProduct['product_code'];
    $productName=$rowProduct['product_name'];
    ?><option value="<?php echo $productID; ?>"><?php echo $productName; ?></option><?php
  }
  ?>
</select>