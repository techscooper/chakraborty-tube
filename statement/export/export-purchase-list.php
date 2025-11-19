<?php
set_time_limit(0);
include("../../config.php");
$fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
$tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
$filename = "Purchase_export_$currentDateTime.csv";
$fp = fopen('php://output', 'w');
$header = array('Sl No','Date','Invoice No','Supplier Name','Supplier Mobile','Supplier GST No','Product Name','HSN Code','Qty','Unit','Rate','Taxable Amount','GST (%)','GST Value','Net Price');
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$cnt = 0;
if($fdt!="" && $tdt!=""){ $ftdt=" AND `purchase`.`purchase_date` BETWEEN '$fdt' AND '$tdt'"; }else{ $ftdt=""; }
  $stockCnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = 0;
  $getStock=mysqli_query($conn,"SELECT `purchase`.`purchase_date`, `purchase_product_item`.`supplier_id`, `purchase_product_item`.`purchase_no`, `purchase_product_item`.`product_id`, `purchase_product_item`.`quantity`, `purchase_product_item`.`product_rate`, `purchase_product_item`.`taxable_amount`, `purchase_product_item`.`gst_percentage`, `purchase_product_item`.`gst_value`, `purchase_product_item`.`net_amount`, `supplier_tbl`.`gst_no` FROM `purchase`, `purchase_product_item`, `supplier_tbl` WHERE `purchase`.`purchase_no`=`purchase_product_item`.`purchase_no` AND `supplier_tbl`.`unq_id`=`purchase`.`supplier_id` AND `supplier_tbl`.`unq_id`=`purchase_product_item`.`supplier_id` AND `purchase`.`stat`=1 $ftdt ORDER BY `purchase_product_item`.`sl` ASC");
  while ($rowStock=mysqli_fetch_array($getStock)){
    $stockCnt++;
    $supplier_id=$rowStock['supplier_id'];
    $purchase_date=$rowStock['purchase_date'];
    $purchase_no=$rowStock['purchase_no'];
    $product_id=$rowStock['product_id'];
    $quantity=$rowStock['quantity'];
    $product_rate=$rowStock['product_rate'];
    $taxable_amount=$rowStock['taxable_amount'];
    $gst_percentage=$rowStock['gst_percentage'];
    $gst_value=$rowStock['gst_value'];
    $net_amount=$rowStock['net_amount'];
    $gst_no=$rowStock['gst_no'];
    $supplierName=get_single_value("supplier_tbl","unq_id",$supplier_id,"supplier_nm","");
    $supplierMobile=get_single_value("supplier_tbl","unq_id",$supplier_id,"mobile_no","");
    $productName=get_single_value("inventory_tbl","unq_id",$product_id,"product_name","");
    $hsnCode=get_single_value("inventory_tbl","unq_id",$product_id,"hsn_code","");
    $productUnitID=get_single_value("inventory_tbl","unq_id",$product_id,"unit_id","");
    $productUnit=get_single_value("unit_tbl","unq_id",$productUnitID,"unit_short_name","");
    $notesDataArray = array($stockCnt,$purchase_date,$purchase_no,$supplierName,$supplierMobile,$gst_no,$productName,$hsnCode,$quantity,$productUnit,$product_rate,$taxable_amount,$gst_percentage,$gst_value,round($net_amount,2));
    fputcsv($fp, $notesDataArray);
  }
exit;
?>