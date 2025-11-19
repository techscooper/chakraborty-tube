<?php
$colorCnt = 0;
$bgColors = array("info","success","azure","indigo","pink","cyan","blush","warning");
$getChildMenuLink=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `parent_menu`='$RootMenuLink_sl' AND `parent_menu`!=0 AND `stat`=1 ORDER BY `menu_rank`");
while($rowChildMenuLink=mysqli_fetch_array($getChildMenuLink)) {
  $colorCnt = 5;
  $childMenuSl = $rowChildMenuLink['sl'];
  $childMenuName = $rowChildMenuLink['menu_nm'];
  $childMenuLink = $rowChildMenuLink['menu_link'];
  $childMenuIcon = $rowChildMenuLink['menu_icon'];

  $childMenuAccsStat = "";
  $getChildMenuAccsData=mysqli_query($conn,"SELECT * FROM `menu_accs` WHERE `emp_id_sl`='$lvl_u_admin' AND `menu_id`='$childMenuSl'");
  while($rowChildMenuAccsData=mysqli_fetch_array($getChildMenuAccsData)) {
    $childMenuAccsStat=$rowChildMenuAccsData['stat'];
  }

  if($lvl_u_admin<1) {
    ?>
    <div class="col-xl-3 col-lg-3 col-md-6">
      <div class="card border-dark">
        <div class="color-entry bg-<?php echo $bgColors[$colorCnt];?>">
          <a href="<?php echo $childMenuLink; ?>">
            <div class="body d-flex justify-content-between">
              <div>
                <h5 style="color:#fff;"><?php echo $childMenuName; ?></h5>
                <span class="text-white"><i class="<?php echo $childMenuIcon; ?> fa-lg"></i> Click here</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <?php
  }
  elseif ($childMenuAccsStat==1) {
    ?>
    <div class="col-xl-3 col-lg-3 col-md-6">
      <div class="card border-dark">
        <div class="color-entry bg-<?php echo $bgColors[$colorCnt];?>">
          <a href="<?php echo $childMenuLink; ?>">
            <div class="body d-flex justify-content-between">
              <div>
                <h5 style="color:#fff;"><?php echo $childMenuName; ?></h5>
                <span class="text-white"><i class="<?php echo $childMenuIcon; ?>"></i> Click here</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <?php
  }
}
?>