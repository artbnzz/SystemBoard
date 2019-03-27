<?php
session_start();
//----------------
// ADMIN PRINT DAILY
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="dailyprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'รายการนัดหมายในวันนี้',0,1,'C');
$pdf->Ln(8);
$dailyshow=dateConvert(date("Y-m-d"));
$pdf->Cell(0,0,''.$dailyshow.'',0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','',16);
$pdf->Cell(30,10,'เวลา','LTB',0,'C');
$pdf->Cell(60,10,'ชื่อนามสกุล','LTB',0,'C');
$pdf->Cell(25,10,'เบอร์โทร','LTB',0,'C');
$pdf->Cell(75,10,'เรื่องที่นัดหมาย','LTRB',1,'C');
$pdf->SetWidths(array(30, 60, 25, 75));
$daily=date("Y-m-d");
$sql="SELECT booking_time.*, booking.date, booking.username, accounts.name AS accounts_name,accounts.lastname AS accounts_lastname, 
accounts.tel, booking.check FROM booking_time LEFT JOIN booking ON booking.time_id=booking_time.id AND date='$daily' 
LEFT JOIN accounts ON booking.username=accounts.username ORDER BY `booking_time`.`id` ASC";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีรายการนัดหมายในวันนี้','LTRB',1,'C');
}else{
while($row=mysqli_fetch_assoc($result)){
if($row["check"]!=NULL){
$booking_name_check=explode("," ,$row["check"]);
$check=implode(",",$booking_name_check);
$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
  $booking_name_array[] = $row5["name"];
}
$booking_name = implode(' ', $booking_name_array);
}else{
$booking_name = $row["check"];
}
$border = array('TLB','TLB', 'TLB', 'TLBR');
$align = array('C', 'L', 'C', 'C');
$style = array('', '', '', '');
$empty = array(''.$row["name"].'',''.$row["accounts_name"].' '.''.$row["accounts_lastname"].'',''.$row["tel"].'',''.$booking_name.'',);
$pdf->FancyRow($empty, $border, $align, $style);
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT WEEKLY
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="weeklyprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'รายการนัดหมายในสัปดาห์นี้',0,1,'C');
$pdf->Ln(8);
$startweek=(int)date('d', strtotime('monday this week')); 
$endweek=(int)date('d', strtotime('sunday this week'));
$dailyshow=explode(" ",dateConvert(date("Y-m-d")));
$pdf->Cell(0,0,''.$startweek.' - '.$endweek.' '.$dailyshow[1].' '.$dailyshow[2],0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(10,10,'','LTB',0,'C');
$pdf->Cell(30,10,'วันที่','LTB',0,'C');
$pdf->Cell(20,10,'เวลา','LTB',0,'C');
$pdf->Cell(45,10,'ชื่อนามสกุล','LTB',0,'C');
$pdf->Cell(25,10,'เบอร์โทร','LTB',0,'C');
$pdf->Cell(60,10,'เรื่องที่นัดหมาย','LTRB',1,'C');
$pdf->SetWidths(array(10, 30, 20, 45, 25, 60));
$daily=date("Y-m-d");
$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW()) ORDER BY c.date ASC , c.time_id ASC";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีรายการนัดหมายในสัปดาห์นี้','LTRB',1,'C');
}else{	
$count=1;
while($row=mysqli_fetch_array($result)){
$booking_name_check=explode("," ,$row["check"]);
$check=implode(",",$booking_name_check);
$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
  $booking_name_array[] = $row5["name"];
}
$booking_name = implode(' ', $booking_name_array);
$border = array('TLB', 'TLB', 'TLB','TLB', 'TLB', 'TLBR');
$align = array('C', 'C', 'C', 'L', 'C', 'C');
$style = array('', '', '', '', '', '');
$empty = array(''.$count.'', ''.dateConvert($row["date"]).'',''.$row["name"].'',''.$row["accounts_name"].' '.''.$row["accounts_lastname"].'',''.$row["tel"].'',''.$booking_name.'',);
$pdf->FancyRow($empty, $border, $align, $style);
$count++;
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT MONTHLY
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="monthlyprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'รายการนัดหมายในเดือนนี้',0,1,'C');
$pdf->Ln(8);
$dailyshow=explode(" ",dateConvert(date("Y-m-d")));
$pdf->Cell(0,0,''.$dailyshow[1].' '.$dailyshow[2],0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(10,10,'','LTB',0,'C');
$pdf->Cell(30,10,'วันที่','LTB',0,'C');
$pdf->Cell(20,10,'เวลา','LTB',0,'C');
$pdf->Cell(45,10,'ชื่อนามสกุล','LTB',0,'C');
$pdf->Cell(25,10,'เบอร์โทร','LTB',0,'C');
$pdf->Cell(60,10,'เรื่องที่นัดหมาย','LTRB',1,'C');
$pdf->SetWidths(array(10, 30, 20, 45, 25, 60));
$daily=date("Y-m-d");
$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE YEAR(date) = YEAR(NOW()) AND MONTH(date)=MONTH(NOW()) ORDER BY c.date ASC , c.time_id ASC";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีรายการนัดหมายในเดือนนี้','LTRB',1,'C');
}else{	
$count=1;
while($row=mysqli_fetch_array($result)){
$booking_name_check=explode("," ,$row["check"]);
$check=implode(",",$booking_name_check);
$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
  $booking_name_array[] = $row5["name"];
}
$booking_name = implode(' ', $booking_name_array);
$border = array('TLB', 'TLB', 'TLB','TLB', 'TLB', 'TLBR');
$align = array('C', 'C', 'C', 'L', 'C', 'C');
$style = array('', '', '', '', '', '');
$empty = array(''.$count.'', ''.dateConvert($row["date"]).'',''.$row["name"].'',''.$row["accounts_name"].' '.''.$row["accounts_lastname"].'',''.$row["tel"].'',''.$booking_name.'',);
$pdf->FancyRow($empty, $border, $align, $style);
$count++;
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT YEARLY
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="yearlyprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'รายการนัดหมายในปี้นี้',0,1,'C');
$pdf->Ln(8);
$dailyshow=explode(" ",dateConvert(date("Y-m-d")));
$pdf->Cell(0,0,'พ.ศ. '.$dailyshow[2].' ',0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(10,10,'','LTB',0,'C');
$pdf->Cell(30,10,'วันที่','LTB',0,'C');
$pdf->Cell(20,10,'เวลา','LTB',0,'C');
$pdf->Cell(45,10,'ชื่อนามสกุล','LTB',0,'C');
$pdf->Cell(25,10,'เบอร์โทร','LTB',0,'C');
$pdf->Cell(60,10,'เรื่องที่นัดหมาย','LTRB',1,'C');
$pdf->SetWidths(array(10, 30, 20, 45, 25, 60));
$daily=date("Y-m-d");
$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) WHERE YEAR(date) = YEAR(NOW()) ORDER BY c.date ASC , c.time_id ASC";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีรายการนัดหมายในปีนี้','LTRB',1,'C');
}else{	
$count=1;
while($row=mysqli_fetch_array($result)){
$booking_name_check=explode("," ,$row["check"]);
$check=implode(",",$booking_name_check);
$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
  $booking_name_array[] = $row5["name"];
}
$booking_name = implode(' ', $booking_name_array);
$border = array('TLB', 'TLB', 'TLB','TLB', 'TLB', 'TLBR');
$align = array('C', 'C', 'C', 'L', 'C', 'C');
$style = array('', '', '', '', '', '');
$empty = array(''.$count.'', ''.dateConvert($row["date"]).'',''.$row["name"].'',''.$row["accounts_name"].' '.''.$row["accounts_lastname"].'',''.$row["tel"].'',''.$booking_name.'',);
$pdf->FancyRow($empty, $border, $align, $style);
$count++;
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT ALLPRINT
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="allprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'รายการนัดหมายทั้งหมด',0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(10,10,'','LTB',0,'C');
$pdf->Cell(30,10,'วันที่','LTB',0,'C');
$pdf->Cell(20,10,'เวลา','LTB',0,'C');
$pdf->Cell(45,10,'ชื่อนามสกุล','LTB',0,'C');
$pdf->Cell(25,10,'เบอร์โทร','LTB',0,'C');
$pdf->Cell(60,10,'เรื่องที่นัดหมาย','LTRB',1,'C');
$pdf->SetWidths(array(10, 30, 20, 45, 25, 60));
$daily=date("Y-m-d");
$sql="SELECT c.*, t.name, accounts.name AS accounts_name, accounts.lastname AS accounts_lastname, accounts.tel 
FROM booking c INNER JOIN booking_time t ON(c.time_id=t.id) INNER JOIN accounts on(c.username=accounts.username) ORDER BY c.date ASC , c.time_id ASC";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีรายการนัดหมาย','LTRB',1,'C');
}else{	
$count=1;
while($row=mysqli_fetch_array($result)){
$booking_name_check=explode("," ,$row["check"]);
$check=implode(",",$booking_name_check);
$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
  $booking_name_array[] = $row5["name"];
}
$booking_name = implode(' ', $booking_name_array);
$border = array('TLB', 'TLB', 'TLB','TLB', 'TLB', 'TLBR');
$align = array('C', 'C', 'C', 'L', 'C', 'C');
$style = array('', '', '', '', '', '');
$empty = array(''.$count.'', ''.dateConvert($row["date"]).'',''.$row["name"].'',''.$row["accounts_name"].' '.''.$row["accounts_lastname"].'',''.$row["tel"].'',''.$booking_name.'',);
$pdf->FancyRow($empty, $border, $align, $style);
$count++;
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT MEMBER
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="memberprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF('L');
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,0,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'สมาชิกทั้งหมด',0,0,'C');
$sql="SELECT c.*, d.houseno, d.subarea, d.area, d.province, d.postalcode FROM accounts c INNER JOIN address d ON (c.username=d.username) ORDER BY c.username ASC";
$result=mysqli_query($conn,$sql);
$query_count=mysqli_num_rows($result);
$pdf->Cell(0,0,'บัญชีทั้งหมด '.$query_count.' บัญชี',0,0,'R');
$pdf->Ln(8);
$pdf->SetFont('Angsana','',16);
$pdf->Cell(15,10,'','LTB',0,'C');
$pdf->Cell(30,10,'ชื่อผู้ใช้','LTB',0,'C');
$pdf->Cell(55,10,'ชื่อ-นามสกุล','LTB',0,'C');
$pdf->Cell(70,10,'อีเมล์','LTB',0,'C');
$pdf->Cell(25,10,'เบอร์โทร','LTB',0,'C');
$pdf->Cell(81,10,'ที่อยู่','LTRB',1,'C');
$pdf->SetWidths(array(15, 30, 55, 70, 25, 81));
$daily=date("Y-m-d");
if(mysqli_num_rows($result)==0){
$pdf->Cell(276,10,'ไม่มีรายชื่อสมาชิก','LTRB',1,'C');
}else{	
$count=1;
while($row=mysqli_fetch_array($result)){
$border = array('TLB', 'TLB', 'TLB','TLB', 'TLB', 'TLBR');
$align = array('C', 'L', 'L', 'L', 'C', 'L');
$style = array('', '', '', '', '', '');
$empty = array(''.$count.'', ''.$row["username"].'',''.$row["name"].' '.$row["lastname"],''.$row["email"].'',''.$row["tel"].'',''.$row["houseno"].' '.$row["subarea"].' '.$row["area"].' '.$row["province"].' '.$row["postalcode"].'',);
$pdf->FancyRow($empty, $border, $align, $style);
$count++;
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT PORTFOLIO
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="portfolioprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 6;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 12*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'ผลงานทั้งหมด',0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','',16);
$pdf->Cell(10,10,'','LTB',0,'C');
$pdf->Cell(120,10,'รูปภาพ','LTB',0,'C');
$pdf->Cell(60,10,'ชื่อผลงาน','LTBR',1,'C');
$pdf->SetWidths(array(10, 120, 60));
$daily=date("Y-m-d");
$sql="SELECT * FROM portfolio";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีผลงาน','LTRB',1,'C');
}else{	
$count=1;
while($row=mysqli_fetch_array($result)){
$border = array('TLB', 'TLB', 'TLBR');
$align = array('C', 'C', 'C');
$style = array('', '', '');
$empty = array(''.$count.'', '', ''.$row["detail"].'');
$x=$pdf->GetX();
$y=$pdf->GetY();
$filename=$row['id'].'.jpg';
$f = base64_decode(base64_encode($row["image"]));
file_put_contents($filename,$f);
if(file_exists($filename)) 
{
$pdf->Image($filename,$x+15,$y+3.5,110,65);
}
$pdf->FancyRow($empty, $border, $align, $style);
if ($y  >= 150 && $count==3 || $count==6) {
	$pdf->AddPage();
}
$count++;
}
}
$pdf->Output();
}
}
//----------------
// ADMIN PRINT BOOKING_NAME
//----------------
if(isset($_SESSION["login"]) && isset($_GET["mode"])){
if(($_SESSION["status"]==1) && ($_GET["mode"]=="bookingnameprint")){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
function WordWrap(&$text, $maxwidth)
{
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($wordwidth > $maxwidth)
            {
                // Word is too long, we cut it
                for($i=0; $i<strlen($word); $i++)
                {
                    $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                    if($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth;
                        $text .= substr($word, $i, 1);
                    }
                    else
                    {
                        $width = $wordwidth;
                        $text = rtrim($text)."\n".substr($word, $i, 1);
                        $count++;
                    }
                }
            }
            elseif($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = rtrim($text)."\n".$word.' ';
                $count++;
            }
        }
        $text = rtrim($text)."\n";
        $count++;
    }
    $text = rtrim($text);
    return $count;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,0,'SYSTEMBOARD',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'ระบบนัดหมาย',0,1,'C');
