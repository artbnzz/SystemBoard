<?php
$month = array("","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹","�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
function dateConvert($mysqlDate)
{
global $month;
list($y, $m, $d)=explode("-", $mysqlDate);
$y = $y+543;
return intval($d).' '.$month[intval($m)].' '.$y;
}
?>