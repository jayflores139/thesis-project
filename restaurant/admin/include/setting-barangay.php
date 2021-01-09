<?php  

include "../../includes/connect.php";

if (isset($_POST['id'])) {
	
	$id = $_POST['id'];

	$q = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '$id' ");

	$qq = mysqli_fetch_array($q);

	$array = array(
		'barangay' => $qq['barangay'], 
		'charge' =>  $qq['deliv_charge']
	);

	echo json_encode($array);
}

if (isset($_POST['submit_add'])) {
	
	$barangay = $_POST['barangay'];
	$charge = $_POST['charge'];

	$w = mysqli_query($conn,"INSERT INTO barangay_delivery (barangay, deliv_charge) VALUES ('$barangay', '$charge') ");

	if ($w == true) {
		echo "Inserted";
	}
}

if (isset($_POST['submit_edit'])) {
	$barangay = $_POST['barangay'];
	$charge = $_POST['charge'];
	$bd_id = $_POST['bd_id_edit'];

	$e = mysqli_query($conn,"UPDATE barangay_delivery SET  barangay ='$barangay', deliv_charge ='$charge' where bd_id = '$bd_id' ");

	if ($e == true) {
		echo "Updated";
	}
}

if (isset($_POST['bd_id'])) {
	$bd_id = $_POST['bd_id'];

	$r = mysqli_query($conn,"DELETE FROM barangay_delivery where bd_id ='$bd_id' ");

	if ($r == true) {
		echo "Deleted";
	}
}