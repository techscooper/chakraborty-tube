<?php
  include '../../config.php';
  $ecsl=mysqli_real_escape_string($conn,$_REQUEST['msl']);
  $get_menu_e=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE sl='$ecsl'");
  while($row_menu_e=mysqli_fetch_array($get_menu_e)){
    $menu_sl_edt=$row_menu_e['sl'];
    $menu_nm_edt=$row_menu_e['menu_nm'];
    $menu_alias_edt=$row_menu_e['menu_alias'];
    $menu_link_edt=$row_menu_e['menu_link'];
    $menu_rank_edt=$row_menu_e['menu_rank'];
    $parent_menu_edt=$row_menu_e['parent_menu'];
    $menu_icon_edt=$row_menu_e['menu_icon'];
    $menu_folder_edt=$row_menu_e['menu_folder'];
  }
  ?>
<div class="modal-dialog modal-xl">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Navigation Update</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="menu_update_frm" name="menu_update_frm" action="menu-setup-code/menu-edit-2.php" method="POST">
        <div class="row col-lg-12">
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_nm_edt">Menu name <span class="text-danger">*</span></label>
              <input type="text" name="menu_nm_edt" id="menu_nm_edt" class="form-control" autofocus value="<?php echo $menu_nm_edt;?>">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_nm_edt">Menu <span class="text-danger">*</span></label>
              <select name="parent_menu_edt" id="parent_menu_edt" class="form-control">
                <option value="0">Root menu</option>
                <?php
                  $get_menu_s_edt=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE parent_menu=0 AND stat=1");
                  while($row_menu_s_edt=mysqli_fetch_array($get_menu_s_edt))
                  {
                  	$p_sl_edt_get=$row_menu_s_edt['sl'];
                  	$parent_menu_edt_get=$row_menu_s_edt['menu_nm'];
                  	?>
                <option value="<?php echo $p_sl_edt_get;?>" <?php echo ($p_sl_edt_get == $parent_menu_edt) ? 'selected' : ''; ?>><?php echo $parent_menu_edt_get;?></option>
                <?php
                  }
                  ?>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_alias_edt">Menu Alias <span class="text-danger">*</span></label>
              <input type="text" name="menu_alias_edt" id="menu_alias_edt" class="form-control" value="<?php echo $menu_alias_edt;?>">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_folder_edt">Menu Folder <span class="text-danger">*</span></label>
              <input name="menu_folder_edt" id="menu_folder_edt" type="text" class="form-control" value="<?php echo $menu_folder_edt;?>">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_icon_edt">Icon <span class="text-danger">*</span></label>
              <input name="menu_icon_edt" id="menu_icon_edt" type="text" class="form-control" value="<?php echo $menu_icon_edt;?>">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_link_edt">Menu Link <span class="text-danger">*</span></label>
              <input name="menu_link_edt" id="menu_link_edt" type="text" class="form-control" value="<?php echo $menu_link_edt;?>">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="floating-label" for="menu_rank_edt">Rank <span class="text-danger">*</span></label>
              <input name="menu_rank_edt" id="menu_rank_edt" type="text" class="form-control" value="<?php echo $menu_rank_edt;?>">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="m_sl_m" id="m_sl_m" value="<?php echo base64_encode($menu_sl_edt);?>">
          <button class="btn btn-primary btn-sm" type="reset">Reset</button>
          <button class="btn btn-success btn-sm" type="submit" id="menu_edt_btn" name="menu_edt_btn">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="../assets/js/pcoded.min.js"></script>
<script type="text/javascript" src="menu-setup-js/menu-edit.js"></script>