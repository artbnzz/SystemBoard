<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SYSTEMBOARD บริการรับซ่อมคอมพิวเตอร์ โน๊ตบุค อัพเกรดอุปกรณ์ ลงโปรแกรม</title>
  <link rel="stylesheet" href="css/bootstrap.css?v=<?php echo filemtime('css/bootstrap.css'); ?>">
  <link rel="stylesheet" href="css/font-awesome.min.css?v=<?php echo filemtime('css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="css/mycss.css?v=<?php echo filemtime('css/mycss.css'); ?>">
</head>
  <body>
    <nav class="my-navbar navbar sticky-top navbar-dark bg-black navbar-expand-lg">
      <a class="my-navbar-brand" href="../"><b>SYSTEMBOARD <a style="color:white;">ระบบหลังร้าน</a></b>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
  		<span class="navbar-toggler-icon"></span>
  	</button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="nav navbar-nav ml-auto my-nav">
          <li>
            <div class="dropdown">
              <h1 class="my-user"><i class="fa fa-user" aria-hidden="true"></i> ผู้ดูแล : <?=$_SESSION["login"]?></h1>
              <div id="myDropdown" class="dropdown-content">
                <a href="privacy-admin.html" class="dropdown-detail-admin"><i class="fa fa-address-card" aria-hidden="true"></i> ข้อมูลส่วนตัว</a>
                <a href="changepassword-admin.html" class="dropdown-detail-admin"><i class="fa fa-key" aria-hidden="true"></i> เปลี่ยนรหัสผ่าน</a>
                <a href="index.html" class="dropdown-detail-admin"><i class="fa fa-sign-out" aria-hidden="true"></i> ออกจากระบบ</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <div class="my-head-login">
      <div class="container">
        <p>ระบบหลังร้าน</p>
      </div>
    </div>
    </div>
    <div class="my-content">
      <div class="container">
        <div class="my-main-border">
          <div class="my-main">
            <div class="row">
              <div class="col-sm-3" style="padding:0;">
                <a href="../admin" class="admin-button-active"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ตรวจสอบนัดหมาย</a>
                <a href="../admin?page=update" class="admin-button"><i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ</a>
				<a href="../admin?page=managebooking" class="admin-button"><i class="fa fa-tasks"></i> ระบบนัดหมาย</a>
				<a href="../admin?page=member" class="admin-button"><i class="fa fa-users"></i> จัดการสมาชิก</a>
                <a href="../admin?page=portfolio" class="admin-button"><i class="fa fa-pencil" aria-hidden="true"></i> จัดการผลงาน</a>
              </div>
              <div class="col-sm-9">
                <div class="panel-header">
					<div><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ตรวจสอบนัดหมาย 
					<div style="float:right;">
					<?php if(isset($_GET["page"])){ ?>
					<a <?php if($_GET["page"]=="daily"){?> style="outline:none;text-decoration:none;cursor:default;color:black;font-weight:bold;" <?php } else{ ?> href="?page=daily" <?php } ?>>วันนี้</a>
					&nbsp;<a <?php if($_GET["page"]=='weekly'){?> style="outline:none;text-decoration:none;cursor:default;color:black;font-weight:bold;" <?php } else{ ?> href="?page=weekly" <?php } ?>>สัปดาห์นี้</a>
					&nbsp;<a <?php if($_GET["page"]=='monthly'){?> style="outline:none;text-decoration:none;cursor:default;color:black;font-weight:bold;" <?php } else{ ?> href="?page=monthly" <?php } ?>>เดือนนี้</a>
					&nbsp;<a <?php if($_GET["page"]=='yearly'){?> style="outline:none;text-decoration:none;cursor:default;color:black;font-weight:bold;" <?php } else{ ?> href="?page=yearly" <?php } ?> >ปีนี้</a>
					&nbsp;<a href="../admin">ทั้งหมด</a></div></div>
					<?php }
					else{?>
					<a href="?page=daily">วันนี้</a>
					&nbsp;<a href="?page=weekly">สัปดาห์นี้</a>
					&nbsp;<a href="?page=monthly">เดือนนี้</a>
					&nbsp;<a href="?page=yearly">ปีนี้</a>
					&nbsp;<a style="outline:none;text-decoration:none;cursor:default;color:black;font-weight:bold;">ทั้งหมด</a></div></div>
					<?php } ?>
				</div>
				<?php
				if(isset($_GET["page"])){
				if($_GET["page"]=="daily"){?>
				<div class="panel-text">
                  <div class="row">
                    <div class="col-sm-12">
					<?php
					require("../_db/connect.php");
					require("../_function/dateconvert.php");
					$daily=date("Y-m-d");
					$sql="SELECT COUNT(*) AS total FROM booking WHERE date='$daily'";
					$result = mysqli_query($conn, $sql);
					$count=0;
					$row = mysqli_fetch_assoc($result);
					$n=$row["total"];
					$rpp=4;
					if(isset($_POST["process"]))
					{
					if(trim($_POST["process"])=="DELETE")
						{
								$id=$_POST["id"];
								$sql_delete="SELECT * FROM booking WHERE id='$id'";
								$result_delete=mysqli_query($conn,$sql_delete);
								$row_delete=mysqli_fetch_assoc($result_delete);
								$booking_deleteq=explode(",",$row_delete["check"]);
								$booking_delete=implode(",",$booking_deleteq);
								$sql5="SELECT * FROM booking_name WHERE id in (".$booking_delete.")";
								$result5=mysqli_query($conn,$sql5);
								while ($row5=mysqli_fetch_assoc($result5)) {
								$sql6="UPDATE booking_name SET count='".($row5["count"]-1)."' WHERE id='".$row5["id"]."'";
								mysqli_query($conn,$sql6);
								}
								$sql="DELETE FROM booking WHERE id='$id'";
								mysqli_query($conn, $sql);
								echo "<script>alert('ลบแล้ว');</script>";
								echo '<script>window.parent.location = document.referrer;</script>';
						}
					}
					$max=ceil($n/$rpp);
					if(isset($_GET["p"])){
						$p=$_GET["p"];
						if($_GET["p"]>$max){
							echo "<div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>";
						}
					}
					else $p=1;
					$start = ($p-1)*$rpp;
					$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
					FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE date='$daily' ORDER BY `c`.`date` ASC LIMIT $start , $rpp";
					$result=mysqli_query($conn,$sql);
					if($n==0 && !isset($_GET["p"])){ ?>
						<div class="col-sm-12"><br><br><br><br><br><br><center><h3>ไม่มีรายการนัดหมายในวันนี้</h3></center><br><br><br><br><br><br></div>
					<?php }else{	
					while($row=mysqli_fetch_assoc($result)){
								$booking_name_check=explode("," ,$row["check"]);
								$check=implode(",",$booking_name_check);
								$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
								$result5=mysqli_query($conn,$sql5);
								$booking_name_array = array();
								while ($row5=mysqli_fetch_array($result5)) {
									$booking_name_array[] = $row5["name"];
								}
								$booking_name = implode('  ', $booking_name_array);
					?>
                    <table cellpadding="5" cellspacing="0" width="100%" class="table-control">
                      <tbody>
                        <tr>
                          <th style="width:10%;">ID</th>
                          <th style="width:20%;">วันที่</th>
                          <th style="width:15%;">ชื่อ-นามสกุล</th>
                          <th style="width:10%;">เบอร์โทร</th>
                          <th style="width:40%;">เรื่องที่นัดหมาย</th>
						  <th style="width:5%;"></th>
                        </tr>
                        <tr>
                          <td><a href="../print.php?pid=<?=$row["id"]?>" style="color:rgb(0, 0, 0);" target="_blank">#<?=$row["id"]?></a></td>
                          <td><?=dateConvert($row["date"])?> <br><?=$row["name"]?></td>
                          <td><?=$row["accounts_name"]?>&nbsp;<?=$row["accounts_lastname"]?></td>
                          <td><?=$row["tel"]?></td>
                          <td style="word-wrap: break-word;"><?=$booking_name?></td>
						  <td style="text-align:center;"><input type="button" value="ลบ" <?php if($row["status"]<6){?>style="border-radius:3px;background-color:rgb(224, 73, 73);color:white;cursor:pointer;"<?php }else{?>style="border-radius:3px;background-color:rgb(255, 198, 198);color:white;cursor:default;"<?php }?> onclick="deleteData('<?=$row["id"]?>');"<?php if($row["status"]>=6){?>disabled<?php } ?>></td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <ol class="my-progress" my-steps="6" style="font-size:12px;">
		                        <li <?php if($row["status"] >= 1){ ?>class="finished" <?php } ?>>
		                          <span>เปิดใบจอง</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 2){ ?>class="finished" <?php } ?>>
		                          <span>ส่งเครื่องแล้ว</span>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 3){ ?>class="finished" <?php } ?>>
		                          <span>กำลังดำเนินการ</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 4){ ?>class="finished" <?php } ?>>
		                          <span>ดำเนินการแล้ว</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 5){ ?>class="finished" <?php } ?>>
		                          <span>ชำระเงิน</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 6){ ?>class="finished" <?php } ?>>
		                           <span>เสร็จสิ้น</span>
		                           <i></i>
		                         </li>
                            </ol>
                          </td>
                        </tr>
                      </tbody>
                    </table>
				<?php 
				}
				}
				if($n>4 && $_GET["page"]=="daily"){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["p"]))
									{
										if($_GET["p"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?page=daily&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
								    }
									else{
										if($n<=3){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }
										elseif($i==1){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php	}
										else{ ?>
										<a href="?page=daily&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php
				}
				if($n!=0 && $_GET["page"]=="daily"){?>
						<div class="col-sm-12" style="padding-bottom:10px;">
						<br>
						<center><a href="../print.php?mode=dailyprint" target="_blank" class="my-btn-submit"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์นัดหมายวันนี้</a></center>
						</div>

				<?php
				}
				}
				if($_GET["page"]=="weekly"){?>
				<div class="panel-text">
                  <div class="row">
                    <div class="col-sm-12">
					<?php
					require("../_db/connect.php");
					require("../_function/dateconvert.php");
					$daily=date("Y-m-d");
					$sql="SELECT COUNT(*) AS total FROM booking WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW())";
					$result = mysqli_query($conn, $sql);
					$count=0;
					$row = mysqli_fetch_assoc($result);
					$n=$row["total"];
					$rpp=4;
					if(isset($_POST["process"]))
					{
					if(trim($_POST["process"])=="DELETE")
						{
								$id=$_POST["id"];
								$sql_delete="SELECT * FROM booking WHERE id='$id'";
								$result_delete=mysqli_query($conn,$sql_delete);
								$row_delete=mysqli_fetch_assoc($result_delete);
								$booking_deleteq=explode(",",$row_delete["check"]);
								$booking_delete=implode(",",$booking_deleteq);
								$sql5="SELECT * FROM booking_name WHERE id in (".$booking_delete.")";
								$result5=mysqli_query($conn,$sql5);
								while ($row5=mysqli_fetch_assoc($result5)) {
								$sql6="UPDATE booking_name SET count='".($row5["count"]-1)."' WHERE id='".$row5["id"]."'";
								mysqli_query($conn,$sql6);
								}
								$sql="DELETE FROM booking WHERE id='$id'";
								mysqli_query($conn, $sql);
								echo "<script>alert('ลบแล้ว');</script>";
								echo '<script>window.parent.location = document.referrer;</script>';
						}
					}
					$max=ceil($n/$rpp);
					if(isset($_GET["p"])){
						$p=$_GET["p"];
						if($_GET["p"]>$max){
							echo "<div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>";
						}
					}
					else $p=1;
					$start = ($p-1)*$rpp;
					$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
					FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW()) ORDER BY `c`.`date` ASC LIMIT $start , $rpp";
					$result=mysqli_query($conn,$sql);
					if($n==0 && !isset($_GET["p"])){ ?>
						<div class="col-sm-12"><br><br><br><br><br><br><center><h3>ไม่มีรายการนัดหมายในสัปดาห์นี้</h3></center><br><br><br><br><br><br></div>
					<?php }else{
					while($row=mysqli_fetch_assoc($result)){
								$booking_name_check=explode("," ,$row["check"]);
								$check=implode(",",$booking_name_check);
								$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
								$result5=mysqli_query($conn,$sql5);
								$booking_name_array = array();
								while ($row5=mysqli_fetch_array($result5)) {
									$booking_name_array[] = $row5["name"];
								}
								$booking_name = implode('  ', $booking_name_array);
					?>
                    <table cellpadding="5" cellspacing="0" width="100%" class="table-control">
                      <tbody>
                        <tr>
                          <th style="width:10%;">ID</th>
                          <th style="width:20%;">วันที่</th>
                          <th style="width:15%;">ชื่อ-นามสกุล</th>
                          <th style="width:10%;">เบอร์โทร</th>
                          <th style="width:40%;">เรื่องที่นัดหมาย</th>
						  <th style="width:5%;"></th>
                        </tr>
						<tr>
                          <td><a href="../print.php?pid=<?=$row["id"]?>" style="color:rgb(0, 0, 0);" target="_blank">#<?=$row["id"]?></a></td>
                          <td><?=dateConvert($row["date"])?> <br><?=$row["name"]?></td>
                          <td><?=$row["accounts_name"]?>&nbsp;<?=$row["accounts_lastname"]?></td>
                          <td><?=$row["tel"]?></td>
                          <td><?=$booking_name?></td>
						  <td><input type="button" value="ลบ" <?php if($row["status"]<6){?>style="border-radius:3px;background-color:rgb(224, 73, 73);color:white;cursor:pointer;"<?php }else{?>style="border-radius:3px;background-color:rgb(255, 198, 198);color:white;cursor:default;"<?php }?> onclick="deleteData('<?=$row["id"]?>');"<?php if($row["status"]>=6){?>disabled<?php } ?>></td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <ol class="my-progress" my-steps="6" style="font-size:12px;">
		                        <li <?php if($row["status"] >= 1){ ?>class="finished" <?php } ?>>
		                          <span>เปิดใบจอง</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 2){ ?>class="finished" <?php } ?>>
		                          <span>ส่งเครื่องแล้ว</span>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 3){ ?>class="finished" <?php } ?>>
		                          <span>กำลังดำเนินการ</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 4){ ?>class="finished" <?php } ?>>
		                          <span>ดำเนินการแล้ว</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 5){ ?>class="finished" <?php } ?>>
		                          <span>ชำระเงิน</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 6){ ?>class="finished" <?php } ?>>
		                           <span>เสร็จสิ้น</span>
		                           <i></i>
		                         </li>
                            </ol>
                          </td>
                        </tr>
                      </tbody>
                    </table>
				<?php 
				}
				}
				if($n>4 && $_GET["page"]=="weekly"){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["p"]))
									{
										if($_GET["p"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?page=weekly&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
								    }
									else{
										if($n<=3){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }
										elseif($i==1){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php	}
										else{ ?>
										<a href="?page=weekly&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php
				}
				if($n!=0 && $_GET["page"]=="weekly"){?>
						<div class="col-sm-12" style="padding-bottom:10px;">
						<br>
						<center><a href="../print.php?mode=weeklyprint" target="_blank" class="my-btn-submit"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์นัดหมายสัปดาห์นี้</a></center>
						</div>

				<?php
				}
				}
				if($_GET["page"]=="monthly"){?>
				<div class="panel-text">
                  <div class="row">
                    <div class="col-sm-12">
					<?php
					require("../_db/connect.php");
					require("../_function/dateconvert.php");
					$daily=date("Y-m-d");
					$sql="SELECT COUNT(*) AS total FROM booking WHERE YEAR(date) = YEAR(NOW()) AND MONTH(date)=MONTH(NOW())";
					$result = mysqli_query($conn, $sql);
					$count=0;
					$row = mysqli_fetch_assoc($result);
					$n=$row["total"];
					$rpp=4;
					if(isset($_POST["process"]))
					{
					if(trim($_POST["process"])=="DELETE")
						{
								$id=$_POST["id"];
								$sql_delete="SELECT * FROM booking WHERE id='$id'";
								$result_delete=mysqli_query($conn,$sql_delete);
								$row_delete=mysqli_fetch_assoc($result_delete);
								$booking_deleteq=explode(",",$row_delete["check"]);
								$booking_delete=implode(",",$booking_deleteq);
								$sql5="SELECT * FROM booking_name WHERE id in (".$booking_delete.")";
								$result5=mysqli_query($conn,$sql5);
								while ($row5=mysqli_fetch_assoc($result5)) {
								$sql6="UPDATE booking_name SET count='".($row5["count"]-1)."' WHERE id='".$row5["id"]."'";
								mysqli_query($conn,$sql6);
								}
								$sql="DELETE FROM booking WHERE id='$id'";
								mysqli_query($conn, $sql);
								echo "<script>alert('ลบแล้ว');</script>";
								echo '<script>window.parent.location = document.referrer;</script>';
						}
					}
					$max=ceil($n/$rpp);
					if(isset($_GET["p"])){
						$p=$_GET["p"];
						if($_GET["p"]>$max){
							echo "<div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>";
						}
					}
					else $p=1;
					$start = ($p-1)*$rpp;
					$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
					FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE YEAR(date) = YEAR(NOW()) AND MONTH(date)=MONTH(NOW())
					ORDER BY `c`.`date` ASC LIMIT $start , $rpp";
					$result=mysqli_query($conn,$sql);
					if($n==0 && !isset($_GET["p"])){ ?>
						<div class="col-sm-12"><br><br><br><br><br><br><center><h3>ไม่มีรายการนัดหมายเดือนนี้</h3></center><br><br><br><br><br><br></div>
					<?php }else{
					while($row=mysqli_fetch_assoc($result)){
								$booking_name_check=explode("," ,$row["check"]);
								$check=implode(",",$booking_name_check);
								$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
								$result5=mysqli_query($conn,$sql5);
								$booking_name_array = array();
								while ($row5=mysqli_fetch_array($result5)) {
									$booking_name_array[] = $row5["name"];
								}
								$booking_name = implode('  ', $booking_name_array);
					?>
                    <table cellpadding="5" cellspacing="0" width="100%" class="table-control">
                      <tbody>
                        <tr>
                          <th style="width:10%;">ID</th>
                          <th style="width:20%;">วันที่</th>
                          <th style="width:15%;">ชื่อ-นามสกุล</th>
                          <th style="width:10%;">เบอร์โทร</th>
                          <th style="width:40%;">เรื่องที่นัดหมาย</th>
						  <th style="width:5%;"></th>
                        </tr>
                        <tr>
                          <td><a href="../print.php?pid=<?=$row["id"]?>" style="color:rgb(0, 0, 0);" target="_blank">#<?=$row["id"]?></a></td>
                          <td><?=dateConvert($row["date"])?> <br><?=$row["name"]?></td>
                          <td><?=$row["accounts_name"]?>&nbsp;<?=$row["accounts_lastname"]?></td>
                          <td><?=$row["tel"]?></td>
                          <td><?=$booking_name?></td>
						  <td><input type="button" value="ลบ" <?php if($row["status"]<6){?>style="border-radius:3px;background-color:rgb(224, 73, 73);color:white;cursor:pointer;"<?php }else{?>style="border-radius:3px;background-color:rgb(255, 198, 198);color:white;cursor:default;"<?php }?> onclick="deleteData('<?=$row["id"]?>');"<?php if($row["status"]>=6){?>disabled<?php } ?>></td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <ol class="my-progress" my-steps="6" style="font-size:12px;">
		                        <li <?php if($row["status"] >= 1){ ?>class="finished" <?php } ?>>
		                          <span>เปิดใบจอง</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 2){ ?>class="finished" <?php } ?>>
		                          <span>ส่งเครื่องแล้ว</span>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 3){ ?>class="finished" <?php } ?>>
		                          <span>กำลังดำเนินการ</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 4){ ?>class="finished" <?php } ?>>
		                          <span>ดำเนินการแล้ว</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 5){ ?>class="finished" <?php } ?>>
		                          <span>ชำระเงิน</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 6){ ?>class="finished" <?php } ?>>
		                           <span>เสร็จสิ้น</span>
		                           <i></i>
		                         </li>
                            </ol>
                          </td>
                        </tr>
                      </tbody>
                    </table>
				<?php 
				}
				}
				if($n>4 && $_GET["page"]=="monthly"){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["p"]))
									{
										if($_GET["p"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?page=monthly&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
								    }
									else{
										if($n<=3){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }
										elseif($i==1){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php	}
										else{ ?>
										<a href="?page=monthly&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php
				}
				if($n!=0 && $_GET["page"]=="monthly"){?>
						<div class="col-sm-12" style="padding-bottom:10px;">
						<br>
						<center><a href="../print.php?mode=monthlyprint" target="_blank" class="my-btn-submit"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์นัดหมายเดือนนี้</a></center>
						</div>
				<?php
				}
				}
				if($_GET["page"]=="yearly"){?>
				<div class="panel-text">
                  <div class="row">
                    <div class="col-sm-12">
					<?php
					require("../_db/connect.php");
					require("../_function/dateconvert.php");
					$daily=date("Y-m-d");
					$sql="SELECT COUNT(*) AS total FROM booking WHERE YEAR(date) = YEAR(NOW())";
					$result = mysqli_query($conn, $sql);
					$count=0;
					$row = mysqli_fetch_assoc($result);
					$n=$row["total"];
					$rpp=4;
					if(isset($_POST["process"]))
					{
					if(trim($_POST["process"])=="DELETE")
						{
								$id=$_POST["id"];
								$sql_delete="SELECT * FROM booking WHERE id='$id'";
								$result_delete=mysqli_query($conn,$sql_delete);
								$row_delete=mysqli_fetch_assoc($result_delete);
								$booking_deleteq=explode(",",$row_delete["check"]);
								$booking_delete=implode(",",$booking_deleteq);
								$sql5="SELECT * FROM booking_name WHERE id in (".$booking_delete.")";
								$result5=mysqli_query($conn,$sql5);
								while ($row5=mysqli_fetch_assoc($result5)) {
								$sql6="UPDATE booking_name SET count='".($row5["count"]-1)."' WHERE id='".$row5["id"]."'";
								mysqli_query($conn,$sql6);
								}
								$sql="DELETE FROM booking WHERE id='$id'";
								mysqli_query($conn, $sql);
								echo "<script>alert('ลบแล้ว');</script>";
								echo '<script>window.parent.location = document.referrer;</script>';
						}
					}
					$max=ceil($n/$rpp);
					if(isset($_GET["p"])){
						$p=$_GET["p"];
						if($_GET["p"]>$max){
							echo "<div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>";
						}
					}
					else $p=1;
					$start = ($p-1)*$rpp;
					$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
					FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE YEAR(date) = YEAR(NOW())
					ORDER BY `c`.`date` ASC LIMIT $start , $rpp";
					$result=mysqli_query($conn,$sql);
					if($n==0 && !isset($_GET["p"])){ ?>
						<div class="col-sm-12"><br><br><br><br><br><br><center><h3>ไม่มีรายการนัดหมายปีนี้</h3></center><br><br><br><br><br><br></div>
					<?php }else{
					while($row=mysqli_fetch_assoc($result)){
								$booking_name_check=explode("," ,$row["check"]);
								$check=implode(",",$booking_name_check);
								$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
								$result5=mysqli_query($conn,$sql5);
								$booking_name_array = array();
								while ($row5=mysqli_fetch_array($result5)) {
									$booking_name_array[] = $row5["name"];
								}
								$booking_name = implode('  ', $booking_name_array);
					?>
                    <table cellpadding="5" cellspacing="0" width="100%" class="table-control">
                      <tbody>
                        <tr>
                          <th style="width:10%;">ID</th>
                          <th style="width:20%;">วันที่</th>
                          <th style="width:15%;">ชื่อ-นามสกุล</th>
                          <th style="width:10%;">เบอร์โทร</th>
                          <th style="width:40%;">เรื่องที่นัดหมาย</th>
						  <th style="width:5%;"></th>
                        </tr>
                        <tr>
                          <td><a href="../print.php?pid=<?=$row["id"]?>" style="color:rgb(0, 0, 0);" target="_blank">#<?=$row["id"]?></a></td>
                          <td><?=dateConvert($row["date"])?> <br><?=$row["name"]?></td>
                          <td><?=$row["accounts_name"]?>&nbsp;<?=$row["accounts_lastname"]?></td>
                          <td><?=$row["tel"]?></td>
                          <td><?=$booking_name?></td>
						  <td><input type="button" value="ลบ" <?php if($row["status"]<6){?>style="border-radius:3px;background-color:rgb(224, 73, 73);color:white;cursor:pointer;"<?php }else{?>style="border-radius:3px;background-color:rgb(255, 198, 198);color:white;cursor:default;"<?php }?> onclick="deleteData('<?=$row["id"]?>');"<?php if($row["status"]>=6){?>disabled<?php } ?>></td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <ol class="my-progress" my-steps="6" style="font-size:12px;">
		                        <li <?php if($row["status"] >= 1){ ?>class="finished" <?php } ?>>
		                          <span>เปิดใบจอง</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 2){ ?>class="finished" <?php } ?>>
		                          <span>ส่งเครื่องแล้ว</span>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 3){ ?>class="finished" <?php } ?>>
		                          <span>กำลังดำเนินการ</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 4){ ?>class="finished" <?php } ?>>
		                          <span>ดำเนินการแล้ว</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 5){ ?>class="finished" <?php } ?>>
		                          <span>ชำระเงิน</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 6){ ?>class="finished" <?php } ?>>
		                           <span>เสร็จสิ้น</span>
		                           <i></i>
		                         </li>
                            </ol>
                          </td>
                        </tr>
                      </tbody>
                    </table>
				<?php 
				}
				}
				if($n>4 && $_GET["page"]=="yearly"){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["p"]))
									{
										if($_GET["p"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?page=yearly&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
								    }
									else{
										if($n<=3){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }
										elseif($i==1){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php	}
										else{ ?>
										<a href="?page=yearly&p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php }
				}
				if($n!=0 && $_GET["page"]=="yearly"){?>
						<div class="col-sm-12" style="padding-bottom:10px;">
						<br>
						<center><a href="../print.php?mode=yearlyprint" target="_blank" class="my-btn-submit"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์นัดหมายปีนี้</a></center>
						</div>

				<?php
				}
				}
				else{
				?>
                <div class="panel-text">
                  <div class="row">
                    <div class="col-sm-12">
					<?php
					require("../_db/connect.php");
					require("../_function/dateconvert.php");
					$sql="SELECT COUNT(*) AS total FROM booking;";
					$result = mysqli_query($conn, $sql);
					$count=0;
					$row = mysqli_fetch_assoc($result);
					$n=$row["total"];
					$rpp=4;
					if(isset($_POST["process"]))
					{
					if(trim($_POST["process"])=="DELETE")
						{
								$id=$_POST["id"];
								$sql_delete="SELECT * FROM booking WHERE id='$id'";
								$result_delete=mysqli_query($conn,$sql_delete);
								$row_delete=mysqli_fetch_assoc($result_delete);
								$booking_deleteq=explode(",",$row_delete["check"]);
								$booking_delete=implode(",",$booking_deleteq);
								$sql5="SELECT * FROM booking_name WHERE id in (".$booking_delete.")";
								$result5=mysqli_query($conn,$sql5);
								while ($row5=mysqli_fetch_assoc($result5)) {
								$sql6="UPDATE booking_name SET count='".($row5["count"]-1)."' WHERE id='".$row5["id"]."'";
								mysqli_query($conn,$sql6);
								}
								$sql="DELETE FROM booking WHERE id='$id'";
								mysqli_query($conn, $sql);
								echo "<script>alert('ลบแล้ว');</script>";
								echo '<script>window.parent.location = document.referrer;</script>';
						}
					}
					$max=ceil($n/$rpp);
					if(isset($_GET["p"])){
						$p=$_GET["p"];
						if($_GET["p"]>$max){
							echo "<div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>";
						}
					}
					else $p=1;
					$start = ($p-1)*$rpp;
					$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
					FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) 
					ORDER BY `c`.`date` ASC LIMIT $start , $rpp";
					$result = mysqli_query($conn, $sql);
					if($n==0 && !isset($_GET["p"])){ ?>
						<div class="col-sm-12"><br><br><br><br><br><br><center><h3>ไม่มีรายการนัดหมาย</h3></center><br><br><br><br><br><br></div>
					<?php }else{
					while($row=mysqli_fetch_assoc($result)){
								$booking_name_check=explode("," ,$row["check"]);
								$check=implode(",",$booking_name_check);
								$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
								$result5=mysqli_query($conn,$sql5);
								$booking_name_array = array();
								while ($row5=mysqli_fetch_array($result5)) {
									$booking_name_array[] = $row5["name"];
								}
								$booking_name = implode('  ', $booking_name_array);
					?>
                    <table cellpadding="5" cellspacing="0" width="100%" class="table-control">
                      <tbody>
                        <tr>
                          <th style="width:10%;">ID</th>
                          <th style="width:20%;">วันที่</th>
                          <th style="width:15%;">ชื่อ-นามสกุล</th>
                          <th style="width:10%;">เบอร์โทร</th>
                          <th style="width:40%;">เรื่องที่นัดหมาย</th>
						  <th style="width:5%;"></th>
                        </tr>
                        <tr>
                          <td><a href="../print.php?pid=<?=$row["id"]?>" style="color:rgb(0, 0, 0);" target="_blank">#<?=$row["id"]?></a></td>
                          <td><?=dateConvert($row["date"])?> <br><?=$row["name"]?></td>
                          <td><?=$row["accounts_name"]?>&nbsp;<?=$row["accounts_lastname"]?></td>
                          <td><?=$row["tel"]?></td>
                          <td><?=$booking_name?></td>
						  <td><input type="button" value="ลบ" <?php if($row["status"]<6){?>style="border-radius:3px;background-color:rgb(224, 73, 73);color:white;cursor:pointer;"<?php }else{?>style="border-radius:3px;background-color:rgb(255, 198, 198);color:white;cursor:default;"<?php }?> onclick="deleteData('<?=$row["id"]?>');"<?php if($row["status"]>=6){?>disabled<?php } ?>></td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <ol class="my-progress" my-steps="6" style="font-size:12px;">
		                        <li <?php if($row["status"] >= 1){ ?>class="finished" <?php } ?>>
		                          <span>เปิดใบจอง</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 2){ ?>class="finished" <?php } ?>>
		                          <span>ส่งเครื่องแล้ว</span>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 3){ ?>class="finished" <?php } ?>>
		                          <span>กำลังดำเนินการ</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 4){ ?>class="finished" <?php } ?>>
		                          <span>ดำเนินการแล้ว</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 5){ ?>class="finished" <?php } ?>>
		                          <span>ชำระเงิน</span>
		                          <i></i>
		                        </li><!--
		                        --><li <?php if($row["status"] >= 6){ ?>class="finished" <?php } ?>>
		                           <span>เสร็จสิ้น</span>
		                           <i></i>
		                         </li>
                            </ol>
                          </td>
                        </tr>
                      </tbody>
                    </table>
				<?php }} 
				if($n>4 && empty($_GET["page"])){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["p"]))
									{
										if($_GET["p"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
								    }
									else{
										if($n<=3){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }
										elseif($i==1){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php	}
										else{ ?>
										<a href="?p=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php }?>
				<?php if($n!=0 && empty($_GET["page"])){?>
						<div class="col-sm-12" style="padding-bottom:10px;">
						<br>
						<center><a href="../print.php?mode=allprint" target="_blank" class="my-btn-submit"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์นัดหมายทั้งหมด</a></center>
						</div>
				<?php
				}
				}
				?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
	<form method="post" action="" name="form">
		<input type="hidden" name="process">
		<input type="hidden" name="id">
	</form>
      <div class="footer">
        <div class="container">
          <div class="row">
            <div class="col-sm-8">
              <font class="footer-text">
                <h4>ร้าน Systemboard</h4>
                <br>
                <p>พาต้าปิ่นเกล้า ชั้น 4 ห้อง 5 แขวงบางยี่ขัน เขตบางพลัด กรุงเทพฯ 10700</p>
                <p><i class="fa fa-phone" aria-hidden="true"></i> 086-661-2181</p>
                <p><i class="fa fa-globe" aria-hidden="true"></i> www.systemboard.in.th</p>
              </font>
            </div>
            <div class="col-sm-4 my-navbar-brand icon-footer">
              <p>SYSTEMBOARD
                <p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 footer-end">
        <div class="container">
          Copyright © 2018 SYSTEMBOARD All Right Reserved.
        </div>
      </div>
      <script src="js/myjs.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/jquery-3.2.1.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script>
		function deleteData(pid)
		{
		if(confirm('คุณต้องการลบ ใบนัดหมายเลขที่ : '+pid+' ?'))
			{
				document.form.process.value="DELETE";
				document.form.id.value=pid;
				document.form.submit();
			}
		}
        $(function() {
          $("[data-toggle='tooltip']").tooltip()
        })
        $("input[type='checkbox']").change(function(){
            if($("#progress1").is(":checked")){
                $( "#progress-control-1" ).addClass( "finished" );
            }else{
                $( "#progress-control-1" ).removeClass( "finished" );
            }
            if($("#progress2").is(":checked")){
                $( "#progress-control-2" ).addClass( "finished" );
            }else{
                $( "#progress-control-2" ).removeClass( "finished" );
            }
            if($("#progress3").is(":checked")){
                $( "#progress-control-3" ).addClass( "finished" );
            }else{
                $( "#progress-control-3" ).removeClass( "finished" );
            }
            if($("#progress4").is(":checked")){
                $( "#progress-control-4" ).addClass( "finished" );
            }else{
                $( "#progress-control-4" ).removeClass( "finished" );
            }
            if($("#progress5").is(":checked")){
                $( "#progress-control-5" ).addClass( "finished" );
            }else{
                $( "#progress-control-5" ).removeClass( "finished" );
            }
            if($("#progress6").is(":checked")){
                $( "#progress-control-6" ).addClass( "finished" );
            }else{
                $( "#progress-control-6" ).removeClass( "finished" );
            }
        });
      </script>
  </body>

</html>