<?php
set_time_limit(0);
include("../../config.php");
$customer_id=mysqli_real_escape_string($conn,$_REQUEST['customer_id']);
$fdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['fdt']));
$tdt=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['tdt']));
$filename = "Billing_export_$currentDateTime.csv";
$fp = fopen('php://output', 'w');
$header = array('Sl No','Date','Invoice No','Customer','Taxable Amount','GST Value','Net Price');
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$cnt = 0;

if($customer_id!=""){ $customer_id1="AND `customer_id`='$customer_id'"; }else{ $customer_id1=""; }
if($fdt!="" && $tdt!=""){ $ftdt=" AND `invoice_date` BETWEEN '$fdt' AND '$tdt'"; }else{ $ftdt=""; }

$queryBuild = "SELECT `customer_id`, `invoice_no`, `invoice_date`, `taxable_amount`, `gst_value`, `net_amount` FROM `billing` WHERE `stat`=1 $customer_id1 $ftdt ORDER BY `invoice_date` ASC";
$result = mysqli_query($conn,$queryBuild);
while($row = mysqli_fetch_row($result)) {
  $cnt++;
  $customer_id=$row[0];
  $invoice_no=$row[1];
  $invoice_date=$row[2];
  $taxable_amount=$row[3];
  $gst_value=$row[3];
  $net_amount=$row[3];
  $customerName=get_single_value("customer_tbl","unq_id",$customer_id,"customer_nm","");
  $notesDataArray = array($cnt,"$invoice_date","$invoice_no","$customerName","$taxable_amount","$gst_value","$net_amount");
  fputcsv($fp, $notesDataArray);
}
exit;
?>