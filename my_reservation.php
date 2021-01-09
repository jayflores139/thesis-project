<?php
session_start();
include "includes/connect.php";

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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylesheet/style0.css">
	<link rel="stylesheet" type="text/css" href="includes/icon/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/w3.css">
	<style type="text/css">
		button{
			padding:5px;
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
					<a href="my_order.php?order=delivery" class="w3-text-grey">Delivery</a>
					<a href="my_order.php?order=dinein" class="w3-text-grey">Dine-in</a>
					<a href="my_order.php?order=pickup" class="w3-text-grey">Pick up</a>
					<a href="my_order.php?order=takeout" class="w3-text-grey">Take out</a>
					</div>
				<a href="my_reservation.php" class="a w3-text-blue" style="background-color: #fcfcfc;">My Reservation</a>
				<a href="my_account.php" class="a w3-text-blue">My Account</a>
			</div>
		</div>
		<div class="col-md-10" style="padding: 5px">
			<div class="w3-padding w3-white" style="height:650px;overflow: hidden;overflow-y:auto;">
				<h5 class="w3-text-blue">My Reservation</h5>
				<div style="height:32px;">
					<p class="w3-left w3-text-grey" style="margin-right:3px">Filter: </p>
					<select class="w3-select w3-border w3-left select_search_status w3-text-grey" style="width:200px;">
						<option value="">Select status</option>
						<option value="Approve">Approved</option>
						<option value="Cancel">Cancelled</option>
						<option value="Finish">Finished</option>
						<option value="Pending">Pending</option>
					</select>
				</div>

				<div class="table-responsive" style="margin-top:30px;">
				<table class="w3-border w3-text-grey" id="table__ble">
					<?php  
					$q = mysqli_query($conn,"SELECT * FROM reservation where cu_id = '$id_user'") or die(mysqli_error($conn));
					if (mysqli_num_rows($q) > 0) { ?>
					<tr class="w3-border w3-text-blue">
						<td class="w3-padding-medium">Date Reserved</td>
						<td>Occassion</td>
						<td colspan="2">Booking Date</td>
						<td>Balance</td>
						<td>Status</td>
						<td align="center" style="padding-right:5px;">Action</td>
					</tr>

					<?php  
						while ($qq = mysqli_fetch_array($q)) { ?>

					<tr class="w3-border w3-text-black">
						<td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
						<?php  
						$cater = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."'") or die(mysqli_error($conn));
						while ($caters = mysqli_fetch_array($cater)) {
							echo '<td>'.$caters['event_name'].'</td>';
						}
						?>
						<td colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).'<span style="line-height:35px;"> -- </span>'.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
						<td>P <?php echo number_format($qq['balance'],2) ?></td>
						<td><?php echo $qq['r_status'] ?></td>
						<td align="center" style="padding-right:5px;">
							<div class="w3-right" style="margin:3px;">
								<a href="reservation_view.php?id=<?php echo $qq['rid'] ?>">
									<button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px">
										view
									</button>
								</a>
								<?php
								$now = date("Y-m-d");
								if ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") {
									echo '
										<input type="hidden" id="rid'.$qq['rid'].'" value="'.$qq['rid'].'">
										
										<button id="'.$qq['rid'].'" class="delete_reservation w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
											<i class="fas fa-trash"></i>
										</button>
										
									';
								}
								?>		
							</div>
						</td>
					</tr>

						<?php
						}		
					} else { ?>
					<tr class="w3-border w3-text-blue">
						<td class="w3-padding-medium"><?php echo "You have no reservation." ?></td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
			</div>
		</div>

</div>

</body>
</html>
<script>
	$(document).ready(function(){

		$(".delete_reservation").click(function(){
			var ids = $(this).attr("id");
			var id_in = $("#rid"+ids).val();

			if (confirm("Are you sure?") ==true) {
				$.ajax({
					url: "includes/cancel_reservation.php",
					method: "POST",
					data: {
						ids: ids,
						id_in:id_in
					},
					success:function(data){
						if (data == "Deleted!") {
							window.location.reload();
						}
					}
				});
			}
		});


		$(".select_search_status").change(function(){
			var change = $(this).val();
			
			$.ajax({
				url: "includes/changes.php",
				method: "POST",
				data:{
					change:change
				},
				success: function(data){
					$("#table__ble").html(data);
				}
			});
		});

	});
</script>

