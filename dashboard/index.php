<?php
include '../config.php';
if($ckadmin==0){
  header('location:../login');
}
else{
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Dashboard | <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header"><div class="left"><h1>Dashboard</h1></div></div>
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-secondary">
                <div class="bg-cyan p-2"><span style="font-size:18px; color:#fff;"><b>Category Wise Stock</b></span></div>
                <div class="body">
                  <div class="row">
                    <div class="col-md-6">
                      <select class="form-control" name="dashboard_product_cat" id="dashboard_product_cat" onchange="getListCatWise()">
                        <?php
                        $getDashboardCat=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1 ORDER BY `category_name`");
                        while ($rowDashboardCat=mysqli_fetch_array($getDashboardCat)){
                          $dashboardCategoryUnqID=$rowDashboardCat['unq_id'];
                          $dashboardCategoryName=$rowDashboardCat['category_name'];
                          ?><option value="<?php echo $dashboardCategoryUnqID;?>"><?php echo $dashboardCategoryName; ?></option><?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div id="div_cat_wise"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card bg-secondary">
                <div class="bg-cyan p-2"><span style="font-size:18px; ;color:#ffffff;"><b>Sale</b>(Today)</span></div>
                <div class="body">
                  <div class="row">
                    <div class="col-md-6">
                      <select class="form-control" name="dashboard_unit" id="dashboard_unit" onchange="getListUnit()">
                        <?php
                        $getDashboardCat=mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `stat`=1 ORDER BY `sl`");
                        while ($rowDashboardCat=mysqli_fetch_array($getDashboardCat)){
                          $unit_unq_id=$rowDashboardCat['unq_id'];
                          $unit_short_name=$rowDashboardCat['unit_short_name'];
                          ?><option value="<?php echo $unit_unq_id;?>"><?php echo $unit_short_name;?></option><?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div id="div_unit_wise"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript">
      $(document).ready(function(){
        getListCatWise();
        getListUnit();
      });
      function getListCatWise(){
        var catuid = $('#dashboard_product_cat').val();
        $("#div_cat_wise").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
        setTimeout(function(){ $("#div_cat_wise").load("jquery-pages/category-wise-product-list.php?catuid="+catuid).fadeIn("fast") }, 100);
      }
      function getListUnit(){
        var dashboard_unit = $('#dashboard_unit').val();
        $("#div_unit_wise").html("Loading... <i class='fa fa-spinner fa-spin'></i>");
        setTimeout(function(){ $("#div_unit_wise").load("jquery-pages/unit-wise-sale.php?dashboard_unit="+dashboard_unit).fadeIn("fast") }, 100);
      }
    </script>
  </body>
</html>
<?php
}
?>