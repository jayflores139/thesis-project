<?php
session_start();
include "includes/connect.php";
$VAT = 0;
 
 if (!isset($_SESSION['id_user'])) {
 	header("Location:login.php");
 }

 if (!isset($_SESSION['last_id_order'])) {
 	header("Location:index.php");
 } else {
 	$last_id_order = $_SESSION['last_id_order'];
 }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylesheet/style0.css">
	<link rel="stylesheet" type="text/css" href="includes/icon/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/w3.css">
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
		$height = false;
?>

<div class="container w3-light-grey containersssss" style="padding-bottom:50px;">
	<h3 class="w3-text-black w3-center w3-margin-top">Order Summary</h3>
	<div class="row w3-padding w3-white" style="margin:10px;">
		<div style="margin-bottom:10px" class="col-md-12 w3-white">

<!-- ======================================ORDER DETAILS=========================================== -->
			<?php  
			$d = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$last_id_order'") or die(mysqli_error($conn));
			while ($dd = mysqli_fetch_array($d)) {
				if ($dd['order_type'] == "pickup") {
					echo '<h4 style="border-bottom:4px double #ccc;">Pick up Details</h4>';
					$typepick = $dd['order_type'];
				}
				elseif ($dd['order_type'] == "delivery") {
					echo '<h4 style="border-bottom:4px double #ccc;">Delivery Details</h4>';
				}
				elseif ($dd['order_type'] == "dinein") {
					echo '<h4 style="border-bottom:4px double #ccc;">Dine-in Details</h4>';
				}
				elseif ($dd['order_type'] == "takeout") {
					echo '<h4 style="border-bottom:4px double #ccc;">Take out Details</h4>';
				}

				echo '
				<table style="width:50%" class="w3-bordered">
					<tr>
						<th>Date: </th>
						<td>'.date("F d, Y" ,strtotime($dd['curr_order_date'])).'</td>
					</tr>';

				if ($dd['order_type'] == "pickup") {
					echo '
					<tr>
						<th>Order Type: </th>
						<td>Pick up</td>
					</tr>
					<tr>
						<th>Pick up date: </th>
						<td>'.date("F d, Y" ,strtotime($dd['order_date'])).'</td>
					</tr>
					<tr>
						<th>Pick up time: </th>
						<td>'.date("h:i A" ,strtotime($dd['order_time'])).'</td>
					</tr>
					';
				}
				elseif ($dd['order_type'] == "delivery") {
					echo '
					<tr>
						<th>Order Type: </th>
						<td>Delivery</td>
					</tr>
					<tr>
						<th>Delivey date: </th>
						<td>'.date("F d, Y" ,strtotime($dd['order_date'])).'</td>
					</tr>
					<tr>
						<th>Delivery time: </th>
						<td>'.date("h:i A" ,strtotime($dd['order_time'])).'</td>
					</tr>
					';
					$delivery = mysqli_query($conn,"SELECT * FROM delivery_detail where order_id = '$last_id_order'") or die(mysqli_error($conn));
					while ($deliveries = mysqli_fetch_array($delivery)) {					
						$barangay = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '".$deliveries['bd_id']."'");
						while ($barangays = mysqli_fetch_array($barangay)) {
							echo '
							<tr>
								<th>Delivery Address: </th>
								<td>'.$deliveries['house_street'].', '.$barangays['barangay'].', Aurora, Zamboanga del sur'.'</td>
							</tr>
							';
						}
					}
				}
				elseif ($dd['order_type'] == "dinein") {
					echo '
					<tr>
						<th>Order Type: </th>
						<td>Dine-in</td>
					</tr>
					<tr>
						<th>Dine-in date: </th>
						<td>'.date("F d, Y" ,strtotime($dd['order_date'])).'</td>
					</tr>
					<tr>
						<th>Dine-in time: </th>
						<td>'.date("h:i A" ,strtotime($dd['order_time'])).'</td>
					</tr>
					';
				}
				elseif ($dd['order_type'] == "takeout") {
					echo '
					<tr>
						<th>Order Type: </th>
						<td>Take out</td>
					</tr>
					<tr>
						<th>Take out date: </th>
						<td>'.date("F d, Y" ,strtotime($dd['order_date'])).'</td>
					</tr>
					<tr>
						<th>Take out time: </th>
						<td>'.date("h:i A" ,strtotime($dd['order_time'])).'</td>
					</tr>
					';
				}

				$get_user = mysqli_query($conn,"SELECT * FROM users where id = '".$dd['user_id']."'");
				while ($get_users = mysqli_fetch_array($get_user)) {
					echo '
						<tr>
							<th>Name: </th>
							<td>'.$get_users['firstname'].' '. $get_users['lastname'].'</td>
						</tr>
						<tr>
							<th>Contact number: </th>
							<td>'.$get_users['contact'].'</td>
						</tr>
					';	
				}
			}
			echo '</table>';
			?>
