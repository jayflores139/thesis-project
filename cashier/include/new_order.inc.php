<?php  
include '../../includes/connect.php';

if (isset($_POST['id'])) {
	$food_id = $_POST['food_id'];
	$qty = $_POST['qty'];
	$order_id = $_POST['order_id'];

	$q = mysqli_query($conn,"SELECT * FROM food_order_details where order_id='$order_id' ");

	if (mysqli_num_rows($q) > 0) {
		while ($qq = mysqli_fetch_array($q)) {
			if ($food_id == $qq['food_id']) {
				$qty2 = $qq['food_qty'] + $qty;
				mysqli_query($conn,"UPDATE food_order_details set food_qty = '$qty2' where order_id = '$order_id' and food_id = '".$qq['food_id']."' ");
			} 
		}
	} else {
		mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$order_id','$food_id','$qty') ");
	}

	$s = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '$order_id' and food_id='$food_id' ");
	if (mysqli_num_rows($s) > 0) {
		mysqli_query($conn,"UPDATE food_order_details set food_qty = '$qty2' where order_id = '$order_id' and food_id = '".$qq['food_id']."' ");
	} else {
		mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$order_id','$food_id','$qty') ");
	}		
	echo "Update";
}

if (isset($_POST['delet'])) {

	$food_id = $_POST['food_id'];
	$order_id = $_POST['order_id'];

	mysqli_query($conn,"DELETE from food_order_details where food_id='$food_id' and order_id='$order_id' ");
	echo "Delete";
}


if (isset($_POST['update'])) {
	$food_id = $_POST['food_id'];
	$order_id = $_POST['order_id'];
	$quantity = $_POST['quantity'];

	if ($quantity == 0) {
		mysqli_query($conn,"DELETE from food_order_details where food_id='$food_id' and order_id='$order_id' ");
	}
	mysqli_query($conn,"UPDATE food_order_details set food_qty='$quantity' where food_id='$food_id' and order_id='$order_id' ");
	echo "Bley Bley";
}
?>