<?php 
	include '../../includes/connect.php';
	session_start();



	if (isset($_POST['cancel'])) {
		$rid_in = $_POST['cancel_id_r'];
		
		$sql = mysqli_query($conn,"SELECT * FROM reservation where rid = '$rid_in'");
		$row = mysqli_fetch_array($sql);

		if ($row['r_status'] == "Approve" || $row['r_status'] == "Finish") {
			echo "This reservation is already ".$row['r_status'].". \n Do you really to proceed?";
		} else {
			$cancel = mysqli_query($conn,"UPDATE reservation set r_status = 'cancel' where rid = '$rid_in'") or die(mysqli_error($conn));

			if ($cancel == true) {
				echo "Cancelled!";
			} 
		}
	}

	if (isset($_POST['cancety']) && $_POST['cancety'] == "YES") {
		$rid_in = $_POST['cancel_id_r'];

		$cancel = mysqli_query($conn,"UPDATE reservation set r_status = 'cancel' where rid = '$rid_in'") or die(mysqli_error($conn));

		if ($cancel == true) {
			echo "Cancelled!";
		} 
	}
 ?>