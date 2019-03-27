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
				<a href="../admin?page=member" class="admin-button"><i class="fa fa-users"></i> จัดการสมาชิก</a>
                <a href="../admin?page=portfolio" class="admin-button-active"><i class="fa fa-pencil" aria-hidden="true"></i> จัดการผลงาน</a>
              </div>
              <div class="col-sm-9">
                <div class="panel-header">
                  <i class="fa fa-pencil" aria-hidden="true"></i> จัดการผลงาน
                </div>
                <div class="panel-text">
                  <div class="row">
				  <?php
				  require("../_db/connect.php");
				  if($_GET["page"]=="portfolio"){
				  if(isset($_POST["process"]))
				  {
				  if(trim($_POST["process"])=="DELETE")
				  {
					$id=$_POST["id"];
					$sql="DELETE FROM portfolio WHERE id='$id';";
					mysqli_query($conn, $sql);
					echo "<script>alert('ลบผลงานแล้ว');</script>";
					}
				  }
				  $sql="SELECT * FROM portfolio";
				  $result=mysqli_query($conn,$sql);
				  if($row=mysqli_num_rows($result)==0){?>
					<div class="col-sm-12">
					<center>ยังไม่มีผลงาน</center>
					</div>
				  <?php					
				  }else{
					  while($row=mysqli_fetch_assoc($result)){
				  ?>
                    <div class="col-sm-4">
                      <div class="port-main-admin">
						<input type="hidden" name="id" value="<?=$row["id"]?>">
                        <a href="?page=manageport&portid=<?=$row["id"]?>" title="<?=$row["detail"]?>">
                          <img src="data:image/jpeg;base64,<?=base64_encode($row["image"])?>" class="img-fluid">
                          </a>
                        <div class="port-detail-admin">
                          <a href="?page=manageport&portid=<?=$row["id"]?>" class="port-header-admin"><?=$row["detail"]?></a>
                          <br><br><button type="button" class="button-admin-button" onclick="deleteData('<?=$row["id"]?>','<?=$row["detail"]?>');"><i class="fa fa-trash-o" aria-hidden="true"></i> ลบผลงานนี้</button>
                        </div>
                      </div>
                    </div>
				  <?php } } ?>
                    <div class="col-sm-12 port-button-control">
					<?php if($row=mysqli_num_rows($result)!=0){?>
					  <a href="../print.php?mode=portfolioprint" target="_blank" class="my-btn-submit"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์ผลงาน</a>
					<?php }?>
                      <a href="?page=manageport" class="my-btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่มผลงาน</a>
                    </div>
					<form method="post" action="" name="form" id="process">
						<input type="hidden" name="process">
						<input type="hidden" name="id">
					</form>
				  <?php } ?>
				  <?php if($_GET["page"]=="manageport"){?>
				  <?php
					  if(!isset($_GET["portid"])){
					  $sql="SELECT * FROM portfolio";
					  $result=mysqli_query($conn,$sql);
					  if(mysqli_num_rows($result)==9){?>
						  <div class='col-sm-12'><center>ผลงานเต็มแล้วไม่สามารถเพิ่มได้อีก กรุณาลบผลงานหากต้องการเพิ่ม</div>
						  <div class="col-sm-12 port-button-control">
							<a href="?page=portfolio" class="my-btn-submit" style="background-color:rgb(224, 73, 73);"><i class="fa fa-arrow-left" aria-hidden="true"></i> ย้อนกลับ</a>
						  </div>
					  <?php
					  }
					  }
					  elseif(isset($_GET["portid"])){
					  $portid=$_GET["portid"];
					  $sql="SELECT * FROM portfolio WHERE id='$portid'";
					  $result=mysqli_query($conn,$sql);
					  $row=mysqli_fetch_assoc($result);
					  if(mysqli_num_rows($result)==0){?>
						  <div class='col-sm-12'><center>ไม่พบผลงานที่คุณเลือก</div>
						  <div class="col-sm-12 port-button-control">
							<a href="?page=portfolio" class="my-btn-submit" style="background-color:rgb(224, 73, 73);"><i class="fa fa-arrow-left" aria-hidden="true"></i> ย้อนกลับ</a>
						  </div>
					 <?php
					 }}
					 if(mysqli_num_rows($result)!=0){
					 if(mysqli_num_rows($result)<9){?>
                    <div class="col-sm-12">
					<form method="post" enctype="multipart/form-data" target="iframe_target" action="_use/port_func.php">
					  <?php if(!isset($_GET["portid"])){?> <input type="hidden" name="task" value="ADD"><?php }?>
					  <?php if(isset($_GET["portid"])){?> <input type="hidden" name="task" value="UPDATE"><input type="hidden" name="id" value="<?=$_GET["portid"]?>"><?php }?>
                      <h4><i class="fa fa-header" aria-hidden="true"></i> ชื่อผลงาน</h4>
                      <input name="port_name" class="my-from-control" maxlength="36" type="text" width="100%;" <?php if(isset($_GET["portid"])){?>value="<?=$row["detail"]?>" <?php } ?> placeholder="กรุณาระบุชื่อผลงาน"><br><br>
                      <br>
                      <h4><i class="fa fa-picture-o" aria-hidden="true"></i> เพิ่มรูปภาพ</h4>
					  <img src="data:image/jpeg;base64,<?=base64_encode($row["image"])?>" class="img-fluid" width="200px" id="preview" onerror="this.src ='img/icon-no-image.svg'">
					  <br><br><input type="file" name="image" onChange="showpic(event);">
                      <small class="form-text text-muted">กรุณาอัพโหลดเฉพาะรูปภาพที่เป็น JPG ขนาด กว้าง 800px X ยาว 500px เท่านั้น.</small>
                    </div>
                    <div class="col-sm-12 port-button-control">
                        <?php if(isset($_GET["portid"])){?><button class="my-btn-submit" type="submit" style="cursor:pointer;"><i class="fa fa-save"></i> บันทึก</button><?php } ?>
						<?php if(!isset($_GET["portid"])){?><button class="my-btn-submit" type="submit" style="cursor:pointer;"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่มผลงาน</button><?php } ?>
                        <a class="my-btn-submit" href="?page=portfolio" style="background-color:rgb(224, 73, 73);"><i class="fa fa-times" aria-hidden="true"></i> ยกเลิก</a>
                    </div>
					</form>
				  <?php 
				  }}}
				  ?>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
	<iframe id="iframe_target" name="iframe_target" src="" style="width:0; height:0; border:0; border:none"></iframe>
    </div>
    </div>
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
        Copyright © 2017 Student SSRU 59122202013 All Right Reserved.
      </div>
    </div>
    <script src="js/myjs.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
	function deleteData(pid , pname)
	{
			if(confirm('คุณต้องการลบผลงาน : '+pname+' ?'))
		{
			document.form.process.value="DELETE";
			document.form.id.value=pid;
			document.form.submit();
		}
	}
	function addData()
	{
		document.form.process.value="ADD";
		document.form.submit();
	}
    $(function() {
		$("[data-toggle='tooltip']").tooltip()
    })
	var showpic=function(event){
		document.getElementById("preview").src=URL.createObjectURL(event.target.files[0]);
	};
    </script>
  </body>

</html>
