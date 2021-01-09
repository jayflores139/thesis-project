<?php
session_start();
include "includes/connect.php";
/*
if (!isset($_SESSION['id_user'])) {
	header("Location:index.php");
}
*/

if (!isset($_SESSION['id_user'])) {
	header("location:login.php");
} else {
	$id_user = $_SESSION['id_user'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
	<style type="text/css">
		button{
			padding:0 10px;
		}
	</style>
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php';
		$height = false;
?>

<div class="container w3-light-grey containersssss">

	<div class="row" style="margin:10px;">
		<div class="col-md-2" style="padding: 5px">
			<div class=" left_panel_acc" style="padding:20px;height:650px">
				<a href="my_order.php?order=delivery" class="a w3-text-blue" style="cursor: default;">My Order</a>
					<div class="sub_acc">
					<a href="my_order.php?order=delivery" class="w3-text-grey"
						style="background-color:<?php if ($_GET['order'] == "delivery") {
							echo '#fcfcfc;';
						} ?> ">Delivery</a>
					<a href="my_order.php?order=dinein" class="w3-text-grey"
						style="background-color:<?php if ($_GET['order'] == "dinein") {
							echo '#fcfcfc;';
						} ?> ">Dine-in</a>
					<a href="my_order.php?order=pickup" class="w3-text-grey"
						style="background-color:<?php if ($_GET['order'] == "pickup") {
							echo '#fcfcfc;';
						} ?> ">Pick up</a>
					<a href="my_order.php?order=takeout" class="w3-text-grey"
						style="background-color:<?php if ($_GET['order'] == "takeout") {
							echo '#fcfcfc;';
						} ?> ">Take out</a>
					</div>
				<a href="my_reservation.php" class="a w3-text-blue">My Reservation</a>
				<a href="my_account.php" class="a w3-text-blue">My Account</a>
			</div>
		</div>
		<div class="col-md-10" style="padding: 5px">
			<div class="w3-padding w3-white" style="height:650px;overflow: hidden;overflow-y:auto;">

				<h5 class="w3-text-blue">My orders /
					<?php
					if (isset($_GET['order']) && $_GET['order'] == "dinein") {
						echo "Dine-in";
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "pickup") {
						echo "Pick up";
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "delivery") {
						echo "Delivery";
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "takeout") {
						echo "Take out";
					}
					?>
				</h5>
				<div style="height:32px;">
					<p class="w3-left w3-text-grey" style="margin-right:3px">Filter: </p>
					<?php
					if (isset($_GET['order']) && $_GET['order'] == "dinein") {
						echo '
							<select class="w3-select w3-border w3-left select_search_dinein w3-text-grey" style="width:200px;">
								<option value="">Select status</option>
								<option value="approve">Approved</option>
								<option value="cancel">Cancelled</option>
								<option value="pending">Pending</option>
							</select>
						';
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "pickup") {
						echo '
							<select class="w3-select w3-border w3-left select_search_pickup w3-text-grey" style="width:200px;">
								<option value="">Select status</option>
								<option value="approve">Approved</option>
								<option value="cancel">Cancelled</option>
								<option value="pending">Pending</option>
							</select>
						';
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "delivery") {
						echo '
							<select class="w3-select w3-border w3-left select_search_delivery w3-text-grey" style="width:200px;">
								<option value="">Select status</option>
								<option value="approve">Approved</option>
								<option value="cancel">Cancelled</option>
								<option value="pending">Pending</option>
							</select>
						';
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "takeout") {
						echo '
							<select class="w3-select w3-border w3-left select_search_takeout w3-text-grey" style="width:200px;">
								<option value="">Select status</option>
								<option value="approve">Approved</option>
								<option value="cancel">Cancelled</option>
								<option value="pending">Pending</option>
							</select>
						';
					}
					?>
					<p class="sssd"></p>
				</div>


				<div class="table-responsive" style="margin-top:30px;">
					<table class="w3-border w3-text-grey" id="table__ble">
					<?php

					if (isset($_GET['order']) && $_GET['order'] == "delivery") {
						$q = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and order_type = 'delivery' order by order_date") or die(mysqli_error($conn));

						if (mysqli_num_rows($q) > 0) {
							echo '
								<tr class="w3-border w3-text-blue">
									<td class="w3-padding-medium">Date Ordered</td>
									<td>Total Item</td>
									<td>Total Amount</td>
									<td>Delivery Date</td>
									<td>Status</td>
									<td align="center" style="padding-right:5px;">Action</td>
								</tr>
							';
							while ($qq = mysqli_fetch_array($q)) {
							echo '
								<tr class="w3-border w3-text-black">
									<td class="w3-padding-medium">'.date("M d, Y", strtotime($qq['curr_order_date'])).'</td>
								';
								$w = mysqli_query($conn,"SELECT food_qty FROM food_order_details where order_id = '".$qq['order_id']."'") or die(mysqli_error($conn));
								$items = 0;
								while ($ww = mysqli_fetch_array($w)) {
									$items = $items + $ww['food_qty'];
								}

							echo '
									<td>'.$items.' Item/s</td>
									<td>P '.number_format($qq['order_amount'],2).'</td>
									<td>'.date("M d, Y", strtotime($qq['order_date'])).'</td>
									<td>'.$qq['status'].'</td>
									<td>
										<div class="w3-right" style="margin:3px;">
											<a href="order_view.php?id='.$qq['order_id'].'&typeo=delivery">
												<button class="w3-round w3-transparent w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue" style="height:30px;margin-right:3px">
													view
												</button>
											</a>
								';
								$now = date("Y-m-d");
								if ($qq['status'] == "cancel" || ($qq['status'] == "approve" and date("Y-m-d",strtotime($qq['order_date'])) < $now)) {
										echo '
											<input type="hidden" id="order_id'.$qq['order_id'].'" value="'.$qq['order_id'].'">

												<button id="'.$qq['order_id'].'" class="delete w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red w3-round" style="width:40px;height:30px;">
													<i class="fas fa-trash-alt"></i>
												</button>

										';
								}

								echo '
										</div>
									</td>
								</tr>
								';
							}
						}
						else {
							echo '
								<tr>
									<td colspan="6" align="center" class="w3-padding">Nothing result in Delivery orders!</td>
								</tr>
							';
						}
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "dinein") {
						$w = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and order_type = 'dinein' order by order_date") or die(mysqli_error($conn));

						if (mysqli_num_rows($w) > 0) {
							echo '
								<tr class="w3-border w3-text-blue">
									<td class="w3-padding-medium">Date Ordered</td>
									<td>Total Item</td>
									<td>Total Amount</td>
									<td>Dine-in Date</td>
									<td>Status</td>
									<td align="center" style="padding-right:5px;">Action</td>
								</tr>
							';
							while ($ww = mysqli_fetch_array($w)) {
							echo '
								<tr class="w3-border w3-text-black">
									<td class="w3-padding-medium">'.date("M d, Y", strtotime($ww['curr_order_date'])).'</td>
								';
								$q = mysqli_query($conn,"SELECT food_qty FROM food_order_details where order_id = '".$ww['order_id']."'") or die(mysqli_error($conn));
								$items = 0;
								while ($qq = mysqli_fetch_array($q)) {
									$items = $items + $qq['food_qty'];
								}

							echo '
									<td>'.$items.' Item/s</td>
									<td>P '.number_format($ww['order_amount'],2).'</td>
									<td>'.date("M d, Y", strtotime($ww['order_date'])).'</td>
									<td>'.$ww['status'].'</td>
									<td>
										<div class="w3-right" style="margin:3px;">
											<a href="order_view.php?id='.$ww['order_id'].'&typeo=dinein">
												<button class="w3-transparent w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue w3-round" style="height:30px;margin-right:3px">
													view
												</button>
											</a>
								';
								$now = date("Y-m-d");
								if ($ww['status'] == "cancel" || ($ww['status'] == "approve" and date("Y-m-d",strtotime($ww['order_date'])) < $now)) {
										echo '
											<input type="hidden" id="order_id'.$ww['order_id'].'" value="'.$ww['order_id'].'">

											<button id="'.$ww['order_id'].'" class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red" style="width:40px;height:30px;">
												<i class="fas fa-trash-alt"></i>
											</button>

										';
								}

								echo '
										</div>
									</td>
								</tr>
								';
							}
						}
						else {
							echo '
								<tr>
									<td colspan="6" align="center" class="w3-padding">Nothing result in Dine-in orders!</td>
								</tr>
							';
						}
					} elseif (isset($_GET['order']) && $_GET['order'] == "takeout") {
						$w = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and order_type = 'takeout' order by order_date") or die(mysqli_error($conn));

						if (mysqli_num_rows($w) > 0) {
							echo '
								<tr class="w3-border w3-text-blue">
									<td class="w3-padding-medium">Date Ordered</td>
									<td>Total Item</td>
									<td>Total Amount</td>
									<td>Take out Date</td>
									<td>Status</td>
									<td align="center" style="padding-right:5px;">Action</td>
								</tr>
							';
							while ($ww = mysqli_fetch_array($w)) {
							echo '
								<tr class="w3-border w3-text-black">
									<td class="w3-padding-medium">'.date("M d, Y", strtotime($ww['curr_order_date'])).'</td>
								';
								$q = mysqli_query($conn,"SELECT food_qty FROM food_order_details where order_id = '".$ww['order_id']."'") or die(mysqli_error($conn));
								$items = 0;
								while ($qq = mysqli_fetch_array($q)) {
									$items = $items + $qq['food_qty'];
								}

							echo '
									<td>'.$items.' Item/s</td>
									<td>P '.number_format($ww['order_amount'],2).'</td>
									<td>'.date("M d, Y", strtotime($ww['order_date'])).'</td>
									<td>'.$ww['status'].'</td>
									<td>
										<div class="w3-right" style="margin:3px;">
											<a href="order_view.php?id='.$ww['order_id'].'&typeo=takeout">
												<button class="w3-transparent w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue w3-round" style="height:30px;margin-right:3px">
													view
												</button>
											</a>
								';
								$now = date("Y-m-d");
								if ($ww['status'] == "cancel" || ($ww['status'] == "approve" and date("Y-m-d",strtotime($ww['order_date'])) < $now)) {
										echo '
											<input type="hidden" id="order_id'.$ww['order_id'].'" value="'.$ww['order_id'].'">

											<button id="'.$ww['order_id'].'" class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red" style="width:40px;height:30px;">
												<i class="fas fa-trash-alt"></i>
											</button>

										';
								}

								echo '
										</div>
									</td>
								</tr>
								';
							}
						}
						else {
							echo '
								<tr>
									<td colspan="6" align="center" class="w3-padding">Nothing result in Dine-in orders!</td>
								</tr>
							';
						}
					}
					elseif (isset($_GET['order']) && $_GET['order'] == "pickup") {
						$g = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and order_type = 'pickup' order by order_date") or die(mysqli_error($conn));

						if (mysqli_num_rows($g) > 0) {
							echo '
								<tr class="w3-border w3-text-blue">
									<td class="w3-padding-medium">Date Ordered</td>
									<td>Total Item</td>
									<td>Total Amount</td>
									<td>Pick up Date</td>
									<td>Status</td>
									<td align="center" style="padding-right:5px;">Action</td>
								</tr>
							';
							while ($gg = mysqli_fetch_array($g)) {
							echo '
								<tr class="w3-border w3-text-black">
									<td class="w3-padding-medium">'.date("M d, Y", strtotime($gg['curr_order_date'])).'</td>
								';
								$h = mysqli_query($conn,"SELECT food_qty FROM food_order_details where order_id = '".$gg['order_id']."'") or die(mysqli_error($conn));
								$items = 0;
								while ($hh = mysqli_fetch_array($h)) {
									$items = $items + $hh['food_qty'];
								}

							echo '
									<td>'.$items.' Item/s</td>
									<td>P '.number_format($gg['order_amount'],2).'</td>
									<td>'.date("M d, Y", strtotime($gg['order_date'])).'</td>
									<td>'.$gg['status'].'</td>
									<td>
										<div class="w3-right" style="margin:3px;">
											<a href="order_view.php?id='.$gg['order_id'].'&typeo=pickup">
												<button class="w3-transparent w3-round w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue" style="height:30px;margin-right:3px">
													view
												</button>
											</a>
								';
								$now = date("Y-m-d");
								if ($gg['status'] == "cancel" || ($gg['status'] == "approve" and date("Y-m-d",strtotime($gg['order_date'])) < $now)) {
										echo '
											<input type="hidden" id="order_id'.$gg['order_id'].'" value="'.$gg['order_id'].'">

												<button id="'.$gg['order_id'].'" class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red w3-round" style="height:30px;">
													<i class="fas fa-trash-alt"></i>
												</button>

										';
								}

								echo '
										</div>
									</td>
								</tr>
								';
							}
						}
						else {
							echo '
								<tr>
									<td colspan="6" align="center" class="w3-padding">Nothing result in Pick up orders!</td>
								</tr>
							';
						}
					}
					?>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	$(document).ready(function(){
		$(".date").datepicker();

		$(".select_search_delivery").change(function(){
			var delivery = $(".select_search_delivery").val();

			if (delivery =="") {
				alert("Please select to search!");
			} else {
				$.ajax({
					url:"includes/delivery.inc.php",
					method:"POST",
					data:{
						delivery:delivery
					},
					success:function(data){
						$("#table__ble").html(data);
					}
				});
			}
		});

		$(".select_search_dinein").change(function(){
			var dinein = $(".select_search_dinein").val();

			if (dinein =="") {
				alert("Please select to search!");
			} else {
				$.ajax({
					url:"includes/delivery.inc.php",
					method:"POST",
					data:{
						dinein:dinein
					},
					success:function(data){
						$("#table__ble").html(data);
					}
				});
			}
		});

		$(".select_search_pickup").change(function(){
			var pickup = $(".select_search_pickup").val();

			if (pickup =="") {
				alert("Please select to search!");
			} else {
				$.ajax({
					url:"includes/delivery.inc.php",
					method:"POST",
					data:{
						pickup:pickup
					},
					success:function(data){
						$("#table__ble").html(data);
					}
				});
			}
		});

		$(".select_search_takeout").change(function(){
			var takeout = $(this).val();

			if (takeout =="") {
				alert("Please select to search!");
			} else {
				$.ajax({
					url:"includes/delivery.inc.php",
					method:"POST",
					data:{
						takeout:takeout
					},
					success:function(data){
						$("#table__ble").html(data);
					}
				});
			}
		});

		$(".delete").click(function(){
			var ids = $(this).attr("id");

			var hidden = $("#order_id"+ids).val();

			if (confirm("Are you sure you?") == true) {
				$.ajax({
				url:"includes/delete_order.php",
				mehod:"GET",
				data:{
					ids: ids,
					hidden:hidden
				},
				success: function(data){
					if (data == "Deleted!") {
						window.location.reload();
					}
				}
			});
			}

		});

	});
</script>