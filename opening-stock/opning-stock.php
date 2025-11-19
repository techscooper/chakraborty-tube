<?php
include '../config.php';
if ($ckadmin==0){
  header('location:../login');
}
else{
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Opning Stock || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left">
              <h1>Opning Stock</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item">Opening Stock</li>
                <li class="breadcrumb-item active">Opning Stock</li>
              </ol>
            </div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="body">
                  <form method="post" id="openStockFrm" action="opening-stock-code/opning-stock-2.php">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Opening Date <span class="text-danger">*</span></label>
                        <input type="date" name="stk_dt" id="stk_dt" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                      </div>
                    </div>
                    <?php
                    $product_cnt = 0;
                    $getProduct=mysqli_query($conn,"SELECT * FROM `inventory_tbl` WHERE `stat`=1 ORDER BY `product_name`");
                    if(mysqli_num_rows($getProduct)>0){
                      ?>
                      <br>
                      <table class="table table-bordered">
                        <tr>
                          <th class="text-center" style="width:30%;">Product</th>
                          <th class="text-center" style="width:30%;">HSN Code</th>
                          <th class="text-center" style="width:40%;">Opening Qty</th>
                        </tr>
                        <?php
                        while ($rowProduct=mysqli_fetch_array($getProduct)){
                          $product_cnt++;
                          $productUnqId=$rowProduct['unq_id'];
                          $product_name=$rowProduct['product_name'];
                          $hsn_code=$rowProduct['hsn_code'];
                          $unit_id=$rowProduct['unit_id'];
                          $productUnit=get_single_value('unit_tbl','unq_id',$unit_id,'unit_short_name','');
                          ?>
                          <tr>
                            <td class="text-center"><?php echo $product_name; ?></td>
                            <td class="text-center"><?php echo $hsn_code; ?></td>
                            <td>
                              <div class="input-group mb-3">
                                <input type="number" name="product<?php echo $productUnqId;?>" id="product<?php echo $productUnqId;?>" value="" class="form-control" placeholder="Quantity" onclick="select()">
                                <div class="input-group-append"><span class="input-group-text"><?php echo $productUnit; ?></span></div>
                              </div>
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                        <tr><td class="text-right" colspan="3"><button type="submit" class="btn btn-primary" id="openStockBtn">Confirm</button></td></tr>
                      </table>
                      <?php
                    }
                    ?>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <?php
                      $openingCnt=0;
                      $getOpening=mysqli_query($conn,"SELECT * FROM `stock_master` WHERE `stat`=1 AND `typ`=10 ORDER BY `stk_dt`,`sl`");
                      if(mysqli_num_rows($getOpening)>0){
                        ?>
                        <table class="table table-bordered">
                          <tr>
                            <th class="text-center" style="width:5%;">#</th>
                            <th class="text-center" style="width:15%;">Opening Date</th>
                            <th class="text-center" style="width:30%;">Product</th>
                            <th class="text-center" style="width:25%;">HSN Code</th>
                            <th class="text-center" style="width:25%;">Opening Stock</th>
                          </tr>
                          <?php
                          while($rowOpening=mysqli_fetch_array($getOpening)){
                            $productUnqId=$rowOpening['unq_id'];
                            $stk_dt=$rowOpening['stk_dt'];
                            $product_id=$rowOpening['product_id'];
                            $stock_qty=$rowOpening['stock_qty'];
                            $productName=get_single_value('inventory_tbl','unq_id',$product_id,'product_name','');
                            $hsnCode=get_single_value('inventory_tbl','unq_id',$product_id,'hsn_code','');
                            $product_unit=get_single_value('inventory_tbl','unq_id',$product_id,'unit_id','');
                            $productUnit=get_single_value('unit_tbl','unq_id',$product_unit,'unit_short_name','');
                            if($stock_qty>0){
                              $openingCnt++;
                              ?>
                              <tr>
                                <td class="text-center"><?php echo $openingCnt; ?></td>
                                <td class="text-center"><?php echo date('d-m-Y',strtotime($stk_dt)); ?></td>
                                <td class="text-center"><?php echo $productName; ?></td>
                                <td class="text-center"><?php echo $hsnCode; ?></td>
                                <td class="text-center"><?php echo "$stock_qty $productUnit"; ?></td>
                              </tr>
                              <?php
                            }
                          }
                        }
                        ?>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="opening-stock-js/opning-stock.js"></script>
  </body>
</html>
<?php
}
?>