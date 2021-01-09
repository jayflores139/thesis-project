<?php
		session_start();
		include 'connect.php';

	$id_user = $_SESSION['id_user'];

	$b = mysqli_query($conn,"SELECT * FROM menu_limit ");
    $bb = mysqli_fetch_array($b);

	$limitMenu = $bb['MenuLimit'];

	if (isset($_POST['submit_1'])) {

		$user = mysqli_query($conn,"SELECT * FROM users where id = '$id_user' ");
		$userI = mysqli_fetch_array($user);

		$fname = $userI['firstname'];
		$lname = $userI['lastname'];
		$address = $_POST['address'];
		$cnum = $_POST['cnum'];
		$email = $_POST['email'];

		$today = date("Y-m-d");

		$query = mysqli_query($conn,"INSERT INTO reservation (cu_first, cu_last, cu_add, cu_mail, cu_phone, date_reserved) values ('$fname', '$lname', '$address', '$email', '$cnum', '$today')") or die(mysqli_error($conn));
		if ($query) {
			$last_id = mysqli_insert_id($conn);
			$_SESSION['lat_rid'] = $last_id;
			header("Location:../make_reservation_.php");
		}
	}

	if (isset($_POST['submit_2'])) {

		$occasion = $_POST['occasion'];
		$totalvisit = $_POST['totalvisit'];

		$booking_date_from = $_POST['bookdatefrom'];
		$booking_date_to = $_POST['bookdateto'];

		$booking_date_FROM = date("Y-m-d",strtotime($booking_date_from));
		$booking_date_TO = date("Y-m-d",strtotime($booking_date_to));

		$today = date("Y-m-d");
		$valid_booking_date = date("Y-m-d",strtotime($today."+ 4 days"));

		$payment_date = date("Y-m-d" ,strtotime($booking_date_FROM."-4 days"));

		$dd = mysqli_query($conn,"SELECT * from reservation where r_status='approve'  ") or die(mysqli_error($conn));

		$find = false;
		while ($ddd = mysqli_fetch_array($dd)) {
			
			$from = $ddd['r_date_from'];
			$to = $ddd['r_date_to'];

			if ($booking_date_FROM >= $from && $booking_date_TO <= $to) {
				echo '<script>alert("Booking date is already reserved!");history.back()</script>';

				$find = true;
			}
			else {
				$find = false;
			}
		}
		if ($booking_date_FROM <= $today || $booking_date_TO <= $today) {
			echo '<script>alert("Invalid booking date!\nBooking date should be 4 days advance from current date!");history.back()</script>';
			$find = true;
		}
		elseif ($booking_date_FROM < $valid_booking_date || $booking_date_TO < $valid_booking_date) {
			echo '<script>alert("Invalid booking date!\nBooking date should be 4 days advance from current date!");history.back()</script>';
			$find = true;
		}
		elseif ($booking_date_FROM > $booking_date_TO) {
			echo '<script>alert("Invalid booking date!");history.back()</script>';

			$find = true;
		}

		if ($find == false) {
			$catering = mysqli_query($conn,"SELECT * FROM catering where cater_id = '$occasion'") or die(mysqli_error($conn));
			$cater_row = mysqli_fetch_array($catering);
			$price = $cater_row['p_head'];
			$payable = $totalvisit * $price;
				
			if (isset($_POST['food_id'])) {
				if (count($_POST['food_id']) != $limitMenu) {
					echo '<script>alert("The menu limit is '.$limitMenu.' only!");history.back()</script>';
				} else {
					foreach ($_POST['food_id'] as $value) {
						mysqli_query($conn,"INSERT INTO custom_r (r_id, food_id) values ('".$_SESSION['lat_rid']."', '$value')") or die(mysqli_error($conn));
					}

					$last_query = mysqli_query($conn,"UPDATE reservation set cater_id = '$occasion', cu_id = '$id_user', r_date_from = '$booking_date_FROM', r_date_to = '$booking_date_TO', total_visitor = '$totalvisit', payable = '$payable', balance = '$payable', r_status = 'pending' where rid = '".$_SESSION['lat_rid']."' ") or die(mysqli_error($conn));
					if ($last_query == true) {
						header("Location:../make_reservation_2.php");
					}
				}
			} else {
				$last_query = mysqli_query($conn,"UPDATE reservation set cater_id = '$occasion', cu_id = '$id_user', r_date_from = '$booking_date_FROM', r_date_to = '$booking_date_TO', total_visitor = '$totalvisit', payable = '$payable', balance = '$payable', r_status = 'pending' where rid = '".$_SESSION['lat_rid']."' ") or die(mysqli_error($conn));
				if ($last_query == true) {
					header("Location:../make_reservation_2.php");
				}
			}
		}
	} 

	if (isset($_POST['submit_last'])) {
		
		$mode_of_payment = $_POST['mode_of_payment'];

		$last_query = mysqli_query($conn,"UPDATE reservation set mode_of_payment = '$mode_of_payment' where rid = '".$_SESSION['lat_rid']."'") or die(mysqli_error($conn));

		if ($last_query == true) {
				header("Location:../reservation_summary.php");
			} else {
				unset($_SESSION['lat_rid']);
			}
	}
?>