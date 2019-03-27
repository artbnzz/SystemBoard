<?
		$servername = "localhost";
		$username = "root";
		$password = "123456789";
		$dbname = "systemboard";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) die("Connection failed: " . mysqli_connect_error());
		mysqli_query($conn,"set names tis620");
?>