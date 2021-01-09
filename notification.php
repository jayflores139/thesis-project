<?php
session_start();
include "includes/connect.php";

if (!isset($_SESSION['id_user'])) {
	header("Location:login.php");
} else {
	$id_user = $_SESSION['id_user'];	
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
		$ifempty = false;
?>

<div class="container w3-light-grey containersssss">
	<h3 class="w3-padding-large">Notifications</h3>

		<?php  
		$cc = 0;
	$q = mysqli_query($conn,"SELECT * FROM reservation where cu_id = '$id_user' ");


				$date = date("Y-m-d");
				$today = date("M d, Y");

				while ($qq = mysqli_fetch_array($q)) {

					$date_payment = date("Y-m-d", strtotime($qq['r_date_from'].'-4 days'));
					$date_payment2 = date("Y-m-d", strtotime($qq['r_date_from'].'-5 days')); 

					if ($date == $date_payment && $qq['r_status'] == "pending") {
						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						$e = mysqli_query($conn,"SELECT d_price from downpayment ");
						$ee = mysqli_fetch_array($e);
						$downpayment = $ee['d_price'] * 100;

						echo "<td class='w3-center'>Your reservation requires a ".$downpayment."% downpayment payment today ".$today.", that is 4 days before the reservation date. If you fail to pay the said payment your reservation will be cancel. Click <a href=reservation_view.php?id=".$qq['rid']." class='w3-text-blue'>here</a> to view your reservation.</td>";
						echo '</tr></table></div>';
						
						$ifempty = true;
						$cc += 1;
					} elseif ($date == $date_payment2 && $qq['r_status'] == "pending") {
						$tommorow = date("M d, Y", strtotime($date_payment2));
						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						$e = mysqli_query($conn,"SELECT d_price from downpayment ");
						$ee = mysqli_fetch_array($e);
						$downpayment = $ee['d_price'] * 100;

						echo "<td class='w3-center'>This is to remind you that your reservation requires a ".$downpayment."% downpayment tommorow ".$tommorow.", that is 4 days before the reservation date. If you fail to pay the said payment your reservation will be cancel. Click <a href=reservation_view.php?id=".$qq['rid']." class='w3-text-blue'>here</a> to view your reservation.</td>";
						echo '</tr></table></div>';

						$ifempty = true;
						$cc += 1;
					}

					if ($qq['r_status'] == "cancel") {
						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						$e = mysqli_query($conn,"SELECT d_price from downpayment ");
						$ee = mysqli_fetch_array($e);
						$downpayment = $ee['d_price'] * 100;

						echo "<td class='w3-center'>Your reservation is cancelled. Click <a href=reservation_view.php?id=".$qq['rid']." class='w3-text-blue'>here</a> to view your reservation.</td>";
						echo '</tr></table></div>';

						$ifempty = true;
						$cc += 1;
					}

					if ($qq['r_status'] == "approve") {
						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						$e = mysqli_query($conn,"SELECT d_price from downpayment ");
						$ee = mysqli_fetch_array($e);
						$downpayment = $ee['d_price'] * 100;

						echo "<td class='w3-center'>Your reservation is Approve but it is requires full payment before it can be finalized. Click <a href=reservation_view.php?id=".$qq['rid']." class='w3-text-blue'>here</a> to view your reservation.</td>";
						echo '</tr></table></div>';

						$ifempty = true;
						$cc += 1;
					} 

					if ($qq['r_status'] == "finish") {
						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						$e = mysqli_query($conn,"SELECT d_price from downpayment ");
						$ee = mysqli_fetch_array($e);
						$downpayment = $ee['d_price'] * 100;

						echo "<td class='w3-center'>Your reservation is complete . Click <a href=reservation_view.php?id=".$qq['rid']." class='w3-text-blue'>here</a> to view your reservation.</td>";
						echo '</tr></table></div>';

						$ifempty = true;
						$cc += 1;
					} 
				}

				$w = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' ");

				while ($ww = mysqli_fetch_array($w)) {

					$order_amount = number_format($ww['order_amount'], 2);

					$order_date_from_tom = date("Y-m-d", strtotime($ww['order_date'].'- 1 day'));

					$order_date_from_tod = date("Y-m-d", strtotime($ww['order_date']));

					$time = date("h:i A", strtotime($ww['order_time']));

					if ($date == $order_date_from_tod && $ww['order_type'] == 'delivery' && $ww['status'] == 'pending') {

						$today = date("M d, Y", strtotime($order_date_from_tod));

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your have an order to be deliver today, ".$today." at ".$time.". Please prepare P ".$order_amount." for your payment. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=delivery' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					} elseif ($date == $order_date_from_tom && $ww['order_type'] == 'delivery' && $ww['status'] == 'pending') {

						$tommow = date("M d, Y", strtotime($order_date_from_tod));

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your have an order to be deliver tommorow, ".$tommow." at ".$time.". Please prepare P ".$order_amount." for your payment. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=delivery' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					} elseif ($date == $order_date_from_tom && $ww['order_type'] == 'dinein' && $ww['status'] == 'pending') {

						$tommow = date("M d, Y", strtotime($order_date_from_tod));

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your have an order to be Dine-in tommorow, ".$tommow." at ".$time.". Please prepare P ".$order_amount." for your payment. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=dinein' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					} elseif ($date == $order_date_from_tod && $ww['order_type'] == 'dinein' && $ww['status'] == 'pending') {

						$today = date("M d, Y", strtotime($order_date_from_tod));

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your have an order to be Dine-in today, ".$today." at ".$time.". Please prepare P ".$order_amount." for your payment. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=dinein' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					} elseif ($date == $order_date_from_tod && $ww['order_type'] == 'pickup' && $ww['status'] == 'pending') {

						$today = date("M d, Y", strtotime($order_date_from_tod));

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your have an order to be Pick up today, ".$today." at ".$time.". Please prepare P ".$order_amount." for your payment. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=pickup' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					} elseif ($date == $order_date_from_tom && $ww['order_type'] == 'pickup' && $ww['status'] == 'pending') {

						$tommow = date("M d, Y", strtotime($order_date_from_tod));

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your have an order to be Pick up tommorow, ".$tommow." at ".$time.". Please prepare P ".$order_amount." for your payment. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=pickup' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					}

					if ($ww['status'] == 'cancel' && $ww['order_type'] == 'pickup') {

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your order is cancelled. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=pickup' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';

						$ifempty = true;
						$cc += 1;

					} elseif ($ww['status'] == 'cancel' && $ww['order_type'] == 'dinein') {

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your order is cancelled. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=dinein' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;

					}
					elseif ($ww['status'] == 'cancel' && $ww['order_type'] == 'delivery') {

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your order is cancelled. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=delivery' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					}

					if ($ww['status'] == 'approve' && $ww['order_type'] == 'pickup') {

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your order is Approve. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=pickup' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;

					} elseif ($ww['status'] == 'approve' && $ww['order_type'] == 'dinein') {

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your order is Approve. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=dinein' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					}
					elseif ($ww['status'] == 'approve' && $ww['order_type'] == 'delivery') {

						echo '
						<div class="alert alert-info">
						<table>
						<tr>
						<td width="5%"><span class="fas fa-info-circle w3-large w3-left"></span></td>
						<td width="15%">'.date("M d, Y").'</td>';

						echo "<td class='w3-center'>Your order is Approve. Click <a href='order_view.php?id=".$ww['order_id']."&typeo=delivery' class='w3-text-blue'>here</a> to view your order. </td>";
						echo '</tr></table></div>';	

						$ifempty = true;
						$cc += 1;
					}
				}

				if ($ifempty == false) {
					
					echo '
						<div class="alert alert-info">
						<table>
						<tr>';
						echo "<td class='w3-center'>You have no notification. </td>";
						echo '</tr></table></div>';	

				}

				if ($cc == 0) {
					$_SESSION['notification'] = 0;
				} else {
					$_SESSION['notification'] = $cc;
				}
				
				?>
</div>

</div>
</body>
</html>
<script>
	$(document).ready(function(){
		
	});
</script>

<?php  
/*
	
*/
?>