<?php
if(isset($_POST)){
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 16; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
require("../_db/connect.php");
$nohash=randomPassword();
$email=$_POST["forget_password"];
$sql="SELECT * FROM accounts WHERE email='$email'";
$result=mysqli_query($conn,$sql);
if(trim($_POST["forget_password"])==""){
	echo "<script>alert('กรุณาระบุอีเมล์');</script>";
}
elseif (!filter_var($_POST["forget_password"], FILTER_VALIDATE_EMAIL)) {
	echo "<script>alert('อีเมล์ไม่ถูกต้อง');</script>";
}
elseif(mysqli_num_rows($result)==0){
	echo "<script>alert('ไม่พบอีเมล์นี้');</script>";
}else{
	$row=mysqli_fetch_assoc($result);
	$password=md5($nohash);
	$sql2="UPDATE accounts SET password='$password' WHERE email='$email'";
	$result=mysqli_query($conn,$sql2);
	echo "<h1>รหัสผ่านที่ยังไม่ถูกเข้ารหัส</h1><p style='color:green; font-size:2em;'>".$nohash;
	echo "<h1>รหัสผ่านที่ถูกเข้ารหัสด้วย MD5</h1><p style='color:red;font-size:2em;'>".$password;
	?>
<html>
<head>
<title>ระบบส่งเมล์ลืมรหัสผ่าน</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</head>
<body>
<?php
		if(trim($_POST["forget_password"])==""){
		echo "<script>alert('กรุณาระบุอีเมล์');</script>";
		}else{
			$text_username="ชื่อผู้ใช้ : ";
			$text_password="รหัสผ่านใหม่ : ";
			$username=$row["username"];
			$text_text="หลังจากได้รับรหัสผ่านแล้วกรุณาเปลี่ยนรหัสผ่านใหม่ทุกครั้งเพื่อความปลอดภัย";
			$password=$nohash;
			$strTo = "$email";
			$strSubject = "=?UTF-8?B?".base64_encode("SYSTEMBOARD รีเซ็ตรหัสผ่าน")."?=";
			$strHeader .= "MIME-Version: 1.0' . \r\n";
			$strHeader .= "Content-type: text/html; charset=utf-8\r\n"; 
			$strHeader .= "From: SYSTEMBOARD\r\nReply-To: $email";
			$strMessage = "
			<h1 style=''>SYSTEMBOARD ลืมรหัสผ่าน</h1>
			<h4>".$text_username.$username."</h4>
			<h4>".$text_password.$password."</h4>
			<p>".$text_text."</p>
			";
			$send = @mail($strTo,$strSubject,$strMessage,$strHeader);
			if($send)
			{
				echo "<script>alert('ส่งรหัสผ่านไปที่อีเมล์ของคุณแล้วกรุณาตรวจสอบอีเมล์');</script>.";
				echo '<script>window.parent.location = document.referrer;</script>';
			}
			else
			{
				echo "<script>alert('เกิดข้อผิดพลาดไม่สามารถส่งรหัสผ่านใหม่ได้');</script>";
			}
		}
?>
</body>
</html>
<?php
	}
	}
	else{
	exit();
}
?>