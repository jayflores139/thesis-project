<?php  
session_start();
include('connect.php');

$user_id = $_SESSION['id_user'];

$pick_handler = false;
$dine_handler = false;
$delivery = false;
$takeout_handler = false;

$invoice = mt_rand(100000, 999999);

$VAT = 0;

$today = date("Y-m-d");

if (isset($_POST['submitDELIVERY'])) {
	
	$HOUSESTREET = $_POST['HOUSESTREET'];
	$DELIVERY = $_POST['DELIVERY'];

	$DELIVERY_date = $_POST['DELIVERY_date'];

	$HOUR = $_POST['HOUR'];
	$MINUTE = $_POST['MINUTE'];
	$AMPM = $_POST['AMPM'];

	$MODEofPAYMENT = $_POST['MODEofPAYMENT'];
	$BARANGAY = $_POST['BARANGAY'];
	$HOUSESTREET = $_POST['HOUSESTREET'];

	$time = date_create("$HOUR:$MINUTE $AMPM");
	$transaction_time = date_format($time, "h:i A");
	$transaction_date = date("Y-m-d", strtotime($DELIVERY_date));

	if ($transaction_date < $today) {
		echo "Invalid delivery date!";
	} else {
		$query = mysqli_query($conn,"INSERT INTO food_order (user_id, customer_type, curr_order_date, order_time, order_date, payment_mode, order_type, status, invoice_num) values ('$user_id', 'junior', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'delivery', 'pending', '$invoice')") or die(mysqli_error($conn));
		if ($query == true) {
			$last_id = mysqli_insert_id($conn);
			$_SESSION['last_id_order'] = $last_id;
		}
		if (!empty($_SESSION['shopping_cart'])) {
			$total = 0;
			foreach ($_SESSION['shopping_cart'] as $key => $value) {
				mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");
				$total = $total + (($value['quantity'] * $value['price']) + ($value['quantity'] * $value['price'] * $VAT) );
			}
			$dd = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '$BARANGAY'") or die(mysqli_error($conn));
			while ($ddd = mysqli_fetch_array($dd)) {
				$order_amount = $ddd['deliv_charge'] + $total;
				$last_querys = mysqli_query($conn,"UPDATE food_order set order_amount = '$order_amount' where order_id = '$last_id'");
				mysqli_query($conn,"INSERT INTO delivery_detail (bd_id, house_street, order_id) values ('$BARANGAY', '$HOUSESTREET', '$last_id')");
				if ($last_querys) {
					$delivery = true;
				}
			}
		}

	}
	if ($delivery == true) {
		echo "Your order was successfully done!\nThank you.";
		unset($_SESSION['shopping_cart']);
	}

}
if (isset($_POST['submitDINEIN'])) {

	$DINEIN = $_POST['DINEIN'];

	$DINEIN_date = $_POST['DINEIN_date'];

	$HOUR = $_POST['HOUR'];
	$MINUTE = $_POST['MINUTE'];
	$AMPM = $_POST['AMPM'];

	$MODEofPAYMENT = $_POST['MODEofPAYMENT'];

	$time = date_create("$HOUR:$MINUTE $AMPM");
	$transaction_time = date_format($time, "h:i A");
	$transaction_date = date("Y-m-d", strtotime($DINEIN_date));

	if ($transaction_date < $today) {
		echo "Invalid dine-in date!";
	} else {
		$query = mysqli_query($conn,"INSERT INTO food_order (user_id, customer_type, curr_order_date, order_time, order_date, payment_mode, order_type, status, invoice_num) values ('$user_id', 'junior', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'dinein', 'pending', '$invoice')");
		if ($query) {
			$last_ids = mysqli_insert_id($conn);
			$dine_handler = true;
			$_SESSION['last_id_order'] = $last_ids;
		}
		if (!empty($_SESSION['shopping_cart'])) {
			$total = 0;
			foreach ($_SESSION['shopping_cart'] as $key => $value) {
				mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_ids', '".$value['id']."', '".$value['quantity']."')");
				$total = $total + (($value['quantity'] * $value['price']) + ($value['quantity'] * $value['price'] * $VAT) );
			}
			$last_querys = mysqli_query($conn,"UPDATE food_order set order_amount = '$total' where order_id = '$last_ids'");
			if ($last_querys) {
				$dine_handler = true;
			}
		}

	}
	if ($dine_handler == true) {
		echo "Your order was successfully done!\nThank you.";
		unset($_SESSION['shopping_cart']);
	}
}
if (isset($_POST['submitTAKEOUT'])) {

	$TAKEOUT = $_POST['TAKEOUT'];

	$TAKEOUT_date = $_POST['TAKEOUT_date'];

	$HOUR = $_POST['HOUR'];
	$MINUTE = $_POST['MINUTE'];
	$AMPM = $_POST['AMPM'];

	$MODEofPAYMENT = $_POST['MODEofPAYMENT'];

	$time = date_create("$HOUR:$MINUTE $AMPM");
	$transaction_time = date_format($time, "h:i A");
	$transaction_date = date("Y-m-d", strtotime($TAKEOUT_date));

	if ($transaction_date < $today) {
		echo "Invalid take out date!";
	} else {
		$query = mysqli_query($conn,"INSERT INTO food_order (user_id, customer_type, curr_order_date, order_time, order_date, payment_mode, order_type, status, invoice_num) values ('$user_id', 'junior', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'takeout', 'pending', '$invoice')");
		if ($query) {
			$last_ids = mysqli_insert_id($conn);
			$dine_handler = true;
			$_SESSION['last_id_order'] = $last_ids;
		}
		if (!empty($_SESSION['shopping_cart'])) {
			$total = 0;
			foreach ($_SESSION['shopping_cart'] as $key => $value) {
				mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_ids', '".$value['id']."', '".$value['quantity']."')");
				$total = $total + (($value['quantity'] * $value['price']) + ($value['quantity'] * $value['price'] * $VAT) );
			}
			$last_querys = mysqli_query($conn,"UPDATE food_order set order_amount = '$total' where order_id = '$last_ids'");
			if ($last_querys) {
				$takeout_handler = true;
			}
		}

	}
	if ($takeout_handler == true) {
		echo "Your order was successfully done!\nThank you.";
		unset($_SESSION['shopping_cart']);
	}
}
if (isset($_POST['submitPICKUP'])) {

	$PICKUP = $_POST['PICKUP'];

	$PICKUP_date = $_POST['PICKUP_date'];

	$HOUR = $_POST['HOUR'];
	$MINUTE = $_POST['MINUTE'];
	$AMPM = $_POST['AMPM'];


	$MODEofPAYMENT = $_POST['MODEofPAYMENT'];

	$time = date_create("$HOUR:$MINUTE $AMPM");
	$transaction_time = date_format($time, "h:i A");
	$transaction_date = date("Y-m-d", strtotime($PICKUP_date));

	if ($transaction_date < $today) {
		echo "Invalid Pick up date!";
	} else {
		$query = mysqli_query($conn,"INSERT INTO food_order (user_id, customer_type, curr_order_date, order_time, order_date, payment_mode, order_type, status, invoice_num) values ('$user_id', 'junior', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'pickup', 'pending', '$invoice')");
		if ($query) {
			$last_ids = mysqli_insert_id($conn);
			$dine_handler = true;
			$_SESSION['last_id_order'] = $last_ids;
		}
		if (!empty($_SESSION['shopping_cart'])) {
			$total = 0;
			foreach ($_SESSION['shopping_cart'] as $key => $value) {
				mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_ids', '".$value['id']."', '".$value['quantity']."')");
				$total = $total + (($value['quantity'] * $value['price']) + ($value['quantity'] * $value['price'] * $VAT) );
			}
			$last_querys = mysqli_query($conn,"UPDATE food_order set order_amount = '$total' where order_id = '$last_ids'");
			if ($last_querys) {
				$pick_handler = true;
			}
		}

	}
	if ($pick_handler) {
		echo "Your order was successfully done!\nThank you.";
		unset($_SESSION['shopping_cart']);
	}
}