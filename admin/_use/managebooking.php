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
				<a href="../admin?page=managebooking" class="admin-button-active"><i class="fa fa-tasks"></i> ระบบนัดหมาย</a>
				<a href="../admin?page=member" class="admin-button"><i class="fa fa-users"></i> จัดการสมาชิก</a>
                <a href="../admin?page=portfolio" class="admin-button"><i class="fa fa-pencil" aria-hidden="true"></i> จัดการผลงาน</a>
              </div>
			  <?php 
			  if(isset($_GET["page"])){
			  if($_GET["page"]=="managebooking" && !isset($_GET["booking_edit"]) && !isset($_GET["booking_add"])){?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-tasks" aria-hidden="true"></i> ระบบนัดหมาย
                </div>
                <div class="panel-text">
                  <div class="row">
                  <div class="col-sm-12">
				  <style>
				  td, th {
				  text-align:left;
				  word-wrap: break-word;
				  border: 1px solid #ddd;
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
				  <h5 style="padding-top:10px;"><i class="fa fa-cog"></i> จัดการเรื่องนัดหมาย</h5>
				  <table width="100%" cellpadding="10">
				  <tr>
					<th style="width:10%;text-align:center;">#</th>
					<th style="width:50%;">ชื่อเรื่องนัดหมาย</th>
					<th style="width:25%;text-align:center;">จำนวนครั้งที่นัดหมาย</th>
					<th style="width:15%;"></th>
				  </tr>
				  <?php
				  require("../_db/connect.php");
				  $sql="SELECT * FROM booking_name";
				  $result=mysqli_query($conn,$sql);
				  $count_book=0;
				  while($row=mysqli_fetch_assoc($result)){
				  ?>
				  <tr>
				  <td style="text-align:center;"><?=$row["id"]?></td>
				  <td><?=$row["name"]?></td>
				  <td style="text-align:center;"><?=$row["count"]?> ครั้ง</td>
				  <td style="text-align:center;width:15%;"><a href="?page=managebooking&booking_edit=<?=$row["id"]?>" class="my-btn-submit" style="padding:5px;padding-left:10px;padding-right:10px;"><i class="fa fa-pencil"></i> แก้ไข</a></td>
				  </tr>
				  <?php
				  $count_book=$count_book+$row["count"];
				  }?>
				  <tr>
				  <th style="text-align:center;" colspan="2">รวมทั้งหมด</th>
				  <th style="text-align:center;"><?=$count_book?> ครั้ง</th>
				  <th></th>
				  </tr>
				  </table>
                  </div>
				  <div class="col-sm-12">
				  <br>
				  <center>
					<a href="../print.php?mode=bookingnameprint" target="_blank" class="my-btn-submit">
					<i class="fa fa-print" aria-hidden="true"></i>
					พิมพ์เรื่องนัดหมาย
					</a>&nbsp;
					<a href="?page=managebooking&booking_add" class="my-btn-submit">
					<i class="fa fa-plus" aria-hidden="true"></i>
					เพิ่มเรื่องนัดหมาย
					</a>
				  </center>
				  <br>
				  </div>
				  </div>
                </div>
              </div>
			  <?php } } ?>
			  <?php 
			  if(isset($_GET["page"])){
			  if($_GET["page"]=="managebooking" && isset($_GET["booking_edit"]) && !isset($_GET["booking_add"])){
			  $id=$_GET["booking_edit"];
			  require("../_db/connect.php");
			  $sql="SELECT * FROM booking_name WHERE id='$id'";
			  $result=mysqli_query($conn,$sql);
			  $row=mysqli_fetch_assoc($result);
			  ?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-tasks" aria-hidden="true"></i> ระบบนัดหมาย <i class="fa fa-arrow-right"></i> แก้ไขเรื่องนัดหมาย
                </div>
				<form method="post" target="iframe_target" id="form_booking" action="_use/booking_edit.php">
                <div class="panel-text">
                  <div class="row" style="padding-top:10px;">
                  <div class="col-sm-12">
				  <h5>เลขที่เรื่องนัดหมาย</h5>
				  <input type="text" class="my-from-control" name="booking_name" value="<?=$row["id"]?>" placeholder="ระบุชื่อเรื่องนัดหมาย" disabled>
				  <input type="hidden" value="<?=$row["id"]?>" name="booking_id">
                  </div>
                  <div class="col-sm-12">
				  <br><h5>ชื่อเรื่องนัดหมาย</h5>
				  <input type="text" class="my-from-control" name="booking_name" value="<?=$row["name"]?>" placeholder="ระบุชื่อเรื่องนัดหมาย">
                  </div>
				  <div class="col-sm-12">
				  <br>
				  <center>
					<a href="javascript:{}" onclick="document.getElementById('form_booking').submit();" class="my-btn-submit">
					<i class="fa fa-save" aria-hidden="true"></i>
					บันทึก
					</a>&nbsp;
					<a href="?page=managebooking" style="background-color:rgb(224, 73, 73);" class="my-btn-submit">
					<i class="fa fa-times" aria-hidden="true"></i>
					ยกเลิก
					</a>
				  </center>
				  <br>
				  </div>
				  </div>
                </div>
				</form>
              </div>
			  <?php } } ?>
			  <?php 
			  if(isset($_GET["page"])){
			  if($_GET["page"]=="managebooking" && isset($_GET["booking_add"])){
			  ?>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-tasks" aria-hidden="true"></i> ระบบนัดหมาย <i class="fa fa-arrow-right"></i> เพิ่มเรื่องนัดหมาย
                </div>
				<form method="post" target="iframe_target" id="form_booking" action="_use/booking_add.php">
                <div class="panel-text">
                  <div class="row" style="padding-top:10px;">
                  <div class="col-sm-12">
				  <h5>ชื่อเรื่องนัดหมาย</h5>
				  <input type="text" class="my-from-control" name="booking_name" value="" placeholder="ระบุชื่อเรื่องนัดหมาย">
                  </div>
				  <div class="col-sm-12">
				  <br>
				  <center>
					<a href="javascript:{}" onclick="document.getElementById('form_booking').submit();" class="my-btn-submit">
					<i class="fa fa-save" aria-hidden="true"></i>
					บันทึก
					</a>&nbsp;
					<a href="?page=managebooking" style="background-color:rgb(224, 73, 73);" class="my-btn-submit">
					<i class="fa fa-times" aria-hidden="true"></i>
					ยกเลิก
					</a>
				  </center>
				  <br>
				  </div>
				  </div>
                </div>
				</form>
              </div>
			  <?php } } ?>
			</div>
		  </div>
		</div>
	  </div>
	  <iframe id="iframe_target" name="iframe_target" src="" style="display:none;"></iframe>
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
  </body>

</html>
