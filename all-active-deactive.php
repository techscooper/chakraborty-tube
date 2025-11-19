<?php
include 'config.php';
if ($ckadmin==0)
{
  header('location:login');
}
else
{
	$tbl_nm=$_REQUEST['tbl_nm'];
	$act_field=$_REQUEST['act_field'];
	$act_value=$_REQUEST['act_value'];
	$unq_field=$_REQUEST['unq_field'];
	$unq_value=$_REQUEST['unq_value'];
	if($act_value==0)
	{
		$act_value=1;
		$actlogo="../assets/allpic/active.png";
		$ttl="Click to De-active";
	}
	else
	{
		$act_value=0;
		$actlogo="../assets/allpic/deactive.png";
		$ttl="Click to Active";
	}
	mysqli_query($conn,"UPDATE $tbl_nm SET $act_field='$act_value' WHERE $unq_field='$unq_value'");

	?>
	<span id="div<?php echo $unq_value;?>">
		<a href="javascript:void(0);" onclick="act_dact_level('<?php echo $tbl_nm;?>','<?php echo $act_field;?>','<?php echo $act_value;?>','<?php echo $unq_field;?>','<?php echo $unq_value;?>')">
			<img src="<?php echo $actlogo;?>" style="width:20px; height:20px;" title="<?php echo $ttl;?>">
		</a>
	</span>
	<?php
}
?>
