<?php
					require("../../_db/connect.php");
					  if(isset($_POST["task"])){
						if(!empty($_FILES['image']['tmp_name'])) {
				    	$image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
						}
						$image_update="";
						if(isset($image)){if(trim($image)!="") $image_update = ", image='$image'";}
					  if(trim($_POST["task"])=="ADD")
				      {
						if(trim($_POST["port_name"]) == ""){
							echo "<script>alert('กรุณาระบุชื่อผลงาน');</script>";
						}
						elseif(empty($_FILES['image']['tmp_name'])) {
							echo "<script>alert('กรุณาเลือกรูปผลงาน');</script>";
						}else{
						$port_name=$_POST["port_name"];
						$sql="INSERT INTO portfolio (id, detail, image) VALUES (NULL,'$port_name','$image')";
						mysqli_query($conn, $sql);
				  		echo "<script>alert('เพิ่มผลงานสำเร็จ');</script>";
						echo '<script>window.top.location.href = "../?page=portfolio"</script>';
						}
					  }
					  if(trim($_POST["task"])=="UPDATE")
				      {
						if(trim($_POST["port_name"]) == ""){
							echo "<script>alert('กรุณาระบุชื่อผลงาน');</script>";
						}else{
						$port_name=$_POST["port_name"];
						$port_id=$_POST["id"];
						$sql="UPDATE portfolio set id='$port_id',detail='$port_name' $image_update where id='$port_id';";
						mysqli_query($conn, $sql);
				  		echo "<script>alert('อัพเดตผลงานแล้ว');</script>";
						echo '<script>window.top.location.href = "../?page=portfolio"</script>';
						}
					  }
					  }
?>