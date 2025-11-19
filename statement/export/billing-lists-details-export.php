<?php
set_time_limit(0);
include("../../config.php");
$fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
$tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
$filename = "Billing_export_$currentDateTime.csv";
$fp = fopen('php://output', 'w');
$header = array('Sl No','Date','Invoice No','Customer Name','Customer Mobile','Customer GST No','Product Name','HSN Code','Qty','Unit','Rate','Taxable Amount','GST (%)','GST Value','Net Price');
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$cnt = 0;

if($fdt!="" && $tdt!=""){ $ftdt=" AND `billing`.`invoice_date` BETWEEN '$fdt' AND '$tdt'"; }else{ $ftdt=""; }
  $stockCnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = 0;
  $getStock=mysqli_query($conn,"SELECT `billing`.`invoice_date`, `billing_product_item`.`member_id`, `billing_product_item`.`invoice_no`, `billing_product_item`.`product_id`, `billing_product_item`.`quantity`, `billing_product_item`.`product_rate`, `billing_product_item`.`taxable_amount`, `billing_product_item`.`gst_percentage`, `billing_product_item`.`gst_value`, `billing_product_item`.`net_amount`, `customer_tbl`.`gst_no` FROM `billing`, `billing_product_item`, `customer_tbl` WHERE `billing`.`invoice_no`=`billing_product_item`.`invoice_no` AND `customer_tbl`.`unq_id`=`billing`.`customer_id` AND `customer_tbl`.`unq_id`=`billing_product_item`.`member_id` AND `billing`.`stat`=1 $ftdt ORDER BY `billing_product_item`.`invoice_no` ASC");
  while ($rowStock=mysqli_fetch_array($getStock)){
    $stockCnt++;
    $member_id=$rowStock['member_id'];
    $invoice_date=$rowStock['invoice_date'];
    $invoice_no=$rowStock['invoice_no'];
    $product_id=$rowStock['product_id'];
    $quantity=$rowStock['quantity'];
    $product_rate=$rowStock['product_rate'];
    $taxable_amount=$rowStock['taxable_amount'];
    $gst_percentage=$rowStock['gst_percentage'];
    $gst_value=$rowStock['gst_value'];
    $net_amount=$rowStock['net_amount'];
    $gst_no=$rowStock['gst_no'];

    $customerName=get_single_value("customer_tbl","unq_id",$member_id,"customer_nm","");
    $customerMobile=get_single_value("customer_tbl","unq_id",$member_id,"mobile_no","");
    $productName=get_single_value("inventory_tbl","unq_id",$product_id,"product_name","");
    $hsnCode=get_single_value("inventory_tbl","unq_id",$product_id,"hsn_code","");
    $productUnitID=get_single_value("inventory_tbl","unq_id",$product_id,"unit_id","");
    $productUnit=get_single_value("unit_tbl","unq_id",$productUnitID,"unit_short_name","");
    $notesDataArray = array($stockCnt,$invoice_date,$invoice_no,$customerName,$customerMobile,$gst_no,$productName,$hsnCode,$quantity,$productUnit,$product_rate,$taxable_amount,$gst_percentage,$gst_value,round($net_amount,2));
    fputcsv($fp, $notesDataArray);
  }
exit;
?>