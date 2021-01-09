<?php  
include '../../includes/connect.php';

if (isset($_POST['id'])) {
	$food_id = $_POST['food_id'];
	$qty = $_POST['qty'];
	$r_id = $_POST['r_id'];

	$q = mysqli_query($conn,"SELECT * FROM add_ons where r_id='$r_id' ");

	if (mysqli_num_rows($q) > 0) {
		while ($qq = mysqli_fetch_array($q)) {
			if ($food_id == $qq['food_id']) {
				$qty2 = $qq['food_qty'] + $qty;
				mysqli_query($conn,"UPDATE add_ons set food_qty = '$qty2' where r_id = '$r_id' and food_id = '".$qq['food_id']."' ");
			} 
		}
	} else {
		mysqli_query($conn,"INSERT INTO add_ons (r_id, food_id, food_qty) values ('$r_id','$food_id','$qty') ");
	}

	$s = mysqli_query($conn,"SELECT * FROM add_ons where r_id = '$r_id' and food_id='$food_id' ");
	if (mysqli_num_rows($s) > 0) {
		mysqli_query($conn,"UPDATE add_ons set food_qty = '$qty2' where r_id = '$r_id' and food_id = '".$qq['food_id']."' ");
	} else {
		mysqli_query($conn,"INSERT INTO add_ons (r_id, food_id, food_qty) values ('$r_id','$food_id','$qty') ");
	}		
	echo "Update";
}

if (isset($_POST['delet'])) {

	$food_id = $_POST['food_id'];
	$r_id = $_POST['r_id'];

	mysqli_query($conn,"DELETE from add_ons where food_id='$food_id' and r_id='$r_id' ");
	echo "Delete";
}


if (isset($_POST['update'])) {
	$food_id = $_POST['food_id'];
	$r_id = $_POST['r_id'];
	$quantity = $_POST['quantity'];

	if ($quantity == 0) {
		mysqli_query($conn,"DELETE from add_ons where food_id='$food_id' and r_id='$r_id' ");
	}
	mysqli_query($conn,"UPDATE add_ons set food_qty='$quantity' where food_id='$food_id' and r_id='$r_id' ");
	echo "Bley Bley";
}
?>