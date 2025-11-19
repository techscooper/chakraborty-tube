<?php
include '../config.php';
$refund_no = $_REQUEST['refund_no'];
$customer_id = $invoice_date = $billingEby = "";
$getInvoiceName=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `refund_no`='$refund_no'");
while($rowInvoiceDtls=mysqli_fetch_array($getInvoiceName)){
  $customer_id = $rowInvoiceDtls['customer_id'];
  $bill_date = $rowInvoiceDtls['bill_date'];
}
$invoice_no=get_single_value("account_master","refund_no",$refund_no,"invoice_no","",$conn);
$customerName=get_single_value("customer_tbl","unq_id",$customer_id,"customer_nm","",$conn);
$customerAddress=get_single_value("customer_tbl","unq_id",$customer_id,"address_1","",$conn);
$customerMobile=get_single_value("customer_tbl","unq_id",$customer_id,"mobile_no","",$conn);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Refund</title>
</head>
<body>
	<table border="0" style="width:1050px;">
	<tr>
	<td>
		<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
			<tr>
				<td style="text-align: center; width:80%; padding:0px 0 0px 0; border-bottom:1px solid #000;">
					<b style="font-family:Algerian; font-size:50px;">SAYAN SHAREE PALACE</b><br />
					<font style="font-family:Kozuka Mincho Pro B; font-size:18px;">
						33, Rabindra Sarani, Near Brojobala School , Ranaghat-741201, Nadia<br>
						Mobile No. – 9064740311 / E-Mail :
					</font>
				</td>
			</tr>
			<tr>
				<td style="text-align: center; width:80%; padding:0px 0 0px 0; border-bottom:1px solid #000;">
					<b style="font-size:30px;">REFUND SLIP</b>
				</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
		<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
			<tr>
				<td style="width:60%; border-bottom:1px solid #000; border-right:1px solid #000;">
					<b><?php echo "$customerName ($customerMobile)"; ?></b><br>
					<?php echo $customerAddress; ?>
				</td>
				<td style="width:40%; border-bottom:1px solid #000;">
					REFUND NO.: <b><?php echo $refund_no; ?></b><br>
					REFUND DATE: <b><?php echo date('d-M-Y',strtotime($bill_date)); ?></b>
				</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
    <?php
    $net_amount = $onlinePayment = $chequePayment = $cashPayment = 0;
    $getAccount=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`='-1' AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $refund_amount = $rowAccount['net_amount'];
		}
    $getAccount=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `onlinePayment` FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=2 AND `pay_method`=1 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $cashPayment = $rowAccount['onlinePayment'];
		}
    $getAccount=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `onlinePayment` FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=2 AND `pay_method`=2 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $chequePayment = $rowAccount['onlinePayment'];
		}
    $getAccount=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `onlinePayment` FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=2 AND `pay_method`=3 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $onlinePayment = $rowAccount['onlinePayment'];
		}
    ?>
		<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
			<tr>
				<td colspan="2">
					<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
						<?php if($onlinePayment>0 OR $chequePayment>0){ ?>
						<tr><td>Bank Payment <b>: <?php echo number_format($onlinePayment+$chequePayment,2); ?></b></td></tr>
            <?php
            } if($cashPayment>0){ ?>
            <tr><td>Cash Payment <b>: <?php echo number_format($cashPayment,2); ?></b></td></tr>
            <?php
            }
            ?>
            <tr><td>Refund Amount <b>: <?php echo number_format($refund_amount,2); ?></b></td></tr>
					</table>
				</td>
			</tr>
      <tr><td colspan="2">In word: <b><?php if($net_amount!="" OR $net_amount!=0){ echo rupee_word(round($refund_amount,0));} ?></b></td></tr>
			<tr>
        <td style="width:70%;"></td>
        <td style="text-align:center;"><br><b>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _<b><br>
          Signature<br>
          <?php echo $name_u_admin; ?> (<?php echo get_single_value("user_level","unq_id",$lvl_u_admin,"user_level_nm","",$conn); ?>)
        </td>
      </tr>
		</table>
	</td>
	</tr>
</table>
<script type="text/javascript">
  print();
</script>
</body>
</html>
