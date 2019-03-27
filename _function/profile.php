<?php
require("_db/connect.php");
if(isset($_SESSION["login"])){
$profile_username=$_SESSION["login"];
$sql="SELECT a.*, address.houseno, address.subarea, address.area, address.province, address.postalcode FROM accounts a INNER JOIN address ON(a.username=address.username) WHERE a.username='$profile_username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
}
?>
