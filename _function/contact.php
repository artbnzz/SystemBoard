<?php
require("_db/connect.php");
if(isset($_SESSION["login"])){
$contact_username=$_SESSION["login"];
$sql_contact="SELECT * FROM accounts WHERE username='$contact_username'";
$result_contact = mysqli_query($conn, $sql_contact);
$contact = mysqli_fetch_assoc($result_contact);
}
?>