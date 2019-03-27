<?php
session_start();
require("../_db/connect.php");
$username=$_SESSION["login"];
$old_password=$_POST["old_password"];
$old=md5($_POST["old_password"]);
$password=$_POST["password"];
$password_confirm=$_POST["password_confirm"];
if(trim($old_password)==""){
	echo "<script>alert('กรุณาระบุรหัสผ่านเดิม');</script>";
}
elseif(trim($password)==""){
	echo "<script>alert('กรุณาระบุรหัสผ่านใหม่');</script>";
}
elseif(trim($password_confirm)==""){
	echo "<script>alert('กรุณายืนยันรหัสผ่านใหม่');</script>";
}
elseif($password!=$password_confirm){
	echo "<script>alert('ยืนรหัสผ่านใหม่ไม่ตรงกัน');</script>";
}else{
	$sql="SELECT * FROM accounts WHERE username='$username'";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$password_insert=md5($password);
	if($row["password"]!=$old){
		echo "<script>alert('รหัสผ่านเดิมไม่ถูกต้อง');</script>";
	}else{
	$sql2="UPDATE accounts SET password='$password_insert' WHERE username='$username'";
	$result2=mysqli_query($conn,$sql2);
	echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ');</script>";
	echo '<script>window.top.location.href = "../"</script>';
	}
}
?>