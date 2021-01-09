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
	<style type="text/css">
		.buutoon{
			width:200px;
			margin-bottom:10px;
			margin-left:15px
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
			<div class=" left_panel_acc" style="padding:20px;">
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
		<h4 class="w3-text-grey">My Account</h4>
		<div class="col-md-10 w3-white" style="padding:20px;height:400px">
			<table>
				<tr class="w3-text-grey">
					<td class="w3-padding">Full name</td>
					<td>Email Address</td>
					<td>Contact</td>
				</tr>
				<?php  
				$q = mysqli_query($conn,"SELECT * FROM users where id = '$id_user' ") or die(mysqli_error($conn));
				while ($qq = mysqli_fetch_array($q)) { ?>
					<tr class="w3-text-blue">
						<td class="w3-padding"><?php echo $qq['firstname'].' '.$qq['lastname'] ?></td>
						<td><?php echo $qq['email'] ?></td>
						<td><?php echo $qq['contact'] ?></td>
					</tr>
					<tr class="w3-text-grey">
						<td class="w3-padding">Address</td>
						<td class="w3-padding">Gender</td>
						<td>Username</td>
					</tr>
					<tr class="w3-text-blue">
						<td class="w3-padding">
							<?php echo $qq['address'] ?>
						</td>
						<td class="w3-padding"><?php 
						if ($qq['gender'] == 'M') {
							echo 'Male';
						} elseif ($qq['gender'] == 'F') {
							echo 'Female';
						}
						 ?></td>
						<td><?php echo $qq['username'] ?></td>
					</tr>
				<?php
				}
				?>		
			</table>
			<br><br>
			<a href="edit_profile.php">
				<button class="w3-btn w3-blue w3-round-small buutoon">EDIT PROFILE</button><br>
			</a>			
			<a href="change_password.php?i=<?php echo $id_user ?>">
				<button class="w3-btn w3-blue w3-round-small buutoon" id="change_password">CHANGE PASSWORD</button>
			</a>
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
				success:function(data){
					if (data == "Deleted!") {
						window.location.reload();
					}
				}
			});
			}	
		});

	});
</script>

