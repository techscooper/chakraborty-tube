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
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>Create Unit | <?php echo $projectName; ?></title>
  <?php require_once('../stylesheet.php');?>
</head>
<body class="theme-blue">
  <?php require_once('../navbar/index.php');?>
  <div class="main_content">
    <?php require_once('../sidebar/left-sidebar.php'); ?>
    <div class="page">
      <div class="container-fluid">
        <div class="page_header">
          <div class="left"><h1>Create New Unit</h1></div>
          <div class="right">
            <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
              <span class="btn-inner--visible">Back</span>
              <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <form id="unit_create_frm" name="unit_create_frm" action="inventory-code/create-unit-2.php" method="POST" enctype="multipart/form-data">
                <div class="body">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Unit Name<span class="text-danger"> *</span></label>
                        <input type="text" name="unit_short_name" id="unit_short_name" class="form-control" placeholder="Unit Name *">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Unit Value (Small Unit)<span class="text-danger"> *</span></label>
                        <input type="text" name="unit_value" id="unit_value" value="1" class="form-control" placeholder="Unit value *" onclick="select()">
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-top:30px;">
                      <button class="btn btn-success" type="submit" id="create_unit_btn" name="create_unit_btn">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="body">
                <div class="table-responsive">
                  <table class="table mb-0">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:10%;">#</th>
                        <th class="text-center" style="width:10%;">ACTION</th>
                        <th class="text-center" style="width:50%;">Unit Name</th>
                        <th class="text-center" style="width:30%;">Unit Value (Small Unit)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $slc=0;
                      $getUnitDtls = mysqli_query($conn,"SELECT * FROM `unit_tbl` WHERE `stat`=1 ORDER BY `sl` ASC");
                      while($rowUnitDtls = mysqli_fetch_array($getUnitDtls)){
                        $slc++;
                        $unit_unq_id=$rowUnitDtls['unq_id'];
                        $unit_short_name=$rowUnitDtls['unit_short_name'];
                        $unit_value=$rowUnitDtls['unit_value'];
                        ?>
                        <tr>
                          <td class="text-center"><?php echo $slc;?></td>
                          <td class="text-center">
                            <a href="javascript:void(0);" onclick="update_unit('<?php echo $unit_unq_id;?>')"><i class="fa fa-edit fa-lg" title="Click to Update"></i></a>
                          </td>
                          <td class="text-center"><b><?php echo $unit_short_name;?></b></td>
                          <td class="text-center"><b><?php echo $unit_value;?></b></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('../javascripts.php');?>
  <script type="text/javascript" src="inventory-js/create-unit.js"></script>
  <script type="text/javascript">
  function update_unit(uid){
    $('#div_lightbox').load("lightbox/unit-update.php?uid="+uid).fadeIn("fast");
    $('#modal-report').modal('show');
  }
  </script>
</body>
</html>
<?php
}
?>