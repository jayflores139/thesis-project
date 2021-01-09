<?php  
	include 'connect.php';
	session_start();

	if (!isset($_SESSION['id_user'])) {
		header("Location:../login.php");
	} else {
		$id_user = $_SESSION['id_user'];
	}

	if (isset($_POST['rid'])) {
		$rid_in = $_POST['rid_in'];
		
		$cancel = mysqli_query($conn,"UPDATE reservation set r_status = 'cancel' where rid = '$rid_in'") or die(mysqli_error($conn));

		if ($cancel == true) {
			echo "Cancelled!";

		}
	}

	if (isset($_POST['ids'])) {
		$id_in = $_POST['id_in'];
		
		$delete = mysqli_query($conn,"DELETE FROM reservation where rid = '$id_in'") or die(mysqli_error($conn));

		if ($delete == true) {
			echo "Deleted!";
			mysqli_query($conn,"DELETE FROM custom_r where r_id = '$id_in'") or die(mysqli_error($conn));
		}
	}
?>