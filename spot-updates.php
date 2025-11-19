<?php
include 'config.php';

$sl=$_REQUEST['sl'];
$fn=$_REQUEST['fn'];
$fv=rawurldecode($_REQUEST['fv']);
$div=$_REQUEST['div'];
$tblnm=$_REQUEST['tblnm'];

if($fv==""){$fv=0;}
mysqli_query($conn,"UPDATE $tblnm SET $fn='$fv' WHERE sl='$sl'");
?>
<a href="javascript:void(0);" onclick="spotUpdate1('<?php echo $sl;?>','<?php echo $fn;?>','<?php echo $fv;?>','<?php echo $div;?>','<?php echo $tblnm;?>')"><?php echo $fv;?></a>
