<?php 	
    $host = "localhost";
	$user = "root";
	$pass = "";
	$db = "tugkaran";

	$conn = mysqli_connect($host,$user,$pass,$db);

	if (!$conn) {
	die("Error connection:".mysqli_connect_error($conn));
	}
 ?>