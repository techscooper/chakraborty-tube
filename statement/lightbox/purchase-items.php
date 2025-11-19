<?php
include '../../config.php';
if($ckadmin==1){
	$purchase_no=mysqli_real_escape_string($conn,$_REQUEST['purchase_no']);
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
				$getProductTemp=mysqli_query($conn,"SELECT * FROM `purchase_product_item` WHERE `stat`=1 AND `purchase_no`='$purchase_no'");
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