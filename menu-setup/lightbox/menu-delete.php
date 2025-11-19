<?php
include '../../config.php';
$ecsl_d=mysqli_real_escape_string($conn,$_REQUEST['msl']);
$get_menu_d=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE sl='$ecsl_d'");
while($row_menu_d=mysqli_fetch_array($get_menu_d)){
  $menu_sl_del=$row_menu_d['sl'];
  $menu_nm_del=$row_menu_d['menu_nm'];
}
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Navigation Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<div class="modal-body">
  <form id="menu_delete_frm" name="menu_delete_frm" action="menu-setup-code/menu-delete-2.php" method="POST">
    <div class="row">
      <div class="col s12">
        <h5 style="color:red;">Are You Sure To Delete This ?</h5>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="m_sl_m_d" id="m_sl_m_d" value="<?php echo base64_encode($menu_sl_del);?>">
      <button class="btn btn-danger btn-flat" type="submit" id="menu_del_btn" name="menu_del_btn">Confirm</button>
    </div>
  </form>
</div>
	</div>
</div>
<script type="text/javascript" src="menu-setup-js/menu-delete.js"></script>