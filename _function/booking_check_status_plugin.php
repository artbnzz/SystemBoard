<?php
if($row["status"] == "1"){ echo "เปิดใบจอง"; }
elseif($row["status"] == "2"){ echo "ส่งเครื่องแล้ว"; }
elseif($row["status"] == "3"){ echo "กำลังดำเนินการ"; }
elseif($row["status"] == "4"){ echo "ดำเนินการแล้ว"; }
elseif($row["status"] == "5"){ echo "ชำระเงิน"; }
elseif($row["status"] == "6"){ echo "เสร็จสิ้น"; }
?>