<?php  
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['del'])) {
		$id = $_POST['del_info'];


		$delete = mysqli_query($conn,"DELETE from catering where cater_id='$id'") or die(mysqli_error($conn));
		$delete2 = mysqli_query($conn,"DELETE from catering_details WHERE cater_id='$id'") or die(mysqli_error($conn));

		if ($delete == true && $delete2 == true) {
			echo "Deleted";
		}
		
		
	}
?>