<?php
if (!empty($_POST)){
require("../../_db/connect.php");
	if(trim($_POST["progress"]=="")){
		$id=$_POST["id"];
		echo "<script>alert('อัพเดตสถานะใบจองเลขที่ : $id เรียบร้อยแล้ว');</script>";
		echo '<script>window.parent.location = document.referrer;</script>';
	}else{
		$status=$_POST["progress"];
		$id=$_POST["id"];
		$sql="UPDATE Booking SET status = '$status' WHERE id = '$id'";
		mysqli_query($conn,$sql);
		echo "<script>alert('อัพเดตสถานะใบจองเลขที่ : $id เรียบร้อยแล้ว');</script>";
		echo '<script>window.parent.location = document.referrer;</script>';
	}
}
?>