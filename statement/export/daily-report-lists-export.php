<?php
set_time_limit(0);
include("../../config.php");
$opening_date_frm=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['opening_date_frm']));
$opening_date_to=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['opening_date_to']));
$filename = "Daily_report_export_$currentDateTime.csv";
$fp = fopen('php://output', 'w');
$header = array('Sl No.','Product','Opening Stock','Purchase Stock','Sale Stock','Closing stock');
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$cnt = 0;
$queryBuild = "SELECT `unq_id`, `product_name`, `product_code`, `product_unit` FROM `inventory_tbl` WHERE `stat`='1'";
$result = mysqli_query($conn,$queryBuild);
while($row = mysqli_fetch_row($result)) {
  $productUnqId = $row[0];
  $product_name = $row[1];
  $product_code = $row[2];
  $product_unit = $row[3];
  $productUnit = get_single_value("unit_tbl","unq_id",$product_unit,"unit_short_name","");

  $tStockOpenBefore = $tStockInBefore = $tStockOutBefore = $avStkBefore = $tStockOpenPurchase = $tStockInPurchase = $avStkPurchase = $tStockInSale = $avStkClosing = 0;
  //Opening Stock before from date | start
  $getStockOpen1 = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockopen` FROM `stock_master` WHERE `stat`=1 AND `unq_id`=10 AND `typ`=10 AND `product_id`='$productUnqId' AND `stk_dt`<'$opening_date_frm'");
  while($rowStockOpen1 = mysqli_fetch_array($getStockOpen1)){
    $tStockOpenBefore = $rowStockOpen1['stockopen'];
  }
  $getStockIn1 = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockin` FROM `stock_master` WHERE `stat`=1 AND `unq_id`!=10 AND `typ`=10 AND `product_id`='$productUnqId' AND `stk_dt`<'$opening_date_frm'");
  while($rowStockIn1 = mysqli_fetch_array($getStockIn1)){
    $tStockInBefore = $rowStockIn1['stockin'];
  }
  $getStockOut1 = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockout` FROM `stock_master` WHERE `stat`=1 AND `unq_id`!=20 AND `typ`=20 AND `product_id`='$productUnqId' AND `stk_dt`<'$opening_date_frm'");
  while($rowStockOut1 = mysqli_fetch_array($getStockOut1)){
    $tStockOutBefore = $rowStockOut1['stockout'];
  }
  $avStkBefore = $tStockOpenBefore + $tStockInBefore - $tStockOutBefore;
  //Opening Stock before from date | end

  //Opening & Purchase Stock from date to date | start
  if($opening_date_frm!="" and $opening_date_to!=""){$ftdt=" AND `stk_dt` BETWEEN '$opening_date_frm' AND '$opening_date_to'";}else{$ftdt="";}
  $getStockOpen2 = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockopen` FROM `stock_master` WHERE `stat`=1 AND `unq_id`=10 AND `typ`=10 AND `product_id`='$productUnqId' $ftdt");
  while($rowStockOpen2 = mysqli_fetch_array($getStockOpen2)){
    $tStockOpenPurchase = $rowStockOpen2['stockopen'];
  }
  $getStockIn2 = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockin` FROM `stock_master` WHERE `stat`=1 AND `unq_id`!=10 AND `typ`=10 AND `product_id`='$productUnqId' $ftdt");
  while($rowStockIn2 = mysqli_fetch_array($getStockIn2)){
    $tStockInPurchase = $rowStockIn2['stockin'];
  }
  $avStkPurchase = $tStockOpenPurchase + $tStockInPurchase;
  //Opening & Purchase Stock from date to date | End

  //Closing Stock to date | Start
  $getStockIn2 = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockout` FROM `stock_master` WHERE `stat`=1 AND `typ`=20 AND `product_id`='$productUnqId' AND `stk_dt`='$opening_date_to'");
  while($rowStockIn2 = mysqli_fetch_array($getStockIn2)){
    $tStockInSale = $rowStockIn2['stockout'];
  }
  if($tStockInSale==""){$tStockInSale=0;}
  $avStkClosing = $avStkBefore + $avStkPurchase - $tStockInSale;
  //Closing Stock to date | End
  if($avStkBefore>0 OR $avStkPurchase>0 OR $tStockInSale>0 OR $avStkClosing>0){
    $cnt++;
    $notesDataArray = array($cnt,"$product_name ($product_code)","$avStkBefore $productUnit","$avStkPurchase $productUnit","$tStockInSale $productUnit","$avStkClosing $productUnit");
	  fputcsv($fp, $notesDataArray);
  }
}
exit;
?>