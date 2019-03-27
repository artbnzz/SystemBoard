<html>
<head>
<title>ระบบส่งเมล์ตอบคำถาม</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</head>
<body>
<?php
	if(isset($_POST)){
		if(trim($_POST["name"])==""){
		echo "<script>alert('กรุณาระบุชื่อ-นามสกุล');</script>";
		}
		elseif(trim($_POST["email"])==""){
		echo "<script>alert('กรุณาระบุอีเมล์');</script>";
		}
		elseif(trim($_POST["tel"])==""){
		echo "<script>alert('กรุณาระบุเบอร์โทร');</script>";
		}
		elseif(trim($_POST["text"])==""){
		echo "<script>alert('กรุณาระบุข้อความ');</script>";
		}
		elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		echo "<script>alert('อีเมล์ไม่ถูกต้อง');</script>";
		}else{
			$name=$_POST["name"];
			$email=$_POST["email"];
			$tel=$_POST["tel"];
			$text=$_POST["text"];
			$text_name="ชื่อ-นามสกุล : ";
			$text_tel="เบอร์โทรติดต่อกลับ : ";
			$text_email="อีเมล์ติดต่อกลับ : ";
			$text_text="ข้อความ : ";
			$strTo = "artzakung2010@gmail.com";
			$strSubject = "=?UTF-8?B?".base64_encode("สอบถามจากคุณ $name")."?=";
			$strHeader .= "MIME-Version: 1.0' . \r\n";
			$strHeader .= "Content-type: text/html; charset=utf-8\r\n"; 
			$strHeader .= "From: $name\r\nReply-To: $email";
			$strMessage = "
			<h1 style=''>ลามูเน่</h1>
			<h3>".$text_name.$name."</h3>
			<h3>".$text_tel.$tel."</h3>
			<h3>".$text_email.$email."</h3>
			<p>".$text_text.$text."</p>
			";
			$send = @mail($strTo,$strSubject,$strMessage,$strHeader);
			if($send)
			{
				echo "<script>alert('ส่งข้อความเรียบร้อยแล้ว');</script>.";
				echo '<script>window.parent.location = document.referrer;</script>';
			}
			else
			{
				echo "<script>alert('เกิดข้อผิดพลาดไม่สามารถส่งข้อความได้');</script>";
			}
		}
	}
?>
</body>
</html>