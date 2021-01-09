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
		button{
			width:200px;
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

			<form id="form">
				<label>
					Current password
					<input style="width:300px;" required type="password" class="w3-input w3-border w3-round-small" id="current_password" placeholder="Please enter your current password.">
				</label>
				<br>
				<br>

				<label>
					New password
					<input style="width:300px;" required type="password" class="w3-input w3-border w3-round-small" id="new_password" placeholder="Minimum 6 characters">
				</label>
				<br>
				<br>

				<label>
					Retype password
					<input style="width:300px;" required type="password" class="w3-input w3-border w3-round-small" id="retype_password" placeholder="Please retype your password.">
				</label>
				<br>
				<span class="w3-text-red w3-small" id="error_unmatch"></span>
				<br><br>
				<input type="hidden" id="user_id" value="<?php echo $_GET['i'] ?>">
				<button class="w3-btn w3-round-small w3-green" id="submit">SAVE CHANGES</button>
			</form>
		</div>
	</div>

</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	$(document).ready(function(){

		$("#form").submit(function(e){
			e.preventDefault();

			var current_password = $("#current_password").val();
			var new_password = $("#new_password").val();
			var retype_password = $("#retype_password").val();
			var	user_id = $("#user_id").val();
			var submit = $("#submit").val();

			$.ajax({
				url: "includes/change_password.inc.php",
				method: "POST",
				data: {
					current_password: current_password,
					new_password: new_password,
					retype_password: retype_password,
					user_id: user_id,
					submit: submit
				},
				success: function(data){

					if (data == "Update successfully!") {
						window.location="my_account.php";
					} else {
						$("#error_unmatch").text(data);
					}
				}
			});
		});
	});

</script>
