<?php
$month = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
function dateConvert($mysqlDate)
{
global $month;
list($y, $m, $d)=explode("-", $mysqlDate);
$y = $y+543;
return intval($d).' '.$month[intval($m)].' '.$y;
}
?>