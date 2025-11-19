<?php
include '../../config.php';
if($ckadmin==1){
  $temp_sl=mysqli_real_escape_string($conn,$_REQUEST['sl']);
  $fun_nm=mysqli_real_escape_string($conn,$_REQUEST['fun_nm']);
  $tbl_nm=mysqli_real_escape_string($conn,$_REQUEST['tbl_nm']);
  mysqli_query($conn,"DELETE FROM `$tbl_nm` WHERE `sl`='$temp_sl'");
  ?>
  <script type="text/javascript">
    <?php echo "$fun_nm('')";?>
  </script>
<?php
}
?>