$pdf->Ln(8);
$pdf->Cell(0,0,'รายการเรื่องที่นัดหมายทั้งหมด',0,1,'C');
$pdf->Ln(8);
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(10,10,'#','LTB',0,'C');
$pdf->Cell(130,10,'ชื่อเรื่องนัดหมาย','LTBR',0,'L');
$pdf->Cell(50,10,'จำนวนครั้งที่นัดหมาย','LTBR',1,'C');
$pdf->SetWidths(array(10, 130, 50));
$daily=date("Y-m-d");
$sql="SELECT * FROM booking_name";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
$pdf->Cell(190,10,'ไม่มีรายการชื่อเรื่องนัดหมาย','LTRB',1,'C');
}else{	
$count=1;
$counting=0;
while($row=mysqli_fetch_array($result)){
$border = array('TLB', 'TLB', 'TLBR');
$align = array('C', 'L', 'C');
$style = array('', '', '');
$empty = array(''.$row["id"].'', ''.$row["name"].'', ''.$row["count"].'');
$pdf->FancyRow($empty, $border, $align, $style);
$counting=($counting+$row["count"]);
$booking_name_array[] = $row["count"];
}
$booking_count_max=Max($booking_name_array);
$booking_count_min=Min($booking_name_array);
$sql5="SELECT * FROM booking_name WHERE count in (".$booking_count_max.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
$booking_name_array_max[] = $row5["name"];
}
$booking_name_max = implode(',', $booking_name_array_max);
$sql5="SELECT * FROM booking_name WHERE count in (".$booking_count_min.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
$booking_name_array_min[] = $row5["name"];
}
$booking_name_min = implode(',', $booking_name_array_min);
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(140,10,'รวมทั้งหมด','LTRB',0,'C');
$pdf->Cell(50,10,$counting,'LTRB',1,'C');
$pdf->SetFont('Angsana','B',16);
$pdf->Write(10,"นัดหมายมากที่สุดคือ ");
$pdf->SetFont('Angsana','',16);
$pdf->Write(10,"".$booking_name_max."\n");
$pdf->SetFont('Angsana','B',16);
$pdf->Write(10,"นัดหมายน้อยที่สุดคือ ");
$pdf->SetFont('Angsana','',16);
$pdf->Write(10,"".$booking_name_min."");
}
$pdf->Output();
}
}
//----------------------------------
// USER AND ADMIN PRINT ONE BOOKING
//----------------------------------
if(isset($_SESSION["login"]) && isset($_GET["pid"])){
require('_function/fpdf.php');
require("_db/connectAnsi.php");
require("_function/dateconvertAnsi.php");
$id=$_GET["pid"];
$username=$_SESSION["login"];
if($_SESSION["status"]==1){
$sql="SELECT b.*,booking_time.name AS time_name,accounts.name,accounts.lastname,accounts.tel FROM booking b INNER JOIN accounts ON(accounts.username=b.username) INNER JOIN booking_time ON(b.time_id=booking_time.id)WHERE b.id='$id'";
}else{
$sql="SELECT b.*,booking_time.name AS time_name,accounts.name,accounts.lastname,accounts.tel FROM booking b INNER JOIN accounts ON(accounts.username=b.username) INNER JOIN booking_time ON(b.time_id=booking_time.id)WHERE b.username='$username' AND b.id='$id'";
}
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0 ){
$row=mysqli_fetch_assoc($result);
if(trim($row["note"])==""){
	$row["note"]="ไม่มีหมายเหตุ";
}
class PDF extends FPDF
{
var $widths;
var $aligns;
function FancyRow($data, $border=array(), $align=array(), $style=array(), $maxline=array())
    {
        //Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
        }
        if (count($maxline)) {
            $_maxline = max($maxline);
            if ($nb > $_maxline) {
                $nb = $_maxline;
            }
        }
        $h = 10*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i]==1) {
                $this->Rect($x,$y,$w,$h);
            } else {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L')!==false) {
                    $this->Line($x, $y, $x, $y+$h);
                }
                if (strstr($_border, 'R')!==false) {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }
                if (strstr($_border, 'T')!==false) {
                    $this->Line($x, $y, $x+$w, $y);
                }
                if (strstr($_border, 'B')!==false) {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }
            }
            // Setting Style
            if (isset($style[$i])) {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 10, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
define('FPDF_FONTPATH','fonts/fpdf/');
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddFont('Angsana','','angsa.php');
$pdf->AddFont('Angsana','B','angsab.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Angsana','B',22);
$pdf->Cell(0,10,'SYSTEMBOARD',0,0,'L');
$pdf->Cell(-190,10,'ใบนัดหมาย',0,0,'C');
$pdf->Cell(0,10,"เลขที่ : #".$row["id"],0,1,'R');
$pdf->SetFont('Angsana','',19);
$pdf->Cell(0,10,'พาต้าปิ่นเกล้า ชั้น 4 ห้อง 5',0,0,'L');
$pdf->Cell(0,10,"ชื่อ-นามสกุล : ".$row["name"]." ".$row["lastname"],0,1,'R');
$pdf->Cell(0,10,'แขวงบางยี่ขัน เขตบางพลัด กรุงเทพฯ 10700',0,0,'L');
$pdf->Cell(0,10,"เบอร์โทร : ".$row["tel"],0,1,'R');
$pdf->SetFont('Angsana','B',16);
$pdf->Ln(10);
$pdf->Cell(0,10,'ข้อมูลใบนัดหมาย',1,1,'C');
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(50,10,'วันที่นัดหมาย : ','LBR',0,'R');
$pdf->SetFont('Angsana','',16);
$pdf->Cell(140,10,dateConvert($row["date"]),'BR',1,'L');
$pdf->SetFont('Angsana','B',16);
$pdf->Cell(50,10,'เวลาที่ต้องการนัด : ','LBR',0,'R');
$pdf->SetFont('Angsana','',16);
$pdf->Cell(140,10,$row["time_name"],'BR',1,'L');
$booking_name_check=explode("," ,$row["check"]);
$check=implode(",",$booking_name_check);
$sql5="SELECT * FROM booking_name WHERE id in (".$check.")";
$result5=mysqli_query($conn,$sql5);
$booking_name_array = array();
while ($row5=mysqli_fetch_array($result5)) {
  $booking_name_array[] = $row5["name"];
}
$booking_name = implode(' ', $booking_name_array);
$border = array('TLB', 'TLBR');
$align = array('R', 'L');
$style = array('B', '',);
$empty = array('เรื่องที่นัดหมาย : ', ''.$booking_name.'');
$pdf->SetWidths(array(50, 140));
$pdf->FancyRow($empty, $border, $align, $style);
$border = array('TLB', 'TLBR');
$align = array('R', 'L');
$style = array('B', '',);
$empty = array('หมายเหตุ : ', ''.$row["note"].'');
$pdf->SetWidths(array(50, 140));
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->SetFont('Angsana','',16);
$pdf->setFillColor(255,250,205);
$pdf->Cell(0,10,'สอบถามเพิ่มเติม โทร : 086-661-2181','LR',1,'C');
$pdf->Cell(0,10,'กรุณานำใบนัดหมายนี้ไปยืนยันกับพนักงานหน้าร้านเพื่อเป็นหลักฐาน','1',1,'C',1);
$pdf->SetTitle('SYSTEMBOARD PRINT');
$pdf->Output();
}else{
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../demo">';
	exit();
}
}else{
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../demo">';
	exit();
}
?>