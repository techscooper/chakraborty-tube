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
    <title>Product Category | <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php'); ?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Product Category</h1></div>
            <div class="right">
              <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Back</span>
                <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card border-dark">
                <div class="card-header bg-secondary border-dark pt-2 pb-0 pl-1"><h4><i class="fa fa-circle"></i> List of Category</h4></div>
                <div class="card-body">
                  <form id="categoryAddFrm" action="inventory-code/category-add-2.php" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><b>Product Category <span class="text-danger">*</span></b></label>
                          <input type="text" name="category_nm" id="category_nm" class="form-control" placeholder="Category *" autofocus>
                        </div>
                      </div>
                      <div style="padding-top:30px;" class="col-md-4 text-left">
                        <button class="btn btn-success" type="submit" id="categoryAddBtn">Submit</button>
                      </div>
                    </div>
                    </form>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card border-dark">
              <div class="card-header bg-secondary border-dark pt-2 pb-0 pl-1"><h4><i class="fa fa-list"></i> List of Category</h4></div>
                <div class="card-body p-0">
                  <div id="divCategoryList"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="inventory-js/category-add.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){ getCategoryList(); });
      function getCategoryList(){
        $('#divCategoryList').load("jquery-pages/show-category-list.php").fadeIn("fast");
      }
      /*
		function category_edit(category_uid)
		{
			$('#div_lightbox').load("lightbox/edit-category.php?category_uid="+category_uid).fadeIn("fast");
			$('#modal-report').modal('show');
		}
    function category_delete(category_uid)
		{
			$('#div_lightbox').load("lightbox/delete-category.php?category_uid="+category_uid).fadeIn("fast");
			$('#modal-report').modal('show');
		}
    */
		</script>
  </body>
</html>
<?php
}
?>