<?php
include '../../config.php';
if($ckadmin==1){
?>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Return Invoice</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-12">
          <table class="table table-bordered">
            <tr>
              <th>#</th>
              <th>Invoice No</th>
              <th>Return No</th>
              <th>Date</th>
              <th>Amount</th>
            </tr>
            <?php
            $cntReturnInvoice=0;
            $getReturnInvoice=mysqli_query($conn,"SELECT * FROM `billing_return` WHERE `stat`=1 AND `return_stat`=1");
            while($rowReturnInvoice=mysqli_fetch_array($getReturnInvoice)) {
              $cntReturnInvoice++;
              $customer_id=$rowReturnInvoice['customer_id'];
              $invoice_no=$rowReturnInvoice['invoice_no'];
              $return_no=$rowReturnInvoice['return_no'];
              $invoice_date=$rowReturnInvoice['invoice_date'];
              $disc_type=$rowReturnInvoice['disc_type'];
              $dis_per=$rowReturnInvoice['dis_per'];
              $dis_amnt=$rowReturnInvoice['dis_amnt'];
              $subtotal_amnt=$rowReturnInvoice['subtotal_amnt'];
              $net_amnt=$rowReturnInvoice['net_amnt'];
              ?>
              <tr>
                <td><?php echo $cntReturnInvoice; ?></td>
                <td><?php echo $invoice_no; ?></td>
                <td><?php echo $return_no; ?></td>
                <td><?php echo date('d-m-Y',strtotime($invoice_date)); ?></td>
                <td><?php echo number_format($net_amnt,2); ?></td>
              </tr>
              <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
}
?>