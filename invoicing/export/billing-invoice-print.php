<?php
include '../../config.php';
if($ckadmin==1){
	$invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
	$customer_id = $invoice_date = $taxable_amount = $gst_value = $net_amount = $roundAmount = '';
	$getBilling=mysqli_query($conn,"SELECT * FROM `billing` WHERE `invoice_no`='$invoice_no'");
	while($rowBilling=mysqli_fetch_array($getBilling)){
		$customer_id=$rowBilling['customer_id'];
		$invoice_date=$rowBilling['invoice_date'];
		$taxable_amount=$rowBilling['taxable_amount'];
		$gst_value=$rowBilling['gst_value'];
		$totalAmount=$rowBilling['total_amount'];
		$roundAmount=$rowBilling['round_amount'];
		$net_amount=$rowBilling['net_amount'];
	}
	$customerName = $email_id = $mobile_no = $gst_no = $customer_state_id = $address_1 = $address_2 = $zip_code = '';
	$getCustomer=mysqli_query($conn,"SELECT * FROM `customer_tbl` WHERE `unq_id`='$customer_id'");
	while($rowCustomer=mysqli_fetch_array($getCustomer)) {
		$customerName=$rowCustomer['customer_nm'];
		$email_id=$rowCustomer['email_id'];
		$mobile_no=$rowCustomer['mobile_no'];
		$gst_no=$rowCustomer['gst_no'];
		$pan_no=$rowCustomer['pan_no'];
		$customer_state_id=$rowCustomer['customer_state_id'];
		$address_1=$rowCustomer['address_1'];
		$address_2=$rowCustomer['address_2'];
		$zip_code=$rowCustomer['zip_code'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Invoice</title>
</head>
<body>
	<table border="0" style="width:1050px;">
	<tr>
	<td>
		<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
			<tr>
				<td style="text-align: center; width:80%; padding:0px 0 0px 0; border-bottom:1px solid #000;">
					<b style="font-family:Algerian; font-size:40px;">Chakraborty Tubewell</b><br />
					<font style="font-family:Kozuka Mincho Pro B; font-size:18px;">
						Chotobazar, Ranaghat, Nadia<br>
						Mobile No. – 9333765502, GST No: 19ABZPC1914B1ZS
					</font>
				</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
		<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
			<tr>
				<td style="width:70%; border-bottom:1px solid #000; border-right:1px solid #000;">
					<b><?php echo $customerName; ?></b><br>
          <?php echo "M-".$mobile_no; ?><br>
					<?php echo $address_1; ?><br>
					<?php if($gst_no!=''){ echo "GST No: $gst_no<br>"; } ?>
					<?php if($pan_no!=''){ echo "PAN No: $pan_no"; } ?>
				</td>
				<td style="width:30%; border-bottom:1px solid #000;">
					INVOICE NO.: <b><?php echo $invoice_no; ?></b><br>
					INVOICE DATE: <b><?php echo date('d-M-Y',strtotime($invoice_date)); ?></b><br>
					Refer By:
				</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
		<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
		<tr>
			<th style="width:2%; border: 1px solid black;">Sl</th>
			<th style="width:28%; border: 1px solid black;">Product Name</th>
			<th style="width:10%; border: 1px solid black;">HSN Code</th>
			<th style="width:10%; border: 1px solid black;">Qty</th>
			<th style="width:10%; border: 1px solid black;">Rate</th>
			<th style="width:10%; border: 1px solid black;">Taxable</th>
			<th style="width:10%; border: 1px solid black;">GST(%)</th>
			<th style="width:10%; border: 1px solid black;">GST Value</th>
			<th style="width:10%; border: 1px solid black;">Net Amount</th>
		</tr>
		<?php
		$cnt = $taxable_amountTotal = $gst_valueTotal = $net_amountTotal = $tHeight = 0;
		$get_invoice_name=mysqli_query($conn,"SELECT * FROM `billing_product_item` WHERE `invoice_no`='$invoice_no'");
		while($row_invoice_dtls=mysqli_fetch_array($get_invoice_name)){
		  $cnt++;
		  $productTotal = 0;
		  $product_id=$row_invoice_dtls['product_id'];
		  $quantity=$row_invoice_dtls['quantity'];
		  $product_rate=$row_invoice_dtls['product_rate'];
			$taxable_amount=$row_invoice_dtls['taxable_amount'];
			$gst_percentage=$row_invoice_dtls['gst_percentage'];
			$gst_value=$row_invoice_dtls['gst_value'];
			$net_amount=$row_invoice_dtls['net_amount'];
		  $productName=get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
		  $product_unit=get_single_value('inventory_tbl','unq_id',$product_id,'unit_id','');
			$hsn_code=get_single_value('inventory_tbl','unq_id',$product_id,'hsn_code','');
		  $productUnit=get_single_value("unit_tbl","sl",$product_unit,"unit_short_name","");

			$taxable_amountTotal+=$taxable_amount;
			$gst_valueTotal+=$gst_value;
			$net_amountTotal+=$net_amount;

		  $tHeight = $tHeight - 22;
		  ?>
		  <tr style="height:22px;">
				<td style="text-align: center; border-right: 1px solid black;"><?php echo $cnt; ?></td>
				<td style="text-align: left; border-right: 1px solid black;"><?php echo $productName; ?></td>
				<td style="text-align: left; border-right: 1px solid black;"><?php echo $hsn_code; ?></td>
				<td style="text-align: center; border-right: 1px solid black;"><?php echo $quantity.' '.$productUnit; ?></td>
				<td style="text-align: right; border-right: 1px solid black;"><?php echo number_format($product_rate,2).'&nbsp;'; ?></td>
				<td style="text-align: right; border-right: 1px solid black;"><?php echo number_format($taxable_amount,2).'&nbsp;'; ?></td>
				<td style="text-align: right; border-right: 1px solid black;"><?php echo number_format($gst_percentage,2).'&nbsp;'; ?></td>
				<td style="text-align: right; border-right: 1px solid black;"><?php echo number_format($gst_value,2).'&nbsp;'; ?></td>
				<td style="text-align: right; border-right: 1px solid black;"><?php echo number_format($net_amount,2).'&nbsp;'; ?></td>
		  </tr>
		  <?php
		}
		?>
		<tr style="height:<?php echo 180-$tHeight; ?>px;">
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
    <?php
    $shipping_charge = $taxable_value = $discount_value = $net_amount = $onlinePayment = $chequePayment = $cashPayment = 0;
    $getAccount=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=1 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $net_amount = $rowAccount['net_amount'];
		}
    $getAccount=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=4 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $shipping_charge = $rowAccount['net_amount'];
		}
    $getAccount=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=1 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $taxable_value = $rowAccount['taxable_value'];
		}
    $getAccount=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `type`=2 AND `level`=3 AND `invoice_no`='$invoice_no'");
		while($rowAccount=mysqli_fetch_array($getAccount)){
		  $discount_value = $rowAccount['net_amount'];
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
				<td style="width:75%;" rowspan="2">
					In word: <b><?php if($net_amount!="" OR $net_amount!=0){ echo rupee_word(round($net_amount,0));} ?></b><hr>
					Terms & Condition : <br><br><br><br><br><br><br><br><br><br>
				</td>
				<td style="width:25%;">
					<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
						<tr>
							<td>Total Amount</td>
							<td style="text-align:right;"><b><?php echo number_format($taxable_amountTotal,2); ?></b></td>
						</tr>
            <tr>
							<td>Shipping Charge</td>
							<td style="text-align:right;"><b> <?php echo number_format($shipping_charge,2); ?></b></td>
						</tr>
						<tr>
							<td>Discount</td>
							<td style="text-align:right;"><b> - <?php echo number_format($discount_value,2); ?></b></td>
						</tr>
						<tr>
							<td>CGST</td>
							<td style="text-align:right;"><b> + <?php echo number_format(($gst_valueTotal/2),2); ?></b></td>
						</tr>
						<tr>
							<td>SGST</td>
							<td style="text-align:right;"><b> + <?php echo number_format(($gst_valueTotal/2),2); ?></b></td>
						</tr>
						<tr>
							<td>Total Amount</td>
							<td style="text-align:right;"><b> <?php echo number_format($totalAmount,2); ?></b></td>
						</tr>
						<tr>
							<td>Round</td>
							<td style="text-align:right;"><b> <?php echo number_format($roundAmount,2); ?></b></td>
						</tr>
						<tr>
							<td>Net Amount</td>
							<td style="text-align:right;"><b> <?php echo number_format(round($net_amountTotal,0),2); ?></b></td>
						</tr>
            <?php
						/*
						if($onlinePayment>0 OR $chequePayment>0){ ?>
						<tr>
							<td>Bank Payment</td>
							<td style="text-align:right;"><b> <?php echo number_format($onlinePayment+$chequePayment,2); ?></b></td>
						</tr>
            <?php
            }
						if($cashPayment>0){ ?>
            <tr>
              <td>Cash Payment</td>
              <td style="text-align:right;"><b> <?php echo number_format($cashPayment,2); ?></b></td>
            </tr>
            <?php
            }
            $dueAmount = $net_amount - ($onlinePayment + $chequePayment + $cashPayment);
            ?>
						<tr>
							<td>Due Amount</td>
							<td style="text-align:right;"><b> <?php if($dueAmount<0){ echo '00.00';}else{ echo number_format($dueAmount,2);} ?></b></td>
						</tr>
            <?php
            if($dueAmount<0){
              $refundAmount = ($onlinePayment + $chequePayment + $cashPayment) - $net_amount;
              ?>
              <tr>
  							<td>Refund Amount</td>
  							<td style="text-align:right;"><b> <?php echo number_format($refundAmount,2); ?></b></td>
  						</tr>
              <?php
            }
            ?>
						<tr>
							<td>Paid Amount</td>
							<td style="text-align:right;"><b> <?php echo number_format($onlinePayment + $chequePayment + $cashPayment,2); ?></b></td>
						</tr>
						<?php
						*/
						?>
					</table>
				</td>
			</tr>
			<tr>
        <td style="text-align:center;"><br><b>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _<b><br>
          Signature<br>
          <?php echo $name_u_admin; ?> (<?php echo get_single_value("user_level","unq_id",$lvl_u_admin,"user_level_nm",""); ?>)
        </td>
      </tr>
		</table>
	<tr>
		<td>
			<table style="width:100%; border-collapse: collapse; border: 1px solid black;">
				<tr>
					<td style="text-align:center; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
            <?php
            $bank_holder_nm = $bank_nm = $bank_ac_number = $branch_nm = $ifsc_code = "";
            $getBank=mysqli_query($conn,"SELECT * FROM `bank_information_tbl` WHERE `stat`=1 AND `primary_stat`=1");
            while ($rowBank=mysqli_fetch_array($getBank)) {
              $bank_holder_nm=$rowBank['bank_holder_nm'];
              $bank_nm=$rowBank['bank_nm'];
              $bank_ac_number=$rowBank['bank_ac_number'];
              $branch_nm=$rowBank['branch_nm'];
              $ifsc_code=$rowBank['ifsc_code'];
            }
            echo 'Bank - '.$bank_nm.' | BRANCH - '.$branch_nm.' | A/C – '.$bank_ac_number.' | IFSC – '.$ifsc_code;
            ?>
          </td>
				</tr>
			</table>
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
<?php
}
?>