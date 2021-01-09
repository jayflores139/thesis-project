<?php  
	

	include 'connect.php';
	session_start();
	$id_user = $_SESSION['id_user'];

	if (isset($_GET['cancel'])) {
		$o_id = $_GET['cancel'];

		$cancel = mysqli_query($conn,"UPDATE food_order set status = 'cancel' where order_id = '$o_id'") or die(mysqli_error($conn));
		if ($cancel == true) {
			echo '<script>window.history.back()</script>';
		}
	}
?>