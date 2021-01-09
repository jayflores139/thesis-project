<?php  
include '../../includes/connect.php';

if (isset($_POST['order_id'])) {
	$order_id = $_POST['order_id'];

	$q = mysqli_query($conn,"UPDATE food_order set status = 'cancel' where order_id = '$order_id' ");

	if ($q == true) {
		echo "Cancel";
	}
}
?>