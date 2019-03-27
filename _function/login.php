<?php
session_start();
	if(trim($_POST["login_username"]) == "" || trim($_POST["login_password"]) == ""){
		echo "<script>alert('กรุณาระบุชื่อผู้ใช้และรหัสผ่าน');</script>";
	}
	elseif(isset($_POST["login_username"]))
	{
		$u=$_POST["login_username"];
		$p=md5($_POST["login_password"]);
		require("../_db/connect.php");
		$sql="SELECT * FROM accounts WHERE username='$u' AND password='$p'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
			$row = mysqli_fetch_assoc($result);
			$_SESSION["login"]=$row["username"];
			$_SESSION["name"]=$row["name"];
			$_SESSION["lastname"]=$row["lastname"];
			$_SESSION["status"]=$row["status"];
			echo "<script>alert('เข้าสู่ระบบสำเร็จ');</script>";
			echo '<script>window.parent.location = document.referrer;</script>';
		}
		else
		{
			echo "<script>alert('ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง');</script>";
		}
	  }
?>