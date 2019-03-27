<?php
require("_db/connect.php");
$username=$_SESSION["login"];
$page_sql="SELECT COUNT(*) AS TOTAL FROM booking WHERE username='admin'";
$page_result = mysqli_query($conn, $page_sql);
$page_row = mysqli_fetch_assoc($page_result);
$n=$page_row["TOTAL"];
$rpp=2;
$max=ceil($n/$rpp);
if(isset($_GET["p"])){
$_GET["p"];
}else{
$p=1;
$start = ($p-1)*$rpp;
$booking_check_status_sql="SELECT c.*, t.name FROM booking c INNER JOIN booking_time t on (t.id=c.id) WHERE username='$username' ORDER BY `c`.`id` ASC LIMIT $start , $rpp";
$booking_check_status_result=mysqli_query($conn, $booking_check_status_sql);
$booking_check_status_count="0";
} ?>