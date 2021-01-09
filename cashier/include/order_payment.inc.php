<?php  
include("../../includes/connect.php");

if (isset($_POST['paymentBtnSubmit'])) {
	$payment = $_POST['inputPayment'];
	$order_id = $_POST['id'];

	$q = mysqli_query($conn,"SELECT * FROM food_order where order_id='$order_id' ");
	while ($qq = mysqli_fetch_array($q)) {
		if ($qq['order_amount'] != $payment) {
			echo "Full payment is required.";
		} else {
			$setPayment = mysqli_query($conn,"UPDATE food_order set order_amount='$payment', status='approve' where order_id='$order_id'");

			if ($setPayment == true) {
				echo "Added payment successfully!";
			}
		}
	}
}
?>