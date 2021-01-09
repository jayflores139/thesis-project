<?php 

include '../../includes/connect.php';

	$contact = $_POST['contact'];
	$con_id = $_POST['con_id'];

	mysqli_query($conn,"UPDATE contact set content = '$contact' where con_id = '$con_id' ");

	header("Location: ../contact.php");
