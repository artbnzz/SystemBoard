<?php
require("_db/connect.php");
$currentdate=date("Y-m-d");
$sql_booking_time="SELECT * FROM booking_time";
$sql_booking_time_result = mysqli_query($conn, $sql_booking_time);
?>