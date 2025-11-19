<?php
include '../config.php';
$get=mysqli_query($conn,"SELECT * FROM session_robot_checker WHERE session_id='$sessionIDGet' AND stat=1");
while ($row=mySqli_fetch_array($get)){
	$dynamicDateTime=$row['date_time'];
}
$seconds=abs(strtotime($currentDateTime) - strtotime($dynamicDateTime));
echo $seconds;
?>
