<?php
		if(!defined("_host")){
		DEFINE("_host","localhost"); 
		DEFINE("_db_user","root"); 
		DEFINE("_db_pass","123456789"); 
		DEFINE("_db_name","systemboard");
		}
		$servername = "localhost";
		$username = "root";
		$password = "123456789";
		$dbname = "systemboard";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) die("Connection failed: " . mysqli_connect_error());
?>