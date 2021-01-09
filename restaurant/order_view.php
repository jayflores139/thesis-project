<?php
session_start();
include "includes/connect.php";

if (!isset($_SESSION['id_user'])) {
	header("Location:login.php");
} else {
	$id_user = $_SESSION['id_user'];
}
$VAT = 0;
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

<div class="container w3-light-grey containersssss" style="height:auto;">

	<button onclick="window.history.back()" class="w3-btn w3-grey w3-hover-white w3-margin-top w3-padding-small"> Back</button>
	<div class="row" style="margin:10px;">
		<div class="col-md-12 w3-padding">
		
			<div class="table-responsive w3-white" style="padding: 10px">
			<?php
		if (isset($_GET['id']) && $_GET['typeo'] == 'delivery') {
			$order_id = $_GET['id'];

			$food = mysqli_query($conn,"SELECT * FROM food_menu natural join food_order_details where order_id = '$order_id' and food_menu.food_id = food_order_details.food_id") or die(mysqli_error($conn));
			$sub_total = 0;
			if (mysqli_num_rows($food) > 0) {
				echo '
				<table class="w3-border w3-text-grey">
					<tr>
 						<td colspan="5" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER ITEMS</h4></td>
 					</tr>
					<tr class="w3-border">
						<td class="w3-padding">IMAGE</td>
						<td>FOOD NAME </td>
						<td>PRICE</td>
						<td>QTY</td>
						<td>COST</td>

					</tr>
					';

				while ($foods = mysqli_fetch_array($food)) {
					echo '
					<tr class="w3-border">
						<td class="w3-padding"><img src="food_images/'.$foods['photo'].'" style="margin:10px"></td>
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
					<td class="w3-padding" colspan="4" align="right">Total : </td>
					<td> P '.number_format($sub_total,2).'</td>
				</tr>';
			}
		}
		elseif (isset($_GET['id']) && $_GET['typeo'] == 'dinein') {
			$order_id = $_GET['id'];

			$food = mysqli_query($conn,"SELECT * FROM food_menu natural join food_order_details where order_id = '$order_id' and food_menu.food_id = food_order_details.food_id") or die(mysqli_error($conn));
			$sub_total = 0;
			if (mysqli_num_rows($food) > 0) {
				echo '
				<table class="w3-border w3-text-grey">
					<tr>
 						<td colspan="5" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER ITEMS</h4></td>
 					</tr>
					<tr class="w3-border">
						<td class="w3-padding">IMAGE</td>
						<td>FOOD NAME </td>
						<td>PRICE</td>
						<td>QTY</td>
						<td>COST</td>

					</tr>
					';

				while ($foods = mysqli_fetch_array($food)) {
					echo '
					<tr class="w3-border">
						<td class="w3-padding"><img src="food_images/'.$foods['photo'].'" style="margin:10px"></td>
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
					<td class="w3-padding" colspan="4" align="right">Total : </td>
					<td> P '.number_format($sub_total,2).'</td>
				</tr>';
			}
		} 
		elseif (isset($_GET['id']) && $_GET['typeo'] == 'takeout') {
			$order_id = $_GET['id'];

			$food = mysqli_query($conn,"SELECT * FROM food_menu natural join food_order_details where order_id = '$order_id' and food_menu.food_id = food_order_details.food_id") or die(mysqli_error($conn));
			$sub_total = 0;
			if (mysqli_num_rows($food) > 0) {
				echo '
				<table class="w3-border w3-text-grey">
					<tr>
 						<td colspan="5" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER ITEMS</h4></td>
 					</tr>
					<tr class="w3-border">
						<td class="w3-padding">IMAGE</td>
						<td>FOOD NAME </td>
						<td>PRICE</td>
						<td>QTY</td>
						<td>COST</td>

					</tr>
					';

				while ($foods = mysqli_fetch_array($food)) {
					echo '
					<tr class="w3-border">
						<td class="w3-padding"><img src="food_images/'.$foods['photo'].'" style="margin:10px"></td>
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
					<td class="w3-padding" colspan="4" align="right">Total : </td>
					<td> P '.number_format($sub_total,2).'</td>
				</tr>';
			}
		}
		elseif (isset($_GET['id']) && $_GET['typeo'] == 'pickup') {
			$order_id = $_GET['id'];

			$food = mysqli_query($conn,"SELECT * FROM food_menu natural join food_order_details where order_id = '$order_id' and food_menu.food_id = food_order_details.food_id") or die(mysqli_error($conn));
			$sub_total = 0;
			if (mysqli_num_rows($food) > 0) {
				echo '
				<table class="w3-border w3-text-grey">
					<tr>
 						<td colspan="5" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER ITEMS</h4></td>
 					</tr>
					<tr class="w3-border">
						<td class="w3-padding">IMAGE</td>
						<td>FOOD NAME </td>
						<td>PRICE</td>
						<td>QTY</td>
						<td>COST</td>

					</tr>
					';

				while ($foods = mysqli_fetch_array($food)) {
					echo '
					<tr class="w3-border">
						<td class="w3-padding"><img src="food_images/'.$foods['photo'].'" style="margin:10px"></td>
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
					<td class="w3-padding" colspan="4" align="right">Total : </td>
					<td> P '.number_format($sub_total,2).'</td>
				</tr>';
			}
		}
			?>
				</table>
			</div>
		</div>

		<div class=" col-md-12 w3-padding w3-center" >
			<div class="table-responsive w3-white" style="padding: 10px">
			<?php  
		if (isset($_GET['id']) && $_GET['typeo'] == 'delivery') {
			$order_id = $_GET['id'];

			$q = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id' and user_id = '$id_user' and order_type = 'delivery'") or die(mysqli_error($conn));
			
			$user = mysqli_query($conn,"SELECT * FROM users where id = '$id_user'") or die(mysqli_error($conn));
			$getuser = mysqli_fetch_array($user);

			$bd_details = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id'") or die(mysqli_error($conn));

			while ($qq = mysqli_fetch_array($q)) {
				echo '
					<table class="w3-border w3-text-grey">
		 				<tr>
		 					<td colspan="2" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER DETAILS</h4></td>
		 				</tr>
		 			';
		 		echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Name: </td>
	 					<td  align="left">'.$getuser['firstname'].' '.$getuser['lastname'].'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Contact number: </td>
	 					<td  align="left">'.$getuser['contact'].'</td>
	 				</tr>';
		 		echo '
			 		<tr class="w3-border">
	 					<td class="w3-padding" align="left">Date ordered: </td>
	 					<td  align="left">'.date("M d, Y", strtotime($qq['curr_order_date'])).'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Order Type: </td>
	 					<td  align="left"> Delivery</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Mode of Payment</td>
	 					<td align="left">'.$qq['payment_mode'].'</td>
	 				</tr>';

		 		$users = mysqli_fetch_array($user);
		 				$now = date("Y-m-d");
		 				?>
		 				
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Delivery date:</td>
		 					<td align="left">
	 						<?php  
	 						if (date("Y-m-d", strtotime($qq['order_date'])) == $now) {
	 							echo "Today, ".date("M d, Y", strtotime($qq['order_date']));
	 						} elseif (date("Y-m-d", strtotime($qq['order_date'])) == date("Y-m-d", strtotime($now."+1 day")) ) {
	 							echo "Tommorow, ".date("M d, Y", strtotime($qq['order_date']));
	 						} else {
	 							echo date("M d, Y", strtotime($qq['order_date']));
	 						}
	 						?>
		 					</td>
		 				</tr>
		 				<?php
		 				echo '
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Delivery time:</td>
		 					<td align="left">'.date("h:i A", strtotime($qq['order_time'])).'</td>
		 				</tr>
		 		';
			 		while ($bd_ = mysqli_fetch_array($bd_details)) {
			 		echo '
			 			<tr class="w3-border">
		 					<td class="w3-padding" align="left">Delivery address:</td>
		 					<td align="left">'.$bd_['house_street'].', '.$users['address'].', Aurora, Zamboanga del sur</td>
		 				</tr>
			 		';	
			 		$Charge = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id='".$bd_['bd_id']."'") or die(mysqli_error($conn));
				 		while ($Charges = mysqli_fetch_array($Charge)) {
				 	echo '
				 		<tr class="w3-border">
		 					<td class="w3-padding" align="left">Delivery Charge</td>
		 					<td align="left"> P'.number_format($Charges['deliv_charge'],2).'</td>
		 				</tr>';
		 			
				 		}
			 		}
				
					echo '
						<tr class="w3-border">
		 					<td class="w3-padding" align="left">Total Payment:</td>
		 					<td align="left">P '.number_format($qq['order_amount'],2).'</td>
		 				</tr>
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Status:</td>
		 					<td align="left">'.$qq['status'].'</td>
		 				</tr>
					';
				$now = date("Y-m-d");
				if (($qq['status'] == "approve" and date("Y-m-d", strtotime($qq['order_date'])) > $now) || ($qq['status'] == "pending" and date("Y-m-d", strtotime($qq['order_date'])) != $now)) { ?>
						<tr class="w3-border" colspan="2">
							<td class="w3-padding" colspan="2">
								<a href="includes/cancel_order.inc.php?cancel=<?php echo $qq['order_id'] ?>" onclick="return confirm('Are you sure you want to cancel your order?')">
									<button class="w3-btn w3-border w3-text-red w3-border-red w3-transparent w3-round-small">Cancel order</button>
								</a>
							</td>
						</tr>
			<?php
				}
				echo '</table>';
			}
		}
		elseif (isset($_GET['id']) && $_GET['typeo'] == 'dinein') {
			$order_id = $_GET['id'];

			$ew = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id' and user_id = '$id_user' and order_type = 'dinein'") or die(mysqli_error($conn));

			$user = mysqli_query($conn,"SELECT * FROM users where id = '$id_user'") or die(mysqli_error($conn));
			$getuser = mysqli_fetch_array($user);

			$bd_details = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id'") or die(mysqli_error($conn));

			while ($qew = mysqli_fetch_array($ew)) {
				echo '
					<table class="w3-border w3-text-grey">
		 				<tr>
		 					<td colspan="2" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER DETAILS</h4></td>
		 				</tr>
		 			';

		 			echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Name: </td>
	 					<td  align="left">'.$getuser['firstname'].' '.$getuser['lastname'].'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Contact number: </td>
	 					<td  align="left">'.$getuser['contact'].'</td>
	 				</tr>';

		 		echo '
			 		<tr class="w3-border">
	 					<td class="w3-padding" align="left">Date ordered: </td>
	 					<td  align="left">'.date("M d, Y", strtotime($qew['curr_order_date'])).'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Order Type: </td>
	 					<td  align="left"> Dine-in</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Mode of Payment</td>
	 					<td align="left">'.$qew['payment_mode'].'</td>
	 				</tr>';

		 			$now = date("Y-m-d");
		 				?>
		 				
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Dine-in date:</td>
		 					<td align="left">
	 						<?php  
	 						if (date("Y-m-d", strtotime($qew['order_date'])) == $now) {
	 							echo "Today, ".date("M d, Y", strtotime($qew['order_date']));
	 						} elseif (date("Y-m-d", strtotime($qew['order_date'])) == date("Y-m-d", strtotime($now."+1 day")) ) {
	 							echo "Tommorow, ".date("M d, Y", strtotime($qew['order_date']));
	 						} else {
	 							echo date("M d, Y", strtotime($qew['order_date']));
	 						}
	 						?>
		 					</td>
		 				</tr>
		 				<?php
		 			echo '
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Dine-in time:</td>
		 					<td align="left">'.date("h:i A", strtotime($qew['order_time'])).'</td>
		 				</tr>
		 		';
		 			
				
					echo '
						<tr class="w3-border">
		 					<td class="w3-padding" align="left">Total Payment:</td>
		 					<td align="left">P '.number_format($qew['order_amount'],2).'</td>
		 				</tr>
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Status:</td>
		 					<td align="left">'.$qew['status'].'</td>
		 				</tr>
					';
				$now = date("Y-m-d");
				if ($qew['status'] == "pending") { ?>
						<tr class="w3-border">
							<td class="w3-padding" colspan="2">
								<a href="includes/cancel_order.inc.php?cancel=<?php echo $qew['order_id'] ?>" onclick="return confirm('Are you sure you want to cancel your order?')">
									<button class="w3-btn w3-border w3-text-red w3-border-red w3-transparent w3-round-small">Cancel order</button>
								</a>
							</td>
						</tr>
			<?php
				}
				echo '</table>';
			}
		}
		elseif (isset($_GET['id']) && $_GET['typeo'] == 'takeout') {
			$order_id = $_GET['id'];

			$ew = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id' and user_id = '$id_user' and order_type = 'takeout'") or die(mysqli_error($conn));
			$user = mysqli_query($conn,"SELECT * FROM users where id = '$id_user'") or die(mysqli_error($conn));
			$getuser = mysqli_fetch_array($user);

			$bd_details = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id'") or die(mysqli_error($conn));

			while ($qew = mysqli_fetch_array($ew)) {
				echo '
					<table class="w3-border w3-text-grey">
		 				<tr>
		 					<td colspan="2" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER DETAILS</h4></td>
		 				</tr>
		 			';

		 			echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Name: </td>
	 					<td  align="left">'.$getuser['firstname'].' '.$getuser['lastname'].'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Contact number: </td>
	 					<td  align="left">'.$getuser['contact'].'</td>
	 				</tr>';

		 			echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Date ordered: </td>
	 					<td  align="left">'.date("M d, Y", strtotime($qew['curr_order_date'])).'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Order Type: </td>
	 					<td  align="left"> Dine-in</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Mode of Payment</td>
	 					<td align="left">'.$qew['payment_mode'].'</td>
	 				</tr>';
		 			$now = date("Y-m-d");
		 				?>
		 				
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Take out date:</td>
		 					<td align="left">
	 						<?php  
	 						if (date("Y-m-d", strtotime($qew['order_date'])) == $now) {
	 							echo "Today, ".date("M d, Y", strtotime($qew['order_date']));
	 						} elseif (date("Y-m-d", strtotime($qew['order_date'])) == date("Y-m-d", strtotime($now."+1 day")) ) {
	 							echo "Tommorow, ".date("M d, Y", strtotime($qew['order_date']));
	 						} else {
	 							echo date("M d, Y", strtotime($qew['order_date']));
	 						}
	 						?>
		 					</td>
		 				</tr>
		 				<?php
		 			echo '
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Take out time:</td>
		 					<td align="left">'.date("h:i A", strtotime($qew['order_time'])).'</td>
		 				</tr>
		 		';
				
					echo '
						<tr class="w3-border">
		 					<td class="w3-padding" align="left">Total Payment:</td>
		 					<td align="left">P '.number_format($qew['order_amount'],2).'</td>
		 				</tr>
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Status:</td>
		 					<td align="left">'.$qew['status'].'</td>
		 				</tr>
					';
				$now = date("Y-m-d");
				if ($qew['status'] == "pending") { ?>
						<tr class="w3-border">
							<td class="w3-padding" colspan="2">
								<a href="includes/cancel_order.inc.php?cancel=<?php echo $qew['order_id'] ?>" onclick="return confirm('Are you sure you want to cancel your order?')">
									<button class="w3-btn w3-border w3-text-red w3-border-red w3-transparent w3-round-small">Cancel order</button>
								</a>
							</td>
						</tr>
			<?php
				}
				echo '</table>';
			}
		}
		elseif (isset($_GET['id']) && $_GET['typeo'] == 'pickup') {
			$order_id = $_GET['id'];

			$ew = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id' and user_id = '$id_user' and order_type = 'pickup'") or die(mysqli_error($conn));
			$user = mysqli_query($conn,"SELECT * FROM users where id = '$id_user'") or die(mysqli_error($conn));
			$getuser = mysqli_fetch_array($user);

			while ($qew = mysqli_fetch_array($ew)) {
				echo '
					<table class="w3-border w3-text-grey">
		 				<tr>
		 					<td colspan="2" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER DETAILS</h4></td>
		 				</tr>
		 			';

		 		echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Name:</td>
	 					<td  align="left">'.$getuser['firstname'].' '.$getuser['lastname'].'</td>
	 				</tr>
	 				';

	 			echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Contact Number:</td>
	 					<td  align="left">'.$getuser['contact'].'</td>
	 				</tr>
	 				';

		 		echo '
		 			<tr class="w3-border">
	 					<td class="w3-padding" align="left">Date ordered: </td>
	 					<td  align="left">'.date("M d, Y", strtotime($qew['curr_order_date'])).'</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Order Type: </td>
	 					<td  align="left"> Pick up</td>
	 				</tr>
	 				<tr class="w3-border">
	 					<td class="w3-padding" align="left">Mode of Payment</td>
	 					<td align="left">'.$qew['payment_mode'].'</td>
	 				</tr>
	 				';

		 		$now = date("Y-m-d");
 				?>
 				
 				<tr class="w3-border">
 					<td class="w3-padding" align="left">Pick up date:</td>
 					<td align="left">
						<?php  
						if (date("Y-m-d", strtotime($qew['order_date'])) == $now) {
							echo "Today, ".date("M d, Y", strtotime($qew['order_date']));
						} elseif (date("Y-m-d", strtotime($qew['order_date'])) == date("Y-m-d", strtotime($now."+1 day")) ) {
							echo "Tommorow, ".date("M d, Y", strtotime($qew['order_date']));
						} else {
							echo date("M d, Y", strtotime($qew['order_date']));
						}
						?>
 					</td>
 				</tr>
 				<?php

		 			echo '
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Pick up time:</td>
		 					<td align="left">'.date("h:i A", strtotime($qew['order_time'])).'</td>
		 				</tr>
		 		';
				
					echo '
						<tr class="w3-border">
		 					<td class="w3-padding" align="left">Total Payment:</td>
		 					<td align="left">P '.number_format($qew['order_amount'],2).'</td>
		 				</tr>
		 				<tr class="w3-border">
		 					<td class="w3-padding" align="left">Status:</td>
		 					<td align="left">'.$qew['status'].'</td>
		 				</tr>
					';
					$now = date("Y-m-d");
				if ($qew['status'] == "pending") { ?>
						<tr class="w3-border">
							<td class="w3-padding" colspan="2"> 
								<a href="includes/cancel_order.inc.php?cancel=<?php echo $qew['order_id'] ?>" onclick="return confirm('Are you sure you want to cancel your order?')">
									<button class="w3-btn w3-border w3-text-red w3-border-red w3-transparent w3-round-small">Cancel order</button>
								</a>
							</td>
						</tr>
			<?php
				}
			}
			echo '</table>';
		} else {
			echo '<script>window.history.back()</script>';
		}
		?>
			</div>
		</div>

	</div>
</div>

</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	var height = "<?php echo $height ?>";

	$(document).ready(function(){
		$("#date").datepicker();
	if (height == true) {
		$(".containersssss").css("height", "auto");	
	}
	});

</script>