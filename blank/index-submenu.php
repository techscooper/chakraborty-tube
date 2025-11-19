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
    <title><?php echo $RootMenuLinkName; ?> || <?php echo $projectName; ?></title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php'); ?>
    <div class="main_content">
      <?php
      require_once('../sidebar/left-sidebar.php');
      ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left">
              <h1><?php echo $RootMenuLinkName; ?></h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active"><?php echo $RootMenuLinkName; ?></li>
              </ol>
            </div>
          </div>
          <div class="mt-3"></div>
          <div class="row">
            <?php require_once('../header/child-menu.php'); ?>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
  </body>
</html>
<?php
}
?>
