<?php
include '../../config.php';
if($ckadmin==1){
  $barcode=mysqli_real_escape_string($conn,$_REQUEST['barcode']);
  $product_id=get_single_value("inventory_tbl","product_code",$barcode,"unq_id","");
  $amount=get_single_value("inventory_tbl","product_code",$barcode,"purchase_rate","");
  if($product_id!=""){
    $getProductChk=mysqli_query($conn,"SELECT * FROM `purchase_product_item_temp` WHERE `product_id`='$product_id' AND `supplier_id`='$idadmin'");
    $rcntProductChk=mysqli_num_rows($getProductChk);
    if($rcntProductChk==0){
      mysqli_query($conn,"INSERT INTO `purchase_product_item_temp`(`supplier_id`, `product_id`, `quantity`, `amount`, `edt`, `eby`) VALUES ('$idadmin', '$product_id', '1', '$amount', '$currentDateTime', '$idadmin')");
    }
    else{
      $tempSl=get_single_value("purchase_product_item_temp","product_id",$product_id,"sl","AND `supplier_id`='$idadmin'");
      $quantity=get_single_value("purchase_product_item_temp","product_id",$product_id,"quantity","AND `supplier_id`='$idadmin'");
      $quantity++;
      mysqli_query($conn,"UPDATE `purchase_product_item_temp` SET `quantity`='$quantity' WHERE `sl`='$tempSl'");
    }
  }
  else {
    ?>
    <script type="text/javascript">
      toast('warning','Warning!','','Please enter valid Barcode');
    </script>
    <?php
  }
  ?>
  <script type="text/javascript">
  getTempProduct();
  </script>
  <?php
}
?>