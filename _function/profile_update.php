<?php
session_start();
if(isset($_SESSION["login"])){
require("../_db/connect.php");
	$username=$_SESSION["login"];
	if(!empty($_FILES['image']['tmp_name'])) {
	$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	}
	$image_update="";
	if(isset($image)){if(trim($image)!="") $image_update = ", image='$image'";}
	$name=$_POST["profile_name"];
	$lastname=$_POST["profile_lastname"];
	$tel=$_POST["profile_tel"];
	$email=$_POST["profile_email"];
	$houseno=$_POST["profile_houseno"];
	$subarea=explode(",", $_POST["SubDistrict"]);
	$area=explode(",", $_POST["District"]);
	$province=explode(",", $_POST["Province"]);
	$zipcode=$_POST["Zipcode"];
	$check_email="SELECT * FROM accounts WHERE email='$email'";
	$email_result = mysqli_query($conn, $check_email);
	$check_email2="SELECT * FROM accounts WHERE username='$username'";
	$email_result2 = mysqli_query($conn, $check_email2);
	$email_row = mysqli_fetch_assoc($email_result2);
	if(trim($name) == "" || trim($lastname) == "" || trim($tel) == "" || trim($email) == "" || trim($houseno) == "" || trim($province[1]) == "" || trim($area[1]) == ""|| trim($subarea[1]) == "" || trim($zipcode) == ""){
		echo "<script>alert('กรุณาระบุข้อมูลให้ครบ');</script>";
	}
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<script>alert('อีเมล์ไม่ถูกต้อง');</script>";
	}
	elseif($email!=$email_row["email"]){
		if(mysqli_num_rows($email_result) > 0){
			echo "<script>alert('อีเมล์นี้ถูกใช้ไปแล้ว');</script>";
		}
		else{
		$sql="UPDATE accounts SET name='$name', lastname='$lastname', tel='$tel', email='$email' $image_update WHERE username='$username'";
		$sql2="UPDATE address SET houseno='$houseno', subarea='$subarea[1]', area='$area[1]', province='$province[1]', postalcode='$zipcode' WHERE username='$username'";
		mysqli_query($conn,$sql);
		mysqli_query($conn,$sql2);
		echo "<script>alert('บันทึกข้อมูลส่วนตัวสำเร็จ');</script>";
		echo '<script>window.top.location.href = "../"</script>';
		}
	}else{
		$sql="UPDATE accounts SET name='$name', lastname='$lastname', tel='$tel', email='$email' $image_update WHERE username='$username'";
		$sql2="UPDATE address SET houseno='$houseno', subarea='$subarea[1]', area='$area[1]', province='$province[1]', postalcode='$zipcode' WHERE username='$username'";
		mysqli_query($conn,$sql);
		mysqli_query($conn,$sql2);
		echo "<script>alert('บันทึกข้อมูลส่วนตัวสำเร็จ');</script>";
		echo '<script>window.top.location.href = "../"</script>';
	}
}
?>
