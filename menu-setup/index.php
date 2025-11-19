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
    <title>Create Menu || <?php echo $projectName; ?> ::</title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left"><h1>Create Menu</h1></div>
            <div class="right">
              <a href="manage-menu.php" class="btn btn-primary btn-animated btn-animated-y">
                <span class="btn-inner--visible">Menu List</span>
                <span class="btn-inner--hidden"><i class="fa fa-list"></i></span>
              </a>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header"><h2><i class="fa fa-plus-circle"></i> Create New Menu</h2></div>
                <form id="menu_create_frm" name="menu_create_frm" action="menu-setup-code/create-menu-2.php" method="POST">
                  <div class="body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Menu Name</label>
                          <input type="text" name="menu_nm" id="menu_nm" class="form-control" value="" placeholder="Menu Name">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Root/Sub Menu</label>
                          <select name="parent_menu" id="parent_menu" class="form-control select2">
                            <option value="0">Root Menu</option>
                            <?php
                            $get_menu_s=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `parent_menu`=0 AND `stat`=1");
                            while($row_menu_s=mysqli_fetch_array($get_menu_s)){
                              $p_sl=$row_menu_s['sl'];
                              $parent_menu=$row_menu_s['menu_nm'];
                              ?><option value="<?php echo $p_sl;?>"><?php echo $parent_menu;?></option><?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Menu Alias</label>
                          <input type="text" name="menu_alias" id="menu_alias" class="form-control" value="" placeholder="Menu Alias">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Menu Folder</label>
                          <input type="text" name="menu_folder" id="menu_folder" class="form-control" value="" placeholder="Menu Folder">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Menu Icon</label>
                          <input type="text" name="menu_icon" id="menu_icon" class="form-control" value="" placeholder="Menu Icon">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="floating-label" for="menu_link">Menu Link</label>
                          <input type="text" name="menu_link" id="menu_link" class="form-control" value="javascript:void(0);" placeholder="">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Rank</label>
                          <input type="text" name="menu_rank" id="menu_rank" class="form-control" value="" placeholder="Rank">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 text-right">
                        <button class="btn btn-success" type="submit" id="create_menu_btn" name="create_menu_btn">Confirm</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../javascripts.php');?>
    <script type="text/javascript" src="menu-setup-js/create-menu.js"></script>
  </body>
</html>
<?php
}
?>