<!-- ====================================== END OF ORDER DETAILS=========================================== -->
		</div>
		<div style="margin-bottom:10px" class="w3-white col-md-12">
			<h4 style="border-bottom:4px double #ccc;">Order Items</h4>

			<div class="table-responsive">
<!-- ====================================== FOOD ORDER DETAILS=========================================== -->
			<?php  
			$food = mysqli_query($conn,"SELECT * FROM food_menu natural join food_order_details where order_id = '$last_id_order' and food_menu.food_id = food_order_details.food_id") or die(mysqli_error($conn));
			$sub_total = 0;
			if (mysqli_num_rows($food) > 0) {
				echo '
				<table class="w3-center">
					<tr>
						<td>IMAGE</td>
						<td>FOOD NAME </td>
						<td>PRICE</td>
						<td>QTY</td>
						<td>COST</td>

					</tr>
					';

				while ($foods = mysqli_fetch_array($food)) {
					echo '
					<tr>
						<td><img src="food_images/'.$foods['photo'].'" style="margin:10px"></td>
						<td>'.$foods['food_name'].'</td>
						<td>P '.number_format($foods['price'],2).'</td>
						<td>'.$foods['food_qty'].'</td>
						<td>P '.number_format($foods['food_qty'] * $foods['price'],2).'</td>
					</tr>
					';
					$sub_total = $sub_total + ($foods['food_qty'] * $foods['price']);
				}
				echo '
				<tr>
					<td colspan="4" align="right">Total : </td>
					<td> P '.number_format($sub_total,2).'</td>
				</tr>';
			}
			?>
			</table>
		</div>
<!-- ======================================END OF FOOD ORDERS DETAILS=========================================== -->

		</div>
<!-- ======================================PAYMENT SIDE=========================================== -->
		<div style="margin-bottom:10px;" class="w3-blue-grey col-md-12 w3-center w3-padding-bottom">
				<table style="width:30%; margin:0 auto;margin-top:10px">
					
			<?php  
			$payment = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$last_id_order'") or die(mysqli_error($conn));
			while ($payments = mysqli_fetch_array($payment)) {
				if ($payments['order_type'] == "delivery") {
					$deliv = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$last_id_order''$last_id_order'") or die(mysqli_error($conn));
					while ($delivs = mysqli_fetch_array($deliv)) {
						$delivB = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '".$delivs['bd_id']."'") or die(mysqli_error($conn));
						while ($delivBs = mysqli_fetch_array($delivB)) {
							echo '
							<tr>
								<td>Payment Method: </td>
								<td>Cash</td>
							</tr>
							<tr>
								<td>Delivery Charge: </td>
								<td>P '.number_format($delivBs["deliv_charge"],2).'</td>
							</tr>
							<tr>
								<td>Grand Total: </td>
								<td>P '.number_format($delivBs["deliv_charge"] + $sub_total + ($sub_total * $VAT) ,2).'</td>
							</tr>';
						}
					}
				} else {
					echo '
						<tr>
							<td>Payment Method: </td>
							<td>Cash Payment</td>
						</tr>
						<tr>
							<td>Grand Total: </td>
							<td>P '.number_format($sub_total + ($sub_total * $VAT),2).'</td>
						</tr>';	
				}
			}
			?>
			</table>
		</div>
	</div>
<!-- ======================================PAYMENT SIDE END=========================================== -->
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	var height = "<?php echo $height ?>";
	$(document).ready(function(){
	if (height == true) {
		$(".containersssss").css("height", "auto");	
	}

	});
</script>
