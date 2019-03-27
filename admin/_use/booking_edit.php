<?php
require("../../_db/connect.php");
$id=$_POST["booking_id"];
$name=$_POST["booking_name"];
$sql="SELECT * FROM booking_name WHERE name='$name'";
$result=mysqli_query($conn,$sql);
$sql2="SELECT * FROM booking_name WHERE id='$id'";
$result2=mysqli_query($conn,$sql2);
$row=mysqli_fetch_assoc($result2);
if(trim($_POST["booking_name"])==""){
	echo "<script>alert('กรุณาระบุชื่อเรื่องนัดหมาย');</script>";
}elseif($name==$row["name"]){
	echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
	echo '<script>window.top.location.href = "../?page=managebooking"</script>';
}elseif(mysqli_num_rows($result)>0){
	echo "<script>alert('ชื่อเรื่องนัดหมายนี้มีอยู่แล้ว กรุณาเปลี่ยน');</script>";
}else{
$sql="UPDATE booking_name SET name='$name' WHERE id='$id'";
mysqli_query($conn,$sql);
echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
echo '<script>window.top.location.href = "../?page=managebooking"</script>';
}
?>