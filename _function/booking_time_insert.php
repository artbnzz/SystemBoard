<?php
session_start();
require("../_db/connect.php");
$username=$_SESSION["login"];
$booking_date=explode("/", $_POST["booking_date"]);
$booking_date_year=($booking_date[2]-543).$booking_date[1].$booking_date[0];
$booking_time=$_POST["booking_time"];
$booking_note=$_POST["booking_note"];
$booking_check=implode(",",$_POST["booking_check"]);
$sql_booking="SELECT c.*, t.time_id FROM booking_time c INNER JOIN booking t on (c.id=t.time_id) WHERE date='$booking_date_year-$booking_date[1]-$booking_date[0]' AND time_id='$booking_time'";
$sql_booking_result = mysqli_query($conn, $sql_booking);
$sql555="SELECT * FROM booking_time WHERE id='$booking_time'";
$sql555_query = mysqli_query($conn, $sql555);
$booking_time_row=mysqli_fetch_assoc($sql555_query);
$timename=explode(" ",$booking_time_row["name"]);
if(trim($_POST["booking_date"]) == ""){
	echo "<script>alert('กรุณาเลือกวันที่');</script>";
}elseif(trim($_POST["booking_time"]) == ""){
	echo "<script>alert('กรุณาเลือกเวลา');</script>";
}elseif($timename[0] < date("H.i") && $booking_date_year==date("Ymd")){
	echo "<script>alert('เวลานี้ เลยเวลาแล้วกรุณาเปลี่ยนเวลา');</script>";
}elseif(empty($_POST["booking_check"])){
	echo "<script>alert('กรุณา เรื่องที่นัดหมาย');</script>";
}elseif(mysqli_num_rows($sql_booking_result) > 0){
	echo "<script>alert('เวลานี้ถูกจองไปแล้ว กรุณาเปลี่ยนเวลา');</script>";
}else{
	$sql_booking_insert="INSERT INTO `booking` (`id`, `username`, `date`, `check`, `note`, `time_id`, `status`) 
	VALUES (NULL, '$username', '$booking_date_year-$booking_date[1]-$booking_date[0]', '$booking_check', '$booking_note', '$booking_time', '1')";
	mysqli_query($conn, $sql_booking_insert);
	$sql5="SELECT * FROM booking_name WHERE id in (".$booking_check.")";
	$result5=mysqli_query($conn,$sql5);
	while ($row5=mysqli_fetch_assoc($result5)) {
	$sql2="UPDATE booking_name SET count='".($row5["count"]+1)."' WHERE id='".$row5["id"]."'";
	mysqli_query($conn,$sql2);
	}
	echo "<script>alert('จองสำเร็จ');</script>";
	echo '<script>window.top.location.href = "../"</script>';
}
?>