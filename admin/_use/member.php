<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SYSTEMBOARD บริการรับซ่อมคอมพิวเตอร์ โน๊ตบุค อัพเกรดอุปกรณ์ ลงโปรแกรม</title>
  <link rel="stylesheet" href="css/bootstrap.css?v=<?php echo filemtime('css/bootstrap.css'); ?>">
  <link rel="stylesheet" href="css/font-awesome.min.css?v=<?php echo filemtime('css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="css/mycss.css?v=<?php echo filemtime('css/mycss.css'); ?>">
	<script language="JavaScript">
	function chkNumber(ele)
	{
	var vchar = String.fromCharCode(event.keyCode);
	if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
	ele.onKeyPress=vchar;
	}
	</script>
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
                <a href="../admin" class="admin-button"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ตรวจสอบนัดหมาย</a>
                <a href="../admin?page=update" class="admin-button"><i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ</a>
				<a href="../admin?page=managebooking" class="admin-button"><i class="fa fa-tasks"></i> ระบบนัดหมาย</a>
				<a href="../admin?page=member" class="admin-button-active"><i class="fa fa-users"></i> จัดการสมาชิก</a>
                <a href="../admin?page=portfolio" class="admin-button"><i class="fa fa-pencil" aria-hidden="true"></i> จัดการผลงาน</a>
              </div>
			  <?php 
			  if(isset($_GET["page"]) && !isset($_GET["edit_id"])){
			  if($_GET["page"]=="member"){
				  require("../_db/connect.php");
				  $sql="SELECT COUNT(*) AS total FROM accounts";
				  $result = mysqli_query($conn, $sql);
				  $count=0;
				  $row = mysqli_fetch_assoc($result);
				  $n=$row["total"];
				  $rpp=10;
				  $max=ceil($n/$rpp);
				  if(isset($_GET["mp"]))
				  	$p=$_GET["mp"];
				  else $p=1;
			      $start = ($p-1)*$rpp;
				  $count=1;
				  if(isset($_GET["mp"])){
				  $Page = $_GET["mp"];
				  }
				  if(!isset($_GET["mp"])){
			    	$Page=1;
				  }
				  if($Page > 1){
				    $count = ($rpp * ($Page-1)) + 1;
				  }
				?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-users"></i> จัดการสมาชิก 
                </div>
                <div class="panel-text">
                  <div class="row">
				  <?php
					if(isset($_GET["mp"])){
					$p=$_GET["mp"];
					if($_GET["mp"]>$max){
					echo "<div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>";
					}
					}
				  ?>
				  <?php
				  if(!isset($_GET["mp"]) || $_GET["mp"]<=$max){
				  ?>
                  <div class="col-sm-12">
				  <h5 style="padding-top:10px;"><i class="fa fa-cog"></i> จัดการสมาชิก</h5>
				  <style>
				  td, th {
				  text-align:left;
				  word-wrap: break-word;
				  border-bottom: 1px solid #ddd;
				  }
				  th{
				  padding-left:5px;
				  padding-right:5px;
				  padding-top:10px;
				  padding-bottom:10px;
				  }
				  td{
				  padding-left:5px;
				  padding-right:5px;
				  padding-top:20px;
				  padding-bottom:20px;
				  }
				  tr:nth-child(even) {background-color: #f2f2f2;}
				  </style>
				  <table cellspacing="0" width="100%" border="1" style="table-layout: fixed;border: 1px solid #ddd;">
				  <th style="width:5%;text-align:center !important;"></th>
				  <th style="width:15%;">ชื่อผู้ใช้</th>
				  <th style="width:20%;">ชื่อ-นามสกุล</th>
				  <th style="width:34%;">อีเมล์</th>
				  <th style="width:15%;">เบอร์โทร</th>
				  <th style="width:6%;"></th>
					<?php
					require("../_db/connect.php");
					$sql="SELECT * FROM accounts LIMIT $start,$rpp";
					$result=mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($result)){
					?>
					<tr>
					<td style="text-align:center;"><?=$count?></td>
					<td><?=$row["username"]?></td>
					<td><?=$row["name"]?> <?=$row["lastname"]?></td>
					<td><?=$row["email"]?></td>
					<td><?=$row["tel"]?></td>
					<td style="text-align:center;"><a href="?page=member&edit_id=<?=$row["id"]?>" class="my-btn-submit" style="padding:5px;padding-left:10px;padding-right:10px;"><i class="fa fa-pencil"></i></a></td>
					</tr>
					<?php 
					$count++;
					} ?>
				  </table>
				<?php 
				if(isset($_GET["page"])){
				if($_GET["page"]=="member"){?>
					<div class="col-sm-12">
					<center>
					<br>
					<a href="../print.php?mode=memberprint" target="_blank" class="my-btn-submit"><i class="fa fa-print"></i> พิมพ์สมาชิกทั้งหมด</a>
					<br><br>
					</center>
					</div>
				<?php
				if($n>10){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["mp"]))
									{
										if($_GET["mp"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?page=member&mp=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
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
										<a href="?page=member&mp=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
					<?php } } } ?>
                  </div>
				  <?php } ?>
                </div>
                </div>
              </div>
			  <?php } }?>
			  <?php 
			  //ส่วนแก้ไขข้อมูลสมาชิก
			  if(isset($_GET["page"]) && isset($_GET["edit_id"])){
			  if($_GET["page"]=="member"){
				require("../_db/connect.php");
				$id=$_GET["edit_id"];
				$sql="SELECT a.*,address.houseno,address.subarea,address.area,address.province,address.postalcode FROM accounts a INNER JOIN address ON (a.username=address.username)WHERE a.id='$id'";
				$result=mysqli_query($conn,$sql);
				$row=mysqli_fetch_assoc($result);
				if(mysqli_num_rows($result)<=0){
			  ?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-users"></i> จัดการสมาชิก <i class="fa fa-arrow-right"></i> ไม่พบหน้าที่คุณต้องการ
                </div>
			  <div class="panel-text">
              <div class="row" style="padding-top:10px;">
			  <div class='col-sm-12'><br><br><br><br><br><br><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center><br><br><br><br><br><br></div>
			  </div>
			  </div>
			  <?php
				}else{
			  ?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-users"></i> จัดการสมาชิก <i class="fa fa-arrow-right"></i> ข้อมูลสมาชิก
                </div>
				<form method="post" action="_use/memberedit.php" target="iframe_target" enctype="multipart/form-data">
				<input type="hidden" value="<?=$row["id"]?>" name="id">
				<?php if($row["status"]==$_SESSION["status"]){?>
				<input type="hidden" value="<?=$row["status"]?>" name="status">
				<?php }?>
                <div class="panel-text">
                  <div class="row" style="padding-top:10px;">
					<div class="col-sm-12">
					<center>
					<img src="data:image/jpeg;base64,<?=base64_encode($row["image"])?>" class="rounded-profile" id="preview" onerror="this.src ='img/icon-no-image.svg'">
					</center>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="username" class="head-from-text"><i class="fa fa-user" aria-hidden="true"></i> ชื่อผู้ใช้ :</label>
					<input id="username" name="username" type="text" class="my-from-control" placeholder="ระบุชื่อผู้ใช้" value="<?=$row["username"]?>" maxlength="100" disabled>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="status" class="head-from-text"><i class="fa fa-cogs" aria-hidden="true"></i> สถานะ :</label>
					<select id="status" name="status" class="my-from-control <?php if($row["username"]!=$_SESSION["login"]){?>input_disabled<?php }?>" disabled>
					  <option value="0"<?php if($row["status"]==0){?> selected <?php }?>>สมาชิกทั่วไป</option>
					  <option value="1"<?php if($row["status"]==1){?> selected <?php }?>>ผู้ดูแล</option>
					</select>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="profile_name" class="head-from-text"><i class="fa fa-user" aria-hidden="true"></i> ชื่อ :</label>
					<input id="profile_name" name="profile_name" type="text" class="my-from-control input_disabled" placeholder="ระบุชื่อ" value="<?=$row["name"]?>" maxlength="100" disabled>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="profile_lastname" class="head-from-text"><i class="fa fa-user" aria-hidden="true"></i> นามสกุล :</label>
					<input id="profile_lastname" name="profile_lastname" type="text" class="my-from-control input_disabled" placeholder="ระบุนามสกุล" value="<?=$row["lastname"]?>" maxlength="100" disabled>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="profile_tel" class="head-from-text"><i class="fa fa-phone" aria-hidden="true"></i> เบอร์โทร :</label>
					<input id="profile_tel" name="profile_tel" type="text" class="my-from-control input_disabled" placeholder="ระบุเบอร์โทร" value="<?=$row["tel"]?>" maxlength="10" disabled
					OnKeyPress="return chkNumber(this)" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false">
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="profile_email" class="head-from-text"><i class="fa fa-envelope" aria-hidden="true"></i> อีเมล์ :</label>
					<input id="profile_email" name="profile_email" type="text" class="my-from-control input_disabled" value="<?=$row["email"]?>" placeholder="ระบุอีเมล์" maxlength="100" disabled>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="profile_houseno" class="head-from-text"><i class="fa fa-address-card-o" aria-hidden="true"></i> ที่อยู่เลขที่ :</label>
					<input id="profile_houseno" name="profile_houseno" type="text" class="my-from-control input_disabled" placeholder="ระบุที่อยู่" value="<?=$row["houseno"]?>" maxlength="255" disabled>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="Province" class="head-from-text"><i class="fa fa-address-card-o" aria-hidden="true"></i> จังหวัด :</label>
					<select id="Province" name="Province" onchange="getAddress(this.name, 'District', 'a')" class="my-from-control input_disabled" disabled>
					<option value="1,<?=$row["province"]?>" selected><?=$row["province"]?></option>
					<?php
					include_once '../_db/connect.php';
					include_once '../_db/address_database.class.php';
					$juice = new MY_SQL;
					$juice->fncConnectDB();
					$juice->fncSelectDB();
					$juice->set_char_utf8();
					$province = $juice->fncSelect("PROVINCE_ID,PROVINCE_NAME","province","ORDER BY PROVINCE_NAME ASC");
					foreach($province as $read){ ?><option value="<?=$read['PROVINCE_ID']?>,<?=$read['PROVINCE_NAME']?>"><?=$read['PROVINCE_NAME']?></option><? } ?>
					</select>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="District" class="head-from-text"><i class="fa fa-address-card-o" aria-hidden="true"></i> อำเภอ / เขต :</label>
					<select id="District" name="District" onchange="getAddress(this.name, 'SubDistrict', 't')" class="my-from-control input_disabled" disabled><option value="1,<?=$row["area"]?>" selected><?=$row["area"]?></option></select>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="SubDistrict" class="head-from-text"><i class="fa fa-address-card-o" aria-hidden="true"></i> ตำบล / แขวง :</label>
					<select id="SubDistrict" name="SubDistrict" onchange="getAddress(this.name, 'Zipcode', 'z')" class="my-from-control input_disabled" disabled><option value="1,<?=$row["subarea"]?>" selected><?=$row["subarea"]?></option></select>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="Zipcode" class="head-from-text"><i class="fa fa-address-card-o" aria-hidden="true"></i> รหัสไปรษณีย์ :</label>
					<input id="Zipcode" name="Zipcode" type="text" class="validate[custom[zip]] my-from-control input_disabled" value="<?=$row["postalcode"]?>" placeholder="ระบุรหัสไปรษณีย์" maxlength="5"
					OnKeyPress="return chkNumber(this)" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" disabled>
					</div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label for="pic" class="head-from-text"><i class="fa fa-image" aria-hidden="true"></i> รูปโปรไฟล์ :</label>
					<input type="file" name="image" id="pic" class="my-from-control input_disabled" onChange="showpic(event);" disabled>
					</div>
					</div>
					<div class="col-sm-12">
					<center>
					<button style="cursor:pointer;display:initial;" class="my-btn-submit" id="profile_edit" onClick="profile_edit1()">
					<i class="fa fa-edit" aria-hidden="true"></i>
					แก้ไข
					</button>
					<button type="submit" id="profile_submit" style="cursor:pointer;display:none;" class="my-btn-submit">
					<i class="fa fa-save" aria-hidden="true"></i>
					บันทึก
					</button>
					<button type="submit" id="profile_submit_cancel" style="cursor:pointer;display:none;background-color:rgb(224, 73, 73);" class="my-btn-submit" onClick="profile_edit2()">
					<i class="fa fa-times" aria-hidden="true"></i>
					ยกเลิก
					</button>
					</center>
					</div>
					<div class="col-sm-12">
					<hr>
					<h5><i class="fa fa-calendar-check-o"></i> ประวัติรายการนัดหมาย</h5>
					<hr>
					</div>
                    <div class="col-sm-12">
					<?php
					require("../_db/connect.php");
					require("../_function/dateconvert.php");
					$username=$row["username"];
					if(isset($_POST["process"]))
					{
					if(trim($_POST["process"])=="DELETE")
						{
							$id=$_POST["id"];
							$sql="DELETE FROM booking WHERE id='$id'";
							mysqli_query($conn, $sql);
							echo "<script>alert('ลบแล้ว');</script>";
						}
					}
					$sql="SELECT COUNT(*) AS total FROM booking WHERE username='$username'";
					$result = mysqli_query($conn, $sql);
					$count=0;
					$row = mysqli_fetch_assoc($result);
					$n=$row["total"];
					$rpp=4;
					$max=ceil($n/$rpp);
					if(isset($_GET["emp_id"])){
						$p=$_GET["emp_id"];
						if($_GET["emp_id"]>$max){
							echo "<div class='col-sm-12'><center><h3>ไม่พบหน้าที่คุณต้องการ</h3></center></div>";
						}
					}
					else $p=1;
					$start = ($p-1)*$rpp;
					$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
					FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE c.username='$username' ORDER BY `c`.`date` ASC LIMIT $start , $rpp";
					$result=mysqli_query($conn,$sql);
					if($n==0){ ?>
						<div class="col-sm-12"><center><h3>ไม่มีรายการนัดหมาย</h3></center></div>
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
				if($n>4 && $_GET["page"]=="member" && isset($_GET["edit_id"])){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["emp_id"]))
									{
										if($_GET["emp_id"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?page=member&edit_id=<?=$_GET["edit_id"]?>&emp_id=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
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
										<a href="?page=member&edit_id=<?=$_GET["edit_id"]?>&emp_id=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php
				}?>
				  </div>
                  </div>
				  </form>
			  <?php }}}?>
		</div>
		</div>
      </div>
	  </div>
	  <iframe id="iframe_target" name="iframe_target" src="" style="width:0; height:0; border:0; border:none"></iframe>
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
		<script type="text/javascript">
		var showpic=function(event){
			document.getElementById("preview").src=URL.createObjectURL(event.target.files[0]);
		};
		function profile_edit1() {
		var x = document.getElementById("profile_submit");
		var y = document.getElementById("profile_submit_cancel");
		var z = document.getElementById("profile_edit");
		if (x.style.display === "none") {
			x.style.display = "initial";
		}
		if (y.style.display === "none") {
			y.style.display = "initial";
		}
		if (z.style.display === "initial") {
			z.style.display = "none";
		}
		}
		function profile_edit2() {
		var x = document.getElementById("profile_submit");
		var y = document.getElementById("profile_submit_cancel");
		var z = document.getElementById("profile_edit");
		if (y.style.display === "initial") {
			x.style.display = "none";
			y.style.display = "none";
			z.style.display = "initial";
		}
		}
		$("#profile_submit_cancel").click(function(event){
			event.preventDefault();
			$('.input_disabled').attr("disabled", "disabled");
		});
		$("#profile_edit").click(function(event){
			event.preventDefault();
			$('.input_disabled').removeAttr("disabled")
		});
		function getAddress(iSelect, toSelect, iMode){
			$.ajax({type : "GET",
				url :"../_function/get_address.php",
				data : { find: iMode, fvalue:$('select[name='+ iSelect+']').val()  },
				success : function(data){
					if (iMode=="z"){
						$('input[name='+ toSelect+']').val(data);
					} else {
						$('select[name='+ toSelect+']').empty().append(data);
						$('input[name=Zipcode]').val('');
					}

					  if(iMode=="a"){
						  var sname="select[name=SubDistrict]";
						  $(sname).empty().append("<option value=\"\" selected=\"selected\">:::::&nbsp;เลือก&nbsp;:::::</option>");
					  }
				}
			});
		}
		</script>
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
