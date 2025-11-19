<?php
$servername = "localhost";
$username = "demomein_user";
$password = "4rxaHnXbCOzI";
$dbname = "demomein_stock_cts";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn){ die("Connection failed: " . mysqli_connect_error());}
?>