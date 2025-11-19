<?php
include '../../config.php';
if($ckadmin==1){  
  $opening_date_frm = mysqli_real_escape_string($conn,rawurldecode($_REQUEST['opening_date_frm']));
  $opening_date_to = mysqli_real_escape_string($conn,rawurldecode($_REQUEST['opening_date_to']));
  $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1");
  if(mysqli_num_rows($getProduct)>0){
    ?>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table class="table table-sm c_table">
            <tr>
             <th class="text-center" style="width:20%;">Product</th>
             <th class="text-center" style="width:20%;">Opening Stock</th>
             <th class="text-center" style="width:20%;">Purchase Stock</th>
             <th class="text-center" style="width:20%;">Sale Stock</th>
             <th class="text-center" style="width:20%;">Closing stock</th>
            </tr>
          <?php
          $total_avStkClosing = 0;
          while ($rowProduct=mysqli_fetch_array($getProduct)){
            $productUnqId = $rowProduct['unq_id'];
            $product_name = $rowProduct['product_name'];
            $hsn_code = $rowProduct['hsn_code'];
            $product_unit = $rowProduct['unit_id'];
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

            $total_avStkClosing = $total_avStkClosing + $avStkClosing;

            if($avStkBefore>0 OR $avStkPurchase>0 OR $tStockInSale>0 OR $avStkClosing>0){
              ?>
              <tr>
                <td><?php echo "$product_name ($hsn_code)"; ?></td>
                <td class="text-center"><?php echo "$avStkBefore $productUnit"; ?></td>
                <td class="text-center"><?php echo "$avStkPurchase $productUnit"; ?></td>
                <td class="text-center"><?php echo "$tStockInSale $productUnit"; ?></td>
                <td class="text-center"><?php echo "$avStkClosing $productUnit"; ?></td>
              </tr>
              <?php
            }
          }
          ?>
          <tr>
            <td colspan="4">Total</td>
            <td class="text-center"><b><?php echo "$total_avStkClosing"; ?></b></td>
          </tr>
          </table>
        </div>
      </div>
    </div>
  <?php
  }
  else{
    ?><div><?php echo "No Data Available"; ?></div><?php
  }
}
?>