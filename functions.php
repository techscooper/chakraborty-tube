<?php
function get_single_value($tblname,$tblunq,$srcval,$rtnval,$morecndi){
  global $conn;
  $return_value = "";
  $getData=mysqli_query($conn,"SELECT $rtnval FROM $tblname WHERE $tblunq='$srcval' $morecndi");
  while($rowData=mysqli_fetch_array($getData)){
    $return_value=$rowData[$rtnval];
  }
  return $return_value;
}

function getUnqID($tableName){
  global $conn, $currentDate;
  aa1:
  $unq_id_unique=date("Ymd").mt_rand(1000,9999);
  $check_uid=mysqli_query($conn,"SELECT * FROM `$tableName` WHERE `unq_id`='$unq_id_unique' AND YEAR(`edt`) = YEAR('$currentDate') AND MONTH(`edt`) = MONTH('$currentDate') AND DAY(`edt`) = DAY('$currentDate')");
  if ($row_check_uid=mysqli_fetch_array($check_uid)){
    goto aa1;
  }
  else{
    return $unq_id_unique;
  }
}

/*
function getInvoiceNo(){
  global $conn;
  $cy1 = date('y');
  $cy2 = $cy1 + 1;
  $pre = get_single_value('billing_serise_tbl','sl','1','invoice_series','');
  $id=$pre.'/'.$cy1.'-'.$cy2.'/';
  $invoice_no = '00000000000000';
  $get=mysqli_query($conn,"SELECT * FROM `billing` WHERE `invoice_no` LIKE '$id%' ORDER BY `sl` DESC LIMIT 0,1");
  while($row=mysqli_fetch_array($get)){
    $invoice_no=$row['invoice_no'];
  }
  $count=1;
  $vid=substr($invoice_no,11,4);
  while($count>0){
    $vid=$vid+1;
    $invoice_no=$id.$vid;
    $query=mysqli_query($conn,"SELECT * FROM `billing` WHERE `invoice_no`='$invoice_no'");
    $count=mysqli_num_rows($query);
  }
  return $invoice_no;
}
*/

function getInvoiceNo() {
  global $conn;
  $currentMonth = date('n');
  $currentYear = date('Y');
  $nextYear = $currentYear + 1;
  $previousYear = $currentYear - 1;
  if ($currentMonth >= 4) {
    $cy1 = date('y', strtotime($currentYear . '-04-01'));
    $cy2 = date('y', strtotime($nextYear . '-03-31'));
  }
  else {
    $cy1 = date('y', strtotime($previousYear . '-04-01'));
    $cy2 = date('y', strtotime($currentYear . '-03-31'));
  }
  $pre = get_single_value('billing_serise_tbl', 'sl', '1', 'invoice_series', '');
  $id = $pre . '/' . $cy1 . '-' . $cy2 . '/';
  $invoice_no = $id . '0000';
  $get = mysqli_query($conn, "SELECT * FROM `billing` WHERE `invoice_no` LIKE '$id%' ORDER BY `sl` DESC LIMIT 1");
  $lastNumber = 0;
  if ($row = mysqli_fetch_array($get)) {
    $lastInvoiceNo = $row['invoice_no'];
    $lastNumber = (int)substr($lastInvoiceNo, strrpos($lastInvoiceNo, '/') + 1);
  }
  $newNumber = $lastNumber + 1;
  $invoice_no = $id . $newNumber;
  return $invoice_no;
}


function getReturnInvoiceNo(){
  global $conn;
  $cy1 = date('y');
  $cy2 = $cy1 + 1;
  $pre = get_single_value('billing_serise_tbl','sl','1','refund_series','');
  $id=$pre.'/'.$cy1.'-'.$cy2.'/';
  $return_no = '00000000000000';
  $get=mysqli_query($conn,"SELECT * FROM `billing_return` WHERE `return_no` LIKE '$id%' ORDER BY `sl` DESC LIMIT 0,1");
  while($row=mysqli_fetch_array($get)){
    $return_no=$row['return_no'];
  }

  $count=1;
  $vid=substr($return_no,11,4);
  while($count>0){
    $vid=$vid+1;
    $return_no=$id.str_pad($vid, 4, '0', STR_PAD_LEFT);
    $query=mysqli_query($conn,"SELECT * FROM `billing_return` WHERE `return_no`='$return_no'");
    $count=mysqli_num_rows($query);
  }
  return $return_no;
}

