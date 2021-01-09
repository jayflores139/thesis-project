<?php

include 'connect.php';

if (isset($_POST['bd_id'])) {
	$bd_id = $_POST['bd_id'];

	$q = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '$bd_id' ");
	while ($qq = mysqli_fetch_array($q)) {
		echo 'P '.number_format($qq['deliv_charge'],2).'.';		
	}
}