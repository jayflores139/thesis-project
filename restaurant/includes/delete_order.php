<?php  
include 'connect.php';
session_start();

if (isset($_GET['ids'])) {
	$hidden = $_GET['hidden'];

	mysqli_query($conn,"DELETE FROM food_order_details where order_id = '$hidden'") or die(mysqli_error($conn));
	mysqli_query($conn,"DELETE FROM pick_up_details where order_id = '$hidden'");
	mysqli_query($conn,"DELETE FROM delivery_detail where order_id = '$hidden'");
	mysqli_query($conn,"DELETE FROM food_order_details where order_id = '$hidden'");
	
	$delete =  mysqli_query($conn,"DELETE FROM food_order where  order_id = '$hidden'");
	if ($delete == true) {
		echo "Deleted!";
	}
}

if (isset($_GET['id'])) {
	$input = $_GET['input'];
	
	$delete =  mysqli_query($conn,"DELETE FROM food_order where  order_id = '$input'");

	mysqli_query($conn,"DELETE FROM food_order_details where order_id = '$input'") or die(mysqli_error($conn));
	mysqli_query($conn,"DELETE FROM pick_up_details where order_id = '$input'");
	mysqli_query($conn,"DELETE FROM delivery_detail where order_id = '$input'");
	mysqli_query($conn,"DELETE FROM food_order_details where order_id = '$input'");
	
	if ($delete == true) {
		echo "Deleted!";
	}
}
?>