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
                <a href="../admin?page=update" class="admin-button-active"><i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ</a>
				<a href="../admin?page=managebooking" class="admin-button"><i class="fa fa-tasks"></i> ระบบนัดหมาย</a>
				<a href="../admin?page=member" class="admin-button"><i class="fa fa-users"></i> จัดการสมาชิก</a>
                <a href="../admin?page=portfolio" class="admin-button"><i class="fa fa-pencil" aria-hidden="true"></i> จัดการผลงาน</a>
              </div>
			  <?php 
			  if(isset($_GET["page"])){
			  if($_GET["page"]=="update"){?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ <i class="fa fa-arrow-right" aria-hidden="true"></i> ค้นหา</a>
                </div>
                <div class="panel-text">
                  <div class="row">
                  <div class="col-sm-12">
				  <form method="get" id="s_id" action="../admin?page=update&">
                    <h5 style="padding-top:10px;"><i class="fa fa-id-card" aria-hidden="true"></i> ค้นหาจาก ID ใบนัดหมาย</h5>
                    <input type="text" name="s_id" style="width:100%;" class="my-from-control" placeholder="ระบุ ID ใบนัดหมาย" OnKeyPress="return chkNumber(this)">
                    <br><br><a href="javascript:{}" onclick="document.getElementById('s_id').submit();" class="my-btn-submit"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</a>
				  </form>
				  <form method="get" id="s_tel" action="../admin?page=update&">
                    <br><br>
                    <h5><i class="fa fa-phone" aria-hidden="true"></i> ค้นหาจากเบอร์โทร</h5>
                    <input type="text" name="s_tel" style="width:100%;"class="my-from-control" placeholder="ระบุเบอร์โทร" OnKeyPress="return chkNumber(this)" maxlength="10">
                    <br><br><a href="javascript:{}" onclick="document.getElementById('s_tel').submit();" class="my-btn-submit"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</a>
                    <br><br>
				  </form>
                  </div>
                </div>
                </div>
              </div>
			  <?php } } ?>
			  <?php
			  if(isset($_GET["s_id"])){
 			  if($_GET["s_id"]==""){?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ <i class="fa fa-arrow-right" aria-hidden="true"></i> ค้นหา <i class="fa fa-arrow-right" aria-hidden="true"></i> ผลลัพธ์
                </div>
				<div class="panel-text">
				<div class='col-sm-12'><center>กรุณาระบุไอดีใบนัดหมาย</center></div>
                    <div class="col-sm-12 port-button-control">
                      <a href="?page=update" class="my-btn-submit" style="background-color:rgb(224, 73, 73);"><i class="fa fa-arrow-left" aria-hidden="true"></i> ย้อนกลับ</a>
                    </div>
				</div>
			  </div>
			  <?php
			  }
			  }
			  ?>
			  <?php
			  if(isset($_GET["s_tel"])){
 			  if($_GET["s_tel"]==""){?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ <i class="fa fa-arrow-right" aria-hidden="true"></i> ค้นหา <i class="fa fa-arrow-right" aria-hidden="true"></i> ผลลัพธ์
                </div>
				<div class="panel-text">
				<div class='col-sm-12'><center>กรุณาระบุเบอร์โทรศัพท์</center></div>
                    <div class="col-sm-12 port-button-control">
                      <a href="?page=update" class="my-btn-submit" style="background-color:rgb(224, 73, 73);"><i class="fa fa-arrow-left" aria-hidden="true"></i> ย้อนกลับ</a>
                    </div>
				</div>
			  </div>
			  <?php
			  }
			  }
			  ?>
			  <?php if((isset($_GET["s_id"]) && !empty($_GET["s_id"])) || (isset($_GET["s_tel"]) && !empty($_GET["s_tel"]))){?>
			  <?php
			  require("../_db/connect.php");
			  require("../_function/dateconvert.php");
			  if(isset($_POST["process"]))
			  {
				if(trim($_POST["process"])=="DELETE")
					{
						$id=$_POST["id"];
						$sql="DELETE FROM booking WHERE id='$id'";
						mysqli_query($conn, $sql);
						echo "<script>alert('ลบแล้ว');</script>";
						echo '<script>window.top.location.href = "../admin/?page=update"</script>';
					}
			  }
			  if(isset($_GET["s_id"])){
			  $id=$_GET["s_id"];
			  $sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE c.id='$id'";
			  }
			  if(isset($_GET["s_tel"])){
				  $tel=$_GET["s_tel"];
				  $sql="SELECT COUNT(*) AS total FROM booking INNER JOIN accounts ON booking.username = accounts.username WHERE tel='$tel'";
				  $result = mysqli_query($conn, $sql);
				  $count=0;
				  $row = mysqli_fetch_assoc($result);
				  $n=$row["total"];
				  $rpp=2;
				  $max=ceil($n/$rpp);
				  if(isset($_GET["tp"]))
				  	$p=$_GET["tp"];
				  else $p=1;
			      $start = ($p-1)*$rpp;
			  $id=$_GET["s_tel"];
			  $sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE tel='$id' ORDER BY date ASC LIMIT $start , $rpp";
			  }
			  $result=mysqli_query($conn,$sql);
			  ?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-refresh" aria-hidden="true"></i> อัพเดตสถานะ <i class="fa fa-arrow-right" aria-hidden="true"></i> ค้นหา <i class="fa fa-arrow-right" aria-hidden="true"></i> ผลลัพธ์
                </div>
                <div class="panel-text">
                  <div class="row">
				  <?php
			      if(mysqli_num_rows($result)==0){?>
					  <?php if(isset($_GET["s_id"])){?>
					<div class='col-sm-12'><center>ไม่พบไอดีที่ค้นหา</center></div>
					<div class="col-sm-12 port-button-control">
                      <a href="?page=update" class="my-btn-submit" style="background-color:rgb(224, 73, 73);"><i class="fa fa-arrow-left" aria-hidden="true"></i> ย้อนกลับ</a>
                    </div>
					  <?php } ?>
					  <?php if(isset($_GET["s_tel"])){?>
					<div class='col-sm-12'><center>ไม่พบเบอร์โทรศัพท์ที่ค้นหา</center></div>
					<div class="col-sm-12 port-button-control">
                      <a href="?page=update" class="my-btn-submit" style="background-color:rgb(224, 73, 73);"><i class="fa fa-arrow-left" aria-hidden="true"></i> ย้อนกลับ</a>
                    </div>
					  <?php } ?>
				  <?php
				  }else{
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
                    <div class="col-sm-12">
					<form method="post" target="iframe_target" id="submitdata" src="" action="_use/query.php">
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
                          <td><a href="../print.php?pid=<?=$row["id"]?>" style="color:rgb(0, 0, 0);" target="_blank">#<?=$row["id"]?></a><input type="hidden" name="id" value="<?=$row["id"]?>"></td>
                          <td><?=dateConvert($row["date"])?> <br><?=$row["name"]?></td>
                          <td><?=$row["accounts_name"]?>&nbsp;<?=$row["accounts_lastname"]?></td>
                          <td><?=$row["tel"]?></td>
                          <td><?=$booking_name?></td>
						  <td><input type="button" value="ลบ" <?php if($row["status"]<6){?>style="border-radius:3px;background-color:rgb(224, 73, 73);color:white;cursor:pointer;"<?php }else{?>style="border-radius:3px;background-color:rgb(255, 198, 198);color:white;cursor:default;"<?php }?> onclick="deleteData('<?=$row["id"]?>');"<?php if($row["status"]>=6){?>disabled<?php } ?>></td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <ol class="my-progress" my-steps="6">
                              <li id="progress-control-1" <?php if($row["status"] >= 1){ ?>class="finished" <?php } ?>>
                                <span><a class="progress-text-control">ขั้นตอนที่ 1</a></span>
                                <i></i>
                              </li><!--
                              --><li id="progress-control-2" <?php if($row["status"] >= 2){ ?>class="finished" <?php } ?>>
                                <span><a class="progress-text-control">ขั้นตอนที่ 2</a></span>
                              </li><!--
                              --><li id="progress-control-3" <?php if($row["status"] >= 3){ ?>class="finished" <?php } ?>>
                                <span><a class="progress-text-control">ขั้นตอนที่ 3</a></span>
                                <i></i>
                              </li><!--
                              --><li id="progress-control-4" <?php if($row["status"] >= 4){ ?>class="finished" <?php } ?>>
                                <span><a class="progress-text-control">ขั้นตอนที่ 4</a></span>
                                <i></i>
                              </li><!--
                              --><li id="progress-control-5" <?php if($row["status"] >= 5){ ?>class="finished" <?php } ?>>
                                <span><a class="progress-text-control">ขั้นตอนที่ 5</a></span>
                                <i></i>
                              </li><!--
                              --><li id="progress-control-6" <?php if($row["status"] >= 6){ ?>class="finished" <?php } ?>>
                                 <span><a class="progress-text-control">ขั้นตอนที่ 6</a></span>
                                 <i></i>
                               </li>
                            </ol>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="6">
                            <div class="row">
                            <div class="col-sm-2" style="padding:0px;">
                              <center style="margin-left:35px;">
                              <input type="checkbox" name="progress" value="1" id="progress1" <?php if($row["status"] >= 1){ ?>checked <?php } ?><?php if(isset($_GET["s_tel"]) || $row["status"] >= 6){?>disabled <?php } ?>><br>เปิดใบจอง
                              </center>
                            </div>
                            <div class="col-sm-2" style="padding:0px;">
                              <center style="margin-left:27px;">
                              <input type="checkbox" name="progress" value="2" id="progress2" <?php if($row["status"] >= 2){ ?>checked <?php } ?><?php if(isset($_GET["s_tel"]) || $row["status"] >= 6){?>disabled <?php } ?>><br>ส่งเครื่องแล้ว
                              </center>
                            </div>
                            <div class="col-sm-2" style="padding:0px;">
                              <center style="margin-left:12px;">
                              <input type="checkbox" name="progress" value="3" id="progress3" <?php if($row["status"] >= 3){ ?>checked <?php } ?><?php if(isset($_GET["s_tel"]) || $row["status"] >= 6){?>disabled <?php } ?>><br>กำลังดำเนินการ
                              </center>
                            </div>
                            <div class="col-sm-2" style="padding:0px;">
                              <center style="margin-left:4px;">
                              <input type="checkbox" name="progress" value="4" id="progress4" <?php if($row["status"] >= 4){ ?>checked <?php } ?><?php if(isset($_GET["s_tel"]) || $row["status"] >= 6){?>disabled <?php } ?>><br>ดำเนินการแล้ว
                              </center>
                            </div>
                            <div class="col-sm-2" style="padding:0px;">
                              <center style="margin-left:-8px;">
                              <input type="checkbox" name="progress" value="5" id="progress5" <?php if($row["status"] >= 5){ ?>checked <?php } ?><?php if(isset($_GET["s_tel"]) || $row["status"] >= 6){?>disabled <?php } ?>><br>ชำระเงิน
                              </center>
                            </div>
                            <div class="col-sm-2" style="padding:0px;">
                              <center style="margin-left:-25px;">
                              <input type="checkbox" name="progress" value="6" id="progress6" <?php if($row["status"] >= 6){ ?>checked <?php } ?><?php if(isset($_GET["s_tel"]) || $row["status"] >= 6){?>disabled <?php } ?>><br>เสร็จสิ้น
                              </center>
                            </div>
							<?php if(isset($_GET["s_tel"])){?>
							<div class="col-sm-12 port-button-control">
								<?php
								if($row["status"]>=6){
								?>
								<button class="my-btn-submit" disabled style="background-color:rgb(129, 209, 144);"><i class="fa fa-cog"></i> อัพเดตสถานะ</button>
								<?php }else{?>
								<a href="?s_id=<?=$row["id"]?>" class="my-btn-submit"><i class="fa fa-cog"></i> อัพเดตสถานะ</a>
								<?php }?>
							</div>
							<?php } ?>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
					</form>
                    </div>
				  <?php 
				  }
				  ?>
				  <?php if(isset($_GET["s_id"])){?>
				  <div class="col-sm-12 port-button-control">
					<a href="javascript:{}" onclick="document.getElementById('submitdata').submit();" class="my-btn-submit"><i class="fa fa-save"></i> บันทึก</a>
				  </div>
				  <?php } ?>
				  <?php
				  }
				  ?>
				  </div>
				  </div>
				<?php 
				if(isset($_GET["s_tel"])){
				if($n>2 && isset($_GET["s_tel"])){
						?>
						<div class="col-sm-12">
							<br><center>
							<h3>ไปหน้าที่  : 
							<?php
								for($i=1;$i<=$max;$i++)
								{
									if(isset($_GET["tp"]))
									{
										if($_GET["tp"]==$i){
											?><a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }else{ ?>
											<a href="?s_tel=<?=$tel?>&tp=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
								    }
									else{
										if($n<=2){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php }
										elseif($i==1){ ?>
											<a style="text-decoration: none;color:red;font-size:30px;cursor:default;"><b><?=$i?></b></a>
								  <?php	}
										else{ ?>
										<a href="?s_tel=<?=$tel?>&tp=<?=$i?>" style="text-decoration: none;"><?=$i?></a>
								  <?php }
									}
								}
						?></h3></center>
						</div>
				<?php } } ?>
				</div>
			</div>
		<?php } ?>
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
