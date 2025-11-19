<?php
include '../../config.php';
$due_amnt = $dueAmnt = 0;
$invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
$customerMobile = get_single_value('billing','invoice_no',$invoice_no,'customer_id','');
$customerName = get_single_value('customer_tbl','unq_id',$customerMobile,'customer_nm','');
$customerMail = get_single_value('customer_tbl','unq_id',$customerMobile,'email_id','');
$customerAddress = get_single_value('customer_tbl','unq_id',$customerMobile,'address_1','');
$invoiceDate = get_single_value('billing','invoice_no',$invoice_no,'invoice_date','');
$getPayble=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `paybleAmount` FROM `account_master` WHERE `stat`=1 AND `invoice_no`='$invoice_no' AND `type`=2 AND `level`=1");
while ($rowPayble=mysqli_fetch_array($getPayble)){
	$paybleAmount = $rowPayble['paybleAmount'];
}
$getPaid=mysqli_query($conn,"SELECT SUM(`net_amount`) AS `paidAmount` FROM `account_master` WHERE `stat`=1 AND `invoice_no`='$invoice_no' AND `type`=2 AND `level`=2");
while ($rowPaid=mysqli_fetch_array($getPaid)){
	$paidAmount = $rowPaid['paidAmount'];
}
?>
<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Due Payment</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-6">
			<div class="card bg-secondary">
				<h5 style="border-bottom: 1px solid black; padding-left:5px;"><b>Customer</b></h5>
				<div class="body">
					<div class="row">
						<div class="col-lg-12" style="height:110px;">
							<span>Name: <b><?php echo $customerName; ?></b></span><br>
							<span>Mobile: <b><?php if($customerMobile!=""){ echo $customerMobile;}else{ echo "Na";} ?></b></span><br>
							<span>Mail: <b><?php if($customerMail!=""){ echo $customerMail;}else{ echo "Na";} ?></b></span><br>
							<span>Address: <b><?php if($customerAddress!=""){ echo $customerAddress;}else{ echo "Na";} ?></b></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card bg-secondary">
				<h5 style="border-bottom: 1px solid black; padding-left:5px;"><b>Invoice</b></h5>
				<div class="body">
					<div class="row">
						<div class="col-lg-12" style="height:110px;">
							<span>No: <b><?php echo $invoice_no; ?></b></span><br>
							<span>Date: <b><?php echo date('d-m-Y',strtotime($invoiceDate)); ?></b></span><br>
							<span>Net Price: <b><?php echo number_format($paybleAmount,2); ?></b></span><br>
							<span>Payment: <b><?php echo number_format($paidAmount,2); ?></b></span><br>
							<span>Due: <b><?php echo number_format(($paybleAmount-$paidAmount),2); ?></b></span><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
