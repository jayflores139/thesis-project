<?php 
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['pending_btn'])) {

		$pending_input = $_POST['pending_input'];
		$pending_input_hidden = $_POST['pending_input_hidden'];

		$sql = mysqli_query($conn,"SELECT * FROM downpayment");
		$row = mysqli_fetch_array($sql);

		$sql2 = mysqli_query($conn,"SELECT * FROM reservation where rid = '$pending_input_hidden'");
		$row2 = mysqli_fetch_array($sql2);

		$TA = $row2['payable'];
		$downpayment = $TA - ($TA * $row['d_price']);
		
		if ($pending_input < $downpayment) {
			echo "Please pay 30% downpayment! The downpayment is '$downpayment'.";
		} elseif ($pending_input == $TA) {
				echo "Reservation finished!";

				$balance = $TA - $pending_input;
				$downNow = $balance + $pending_input;
				
				mysqli_query($conn,"UPDATE reservation set downpayment = '$downNow', balance = '$balance', r_status = 'finish' where rid = '$pending_input_hidden'") or die(mysqli_error($conn));

		} elseif ($pending_input >= $downpayment) {
			echo "Reservation approve!";

			$balance = $TA - $pending_input;

			mysqli_query($conn,"UPDATE reservation set downpayment = '$pending_input', balance = '$balance', r_status = 'approve' where rid = '$pending_input_hidden'") or die(mysqli_error($conn));
		} 
	}


	if (isset($_POST['approve_btn'])) {

		$approve_input = $_POST['approve_input'];
		$approve_input_hidden = $_POST['approve_input_hidden'];

		$sql2 = mysqli_query($conn,"SELECT * FROM reservation where rid = '$approve_input_hidden'");
		$row2 = mysqli_fetch_array($sql2);

		$balance = $row2['balance'];
		$downpayment = $row2['downpayment'];
	
		if ($approve_input < $balance) {
			echo "Please pay all your balance!";
		} elseif ($approve_input > $balance || $approve_input == $balance) {
			echo "Reservation finished!";

			$downpayment = $downpayment + $approve_input;
			$balanceNow = $balance - $approve_input;

			mysqli_query($conn,"UPDATE reservation set downpayment = '$downpayment', balance = '$balanceNow', r_status = 'finish' where rid = '$approve_input_hidden'") or die(mysqli_error($conn));
		} 
	}	

 ?>