function generateCaptcha($length) {
  $characters = '0123456789';
  $randomString = '';
  for($i = 0; $i < $length; $i++){
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $randomString;
}

function userIDGet($apiToken,$sessionID){
  global $conn;
  $apiToken = mysqli_real_escape_string($conn,$apiToken);
  $getUserID = mysqli_query($conn,"SELECT * FROM `login_api_keys` WHERE `api_key`='$apiToken' AND `session_id`='$sessionID' AND `stat`=1");
  if ($rowUserID = mysqli_fetch_array($getUserID)) {
    $useridRequest = $rowUserID['user_id'];
    return $useridRequest;
  }
  else {
    return false;
  }
}

function getRemainingTime($dateTime){
  $currentTime=date('Y-m-d H:i:s');
  $deactiveTime=date('Y-m-d H:i:s', strtotime($dateTime. ' + 4 Hours'));
	$start_date = new DateTime($currentTime);
	$end_date = new DateTime($deactiveTime);
	$since_start = $start_date->diff($end_date);
	$hours = $since_start->h;
	$minutes = $since_start->i;
	$seconds = $since_start->s;
	if($hours==0 AND $minutes==0){ $remainingTime = "$seconds Seconds"; }
	else if($hours==0){ $remainingTime = "$minutes Minutes $seconds Seconds"; }
	else{ $remainingTime = "$hours Hours $minutes Minutes $seconds Seconds"; }
	return $remainingTime;
}

function discountPrice($price, $disper){
  $disAmnt = ($disper * $price) / 100;
  return round($disAmnt,2);
}

function rupee_word($value){
   $number = $value;
   $no = round($number,2);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " .
          $words[$point = $point % 10] : '';
  $result_value_w = $result . "Rupees Only";
  return $result_value_w;
}

function ledgerBalance($ledger_id){
  global $conn;
  $balanceIN = $balanceOUT = 0;
  $getIN=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `net_amount` FROM `account_master` WHERE `stat`=1 AND `ledger_id`='$ledger_id' AND `dr`=1 AND `cr`=0 AND ((`type`=0 AND `level`=2) OR (`type`=2 AND `level` IN(2,4)))");
  while ($rowIN = mysqli_fetch_array($getIN)) {
    $balanceIN=$rowIN['net_amount'];
  }
  $getOUT=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `net_amount` FROM `account_master` WHERE `stat`=1 AND `ledger_id`='$ledger_id' AND `dr`=0 AND `cr`=1 AND ((`type`=1 AND `level`=2) OR (`type`=3 AND `level`=2))");
  while ($rowOUT = mysqli_fetch_array($getOUT)) {
    $balanceOUT=$rowOUT['net_amount'];
  }
  return $balanceIN - $balanceOUT;
}

function getProductWiseStock($productUnqID,$stockDate){
  global $conn;
  $stockIn = $stockOut = $stockCurrent = 0;
  $getStockIn = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockin` FROM `stock_master` WHERE `stat`=1 AND `typ` IN(10,20,50) AND `product_id`='$productUnqID' AND `stk_dt`<='$stockDate'");
  while($rowStockIn = mysqli_fetch_array($getStockIn)){
    $stockIn = $rowStockIn['stockin'];
  }
  $getStockOut = mysqli_query($conn,"SELECT SUM(`stock_qty`) AS `stockout` FROM `stock_master` WHERE `stat`=1 AND `typ` IN(30,40) AND `product_id`='$productUnqID' AND `stk_dt`<='$stockDate'");
  while($rowStockOut = mysqli_fetch_array($getStockOut)){
    $stockOut = $rowStockOut['stockout'];
  }
  $stockCurrent=$stockIn-$stockOut;
  return $stockCurrent;
}
?>