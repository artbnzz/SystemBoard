<?php
require("../../_db/connect.php");
$id=$_POST["booking_id"];
$name=$_POST["booking_name"];
$sql="SELECT * FROM booking_name WHERE name='$name'";
$result=mysqli_query($conn,$sql);
if(trim($_POST["booking_name"])==""){
	echo "<script>alert('กรุณาระบุชื่อเรื่องนัดหมาย');</script>";
}elseif(mysqli_num_rows($result)>0){
	echo "<script>alert('ชื่อเรื่องนัดหมายนี้มีอยู่แล้ว กรุณาเปลี่ยน');</script>";
}else{
$sql="INSERT INTO booking_name (id, name)VALUES(NULL, '$name')";
mysqli_query($conn,$sql);
echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
echo '<script>window.top.location.href = "../?page=managebooking"</script>';
}
?>