$pcnt = $netAmnt = 0;
$getProductTemp=mysqli_query($conn,"SELECT * FROM `billing_product_item` WHERE `stat`=1 AND `invoice_no`='$invoice_no'");
$rcntProductTemp=mysqli_num_rows($getProductTemp);
if($rcntProductTemp>0){
?>
<div class="row">
  <div class="col-lg-12">
    <table class="bg-secondary" style="width:100%;">
      <thead>
				<tr><th colspan="5" style="border: 1px solid black; font-size:18px; padding-left:5px;"><b>Product Details</b></th></tr>
        <tr>
          <th class="text-center" style="width:5%; border: 1px solid black;">#</th>
          <th class="text-center" style="width:35%; border: 1px solid black;">Product</th>
          <th class="text-center" style="width:15%; border: 1px solid black;">Quantity</th>
					<th class="text-center" style="width:15%; border: 1px solid black;">Price</th>
          <th class="text-center" style="width:15%; border: 1px solid black;">Amount</th>
        </tr>
      </thead>
      <tbody>
      <?php
      while ($rowProductTemp=mysqli_fetch_array($getProductTemp)){
        $pcnt++;
				$sl = $rowProductTemp['sl'];
				$member_id = $rowProductTemp['member_id'];
				$product_id = $rowProductTemp['product_id'];
				$quantity = $rowProductTemp['quantity'];
				$amount = $rowProductTemp['amount'];

				$productName = get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
				$product_unit = get_single_value('inventory_tbl','unq_id',$product_id,'product_unit','');
				$productUnit = get_single_value('unit_tbl','sl',$product_unit,'unit_short_name','');

				$tamount = 0;
				$tamount = $quantity * $amount;
        ?>
        <tr>
          <td class="text-center" style="border: 1px solid black;"><?php echo $pcnt; ?></td>
					<td style="border: 1px solid black;"><?php echo $productName; ?></td>
					<td class="text-center" style="border: 1px solid black;"><?php echo "$quantity $productUnit"; ?></td>
					<td class="text-right" style="border: 1px solid black;"><?php echo number_format($amount,2); ?></td>
          <td class="text-right" style="border: 1px solid black;"><?php echo number_format($tamount,2); ?></td>
        </tr>
      <?php
      }
      ?>
			<tr>
				<td colspan="4" style="border: 1px solid black;"><b>Total</b></td>
				<td class="text-right" style="border: 1px solid black;"><b><?php echo number_format($paybleAmount,2); ?></b></td>
			</tr>
      </tbody>
    </table>
  </div>
</div>
<?php
}
$amountCount = $total_net_amount = 0;
$getPay=mysqli_query($conn,"SELECT * FROM `account_master` WHERE `stat`=1 AND `invoice_no`='$invoice_no' AND `type`=2 AND `level`=2 ORDER BY `sl` ASC");
if(mysqli_num_rows($getPay)>0){
?>
<br>
<div class="row">
  <div class="col-lg-12">
		<table class="bg-secondary" style="width:100%; border: 1px solid black;">
		 <thead>
			 <tr><th colspan="7" style="border: 1px solid black; font-size:18px; padding-left:5px;"><b>Payment History</b></th></tr>
		   <tr>
		     <th class="text-center" style="width:5%; border: 1px solid black;">#</th>
		     <th class="text-center" style="width:10%; border: 1px solid black;">Date</th>
		     <th class="text-center" style="width:10%; border: 1px solid black;">Method</th>
				 <th class="text-center" style="width:45%; border: 1px solid black;">Remark</th>
		     <th class="text-center" style="width:10%; border: 1px solid black;">Payment</th>
		   </tr>
		 </thead>
		 <tbody>
		 <?php
			while ($rowPay=mysqli_fetch_array($getPay)){
			  $amountCount++;
			  $bill_date = $rowPay['bill_date'];
			  $pay_method = $rowPay['pay_method'];
			  $net_amount = $rowPay['net_amount'];
			  $remark = $rowPay['remark'];
			  $payMethod = get_single_value("payment_method","sl",$pay_method,"pay_method","");

				$total_net_amount = $total_net_amount + $net_amount;
				?>
			  <tr>
			    <td class="text-center" style="border: 1px solid black;"><?php echo $amountCount; ?></td>
			    <td class="text-center" style="border: 1px solid black;"><?php echo date('d-m-Y',strtotime($bill_date)); ?></td>
			    <td class="text-center" style="border: 1px solid black;"><?php echo $payMethod; ?></td>
					<td class="text-left" style="border: 1px solid black;">&nbsp;<?php echo $remark; ?></td>
			    <td class="text-right" style="border: 1px solid black;"><?php echo number_format($net_amount,2); ?>&nbsp;</td>
			  </tr>
			  <?php
			}
			?>
			<tr>
				<td class="text-center" colspan="4" style="border: 1px solid black;"><b>Total</b></td>
				<td class="text-right" style="border: 1px solid black;"><b><?php echo number_format($total_net_amount,2); ?>&nbsp;</b></td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>
<br>
<form id="due_pay_frm" name="due_pay_frm" action="" method="POST">
<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
<input type="hidden" name="net_amnt" id="net_amnt" value="<?php echo $paybleAmount; ?>">
<div class="row">
	<div class="col-md-12">
		<div class="card bg-secondary">
			<span style="border-bottom: 1px solid black; font-size:18px; padding-left:5px;"><b>Payment</b></span>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="input-group">
							<div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
							<input type="date" name="pay_date" id="pay_date" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm">
						</div>
					</div>
				</div>
				<div class="row pt-2">
					<div class="col-md-2">
						<div class="form-group">
							<label><b>Method</b></label>
							<select class="form-control form-control-sm" name="pay_method" id="pay_method" onchange="getLedger(this.value)">
								<option value="">-- Select --</option>
								<?php
								$getPaymentMethod=mysqli_query($conn,"SELECT * FROM `payment_method` WHERE `stat`=1");
								while ($rowPaymentMethod=mysqli_fetch_array($getPaymentMethod)){
									$pay_typ_sl = $rowPaymentMethod['sl'];
									$pay_method_name = $rowPaymentMethod['pay_method'];
									?><option value="<?php echo $pay_typ_sl;?>"><?php echo $pay_method_name;?></option><?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label><b>Received to</b></label>
							<div id="divLedger">
								<select class="form-control form-control-sm" name="ledger_id" id="ledger_id">
									<option value="">-- Select --</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label><b>Amount</b></label>
							<div class="input-group">
								<input type="number" name="pay_amnt" id="pay_amnt" value="" onclick="select()" class="form-control form-control-sm" min="0">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Remark / Reference No.</label>
							<input type="text" name="narration" id="narration" class="form-control form-control-sm" value="" placeholder="Remark">
						</div>
					</div>
					<div class="col-md-2" style="padding-top:31px;">
						<button type="sumbit" name="pay_method_btn" id="pay_method_btn" class="btn btn-sm btn-info">Payment</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php
						$amountCount = 0;
						$getPay=mysqli_query($conn,"SELECT * FROM `billing_payment_method_temp` WHERE `stat`=1 AND `invoice_no`='$invoice_no' ORDER BY `sl` ASC");
						if(mysqli_num_rows($getPay)>0){
						?>
						<table class="bg-secondary" style="width:100%; border: 1px solid black;">
						 <thead>
							 <tr>
								 <th class="text-center" style="width:10%; border: 1px solid black;">Action</th>
								 <th class="text-center" style="width:10%; border: 1px solid black;">Received to</th>
								 <th class="text-center" style="width:10%; border: 1px solid black;">Pay</th>
								 <th class="text-center" style="width:10%; border: 1px solid black;">Due</th>
								 <th class="text-center" style="width:40%; border: 1px solid black;">Remark</th>
							 </tr>
						 </thead>
						 <tbody>
							<?php
							while ($rowPay=mysqli_fetch_array($getPay)){
 				 			  $payUnqId = $rowPay['unq_id'];
 				 			  $pay_typ = $rowPay['pay_typ'];
 				 			  $pay_method = $rowPay['pay_method'];
 				 			  $ledger_id = $rowPay['ledger_id'];
 				 			  $pay_amnt = $rowPay['pay_amnt'];
 				 			  $due_amnt = $rowPay['due_amnt'];
 				 			  $narration = $rowPay['narration'];
								$ledgerName = get_single_value("expense_ledger","unq_id",$ledger_id,"ledger_name","");
 				 			  $payMethod = get_single_value("payment_method","sl",$pay_method,"pay_method","");
 				 			  ?>
 				 			  <tr class="<?php echo $payColor; ?>">
 				 			    <td class="text-center" style="border: 1px solid black;">
										<i class="fa fa-trash fa-lg" style="color:red; cursor:pointer;" title="Click to Delete" onclick="payDelete('<?php echo $invoice_no; ?>','<?php echo $payUnqId; ?>')"></i>
									</td>
 				 			    <td class="text-center" style="border: 1px solid black;"><?php echo "$payMethod - $ledgerName"; ?></td>
 				 			    <td class="text-right" style="border: 1px solid black;"><?php echo number_format($pay_amnt,2); ?>&nbsp;</td>
 				 			    <td class="text-right" style="border: 1px solid black;"><?php echo number_format($due_amnt,2); ?>&nbsp;</td>
 				 			    <td class="text-left" style="border: 1px solid black;">&nbsp;<?php echo $narration; ?></td>
 				 			  </tr>
 				 			  <?php
 				 			}
 				 			?>
						 </tbody>
					 </table>
					 <?php
				 	 }
					 ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-center">
		<button type="submit" name="due_pay_btn" id="due_pay_btn" class="btn btn-primary">Confirm</button>
	</div>
</div>
</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="payment-js/due-payment.js"></script>
<script type="text/javascript" src="payment-js/due-payment-temp.js"></script>