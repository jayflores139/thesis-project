<?php  
	include '../../includes/connect.php';
	session_start();

	$test = false;
	if (isset($_POST['delelte'])) {
		$id = $_POST['delelte'];


		$delete = mysqli_query($conn,"DELETE from reservation where rid='$id'") or die(mysqli_error($conn));

		if ($delete == true) {
			mysqli_query($conn,"DELETE from custom_r where r_id='$id'") or die(mysqli_error($conn));
			echo "Deleted";
		}

	}
?>