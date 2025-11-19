<?php
include '../../config.php';
if($ckadmin==1){
	$invoice_no=mysqli_real_escape_string($conn,$_REQUEST['invoice_no']);
	?>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Billing Products</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<?php
				$pcnt = $taxableAmountTotal = $gstValueTotal = $netAmountTotal = 0;
				$getProductTemp=mysqli_query($conn,"SELECT * FROM `billing_product_item` WHERE `stat`=1 AND `invoice_no`='$invoice_no'");
				if(mysqli_num_rows($getProductTemp)>0){
					?>
					<div class="row">
						<div class="col-12">
							<table class="table table-sm table-bordered">
								<thead>
									<tr>
										<th class="text-center" style="width:2%;">#</th>
										<th class="text-center" style="width:28%;">Product Name</th>
										<th class="text-center" style="width:10%;">Quantity</th>
										<th class="text-center" style="width:12%;">Rate</th>
										<th class="text-center" style="width:12%;">Taxable</th>
										<th class="text-center" style="width:12%;">GST(%)</th>
										<th class="text-center" style="width:12%;">GST Value</th>
										<th class="text-center" style="width:12%;">Net Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									while($rowProductTemp=mysqli_fetch_array($getProductTemp)){
										$pcnt++;
										$member_id=$rowProductTemp['member_id'];
										$product_id=$rowProductTemp['product_id'];
										$quantity=$rowProductTemp['quantity'];
										$product_rate=$rowProductTemp['product_rate'];
										$taxable_amount=$rowProductTemp['taxable_amount'];
										$gst_percentage=$rowProductTemp['gst_percentage'];
										$gst_value=$rowProductTemp['gst_value'];
										$net_amount=$rowProductTemp['net_amount'];
										$productName=get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
										$product_unit=get_single_value('inventory_tbl','unq_id',$product_id,'unit_id','');
										$productUnit=get_single_value('unit_tbl','unq_id',$product_unit,'unit_short_name','');
										$taxableAmountTotal+=$taxable_amount;
										$gstValueTotal+=$gst_value;
										$netAmountTotal+=$net_amount;
										?>
										<tr>
											<td class="text-center"><?php echo $pcnt; ?></td>
											<td><?php echo $productName; ?></td>
											<td class="text-center"><?php echo "$quantity $productUnit"; ?></td>
											<td class="text-right"><?php echo number_format($product_rate,2); ?></td>
											<td class="text-right"><?php echo number_format($taxable_amount,2); ?></td>
											<td class="text-right"><?php echo number_format($gst_percentage,2); ?></td>
											<td class="text-right"><?php echo number_format($gst_value,2); ?></td>
											<td class="text-right"><?php echo number_format($net_amount,2); ?></td>
										</tr>
										<?php
      						}
      						?>
									<tr>
										<td colspan="4">Total</td>
										<td class="text-right"><b><?php echo number_format($taxableAmountTotal,2); ?></b></td>
										<td></td>
										<td class="text-right"><b><?php echo number_format($gstValueTotal,2); ?></b></td>
										<td class="text-right"><b><?php echo number_format($netAmountTotal,2); ?></b></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<?php
					$netAmnt_del = $pcnt_del = 0;
					$getProductDel=mysqli_query($conn,"SELECT * FROM `billing_product_item_return` WHERE `stat`=1 AND `invoice_no`='$invoice_no'");
					if(mysqli_num_rows($getProductDel)>0){
						?>
						<h5>Return Products</h5>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-sm table-bordered">
									<thead>
										<tr>
											<th class="text-center" style="width:10%;">#</th>
											<th class="text-center" style="width:30%;">Product Name</th>
											<th class="text-center" style="width:20%;">Quantity</th>
											<th class="text-center" style="width:20%;">Price</th>
											<th class="text-center" style="width:20%;">Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										while($rowProductDel=mysqli_fetch_array($getProductDel)){
											$pcnt_del++;
											$member_id_del=$rowProductDel['member_id'];
											$invoice_no_del=$rowProductDel['invoice_no'];
											$product_id_del=$rowProductDel['product_id'];
											$quantity_del=$rowProductDel['quantity'];
											$amount_del=$rowProductDel['amount'];
											$productName_del=get_single_value('inventory_tbl','unq_id',$product_id_del,'product_name','');
											$product_unit_del=get_single_value('inventory_tbl','unq_id',$product_id_del,'product_unit','');
											$productUnit_del=get_single_value('unit_tbl','unq_id',$product_unit_del,'unit_short_name','');
											$tamount_del = 0;
											$tamount_del = $quantity_del * $amount_del;
											$netAmnt_del = $netAmnt_del + $tamount_del;
											?>
											<tr>
												<td class="text-center text-danger"><?php echo $pcnt_del; ?></td>
												<td class="text-danger"><?php echo $productName_del; ?></td>
												<td class="text-center text-danger"><?php echo "$quantity_del $productUnit_del"; ?></td>
												<td class="text-right text-danger"><?php echo number_format($amount_del,2); ?></td>
												<td class="text-right text-danger"><?php echo number_format($tamount_del,2); ?></td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<?php
					}
				}
				else {
					?><div class="text-center"><?php echo "<h3 class=\"text-danger\">No Data</h3>"; ?></div><?php
				}
				?>
			</div>
		</div>
	</div>
<?php
}
?>