<?php
if(isset($_POST["register_username"]))
{
	$SubDistrict=explode(",", $_POST["SubDistrict"]);
	$District=explode(",", $_POST["District"]);
	$Province=explode(",", $_POST["Province"]);
	require("../_db/connect.php");
	$register_username=$_POST["register_username"];
	$register_password=md5($_POST["register_password"]);
	$register_password_confirm=md5($_POST["register_password_confirm"]);
	$register_name=$_POST["register_name"];
	$register_lastname=$_POST["register_lastname"];
	$register_tel=$_POST["register_tel"];
	$register_email=$_POST["register_email"];
	$register_houseno=$_POST["register_houseno"];
	$register_subarea=$SubDistrict;
	$register_area=$District;
	$register_province=$Province;
	$register_postalcode=$_POST["Zipcode"];
	$check_username="SELECT * FROM accounts WHERE username='$register_username'";
	$selectresult = mysqli_query($conn, $check_username);
	$check_email="SELECT * FROM accounts WHERE email='$register_email'";
	$email_result = mysqli_query($conn, $check_email);
	if(trim($register_username) == "" || trim($register_password) == "" || trim($register_password_confirm) == "" 
	|| trim($register_name) == "" || trim($register_lastname) == "" || trim($register_tel) == "" || trim($register_email) == ""
	|| trim($register_houseno) == "" || trim($register_subarea[1]) == "" || trim($register_area[1]) == "" || trim($register_province[1]) == ""
	|| trim($register_postalcode) == ""){
		echo "<script>alert('กรุณาระบุข้อมูลให้ครบ');</script>";
	}
	elseif(mysqli_num_rows($selectresult) > 0){
		echo "<script>alert('ชื่อผู้ใช้ถูกใช้ไปแล้ว');</script>";
	}
	elseif(mysqli_num_rows($email_result) > 0){
		echo "<script>alert('อีเมล์นี้ถูกใช้ไปแล้ว');</script>";
	}
	elseif($register_password != $register_password_confirm){
		echo "<script>alert('ยืนยันรหัสผ่านไม่ตรงกัน');</script>";
	}
	elseif (!filter_var($register_email, FILTER_VALIDATE_EMAIL)) {
		echo "<script>alert('อีเมล์ไม่ถูกต้อง');</script>";
	}
	else{
		$send_register="INSERT INTO accounts values(NULL,'$register_username','$register_password','$register_name','$register_lastname','$register_email','$register_tel','0','');";
		$send_register_address="INSERT INTO address values(NULL,'$register_username','$register_houseno','$register_subarea[1]','$register_area[1]','$register_province[1]','$register_postalcode');";
		mysqli_query($conn, $send_register);
		mysqli_query($conn, $send_register_address);
		echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว');</script>";
		echo '<script>window.parent.location = document.referrer;</script>';
	}
}
?>