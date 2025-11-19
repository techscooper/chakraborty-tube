<?php
include '../../config.php';
if($ckadmin==1){
  $pid=mysqli_real_escape_string($conn,$_REQUEST['pid']);
  mysqli_query($conn,"DELETE FROM `billing_payment_method_temp` WHERE `unq_id` = '$pid'");
}
?>
<script type="text/javascript">
  getPayList();
</script>