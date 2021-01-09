<?php
include '../../includes/connect.php';

	if (isset($_POST['id'])) {

		$id = $_POST['id'];

		$delete = mysqli_query($conn,"DELETE FROM food_order where order_id = '$id'");
		if ($delete  == true) {
			mysqli_query($conn,"DELETE FROM pick_up_details where order_id = '$id'");
			mysqli_query($conn,"DELETE FROM delivery_detail where order_id = '$id'");
			mysqli_query($conn,"DELETE FROM food_order_details where order_id = '$id'");
		}
		echo "Deleted";
	}