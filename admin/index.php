<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["status"]!=1){
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../">';
	exit();
}
if(empty($_GET)){
	require_once("_use/checkstatus.php");
}
elseif(isset($_GET["p"])){
	require_once("_use/checkstatus.php");
}
elseif(isset($_GET["page"])){
	if($_GET["page"]=="update" ){
		require_once("_use/updatestatus.php");
	}
	if($_GET["page"]=="daily" || $_GET["page"]=="weekly" || $_GET["page"]=="monthly" || $_GET["page"]=="yearly"){
		require_once("_use/checkstatus.php");
	}
	if($_GET["page"]=="portfolio" || $_GET["page"]=="manageport"){
		require_once("_use/portfolio.php");
	}
	if($_GET["page"]=="member"){
		require_once("_use/member.php");
	}
	if($_GET["page"]=="managebooking"){
		require_once("_use/managebooking.php");
	}
}
elseif(empty($_GET["s_id"]) || empty($_GET["s_tel"])){
	require_once("_use/updatestatus.php");
}
elseif(isset($_GET["s_id"]) || isset($_GET["s_tel"])){
	require_once("_use/updatestatus.php");
}
?>
