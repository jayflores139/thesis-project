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
		<form action="includes/edit_profile.inc.php" method="POST">
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
						<td class="w3-padding">
							<input type="text" required class="w3-input w3-border" style="width:40%;float:left;margin-right:10px" name="fname" value="<?php echo $qq['firstname'] ?>">
							<input type="text" required class="w3-input w3-border" style="width:40%;float:left" name="lname" value="<?php echo $qq['lastname'] ?>">
						</td>
						<td><input type="email" required class="w3-input w3-border" style="width:90%" name="email" value="<?php echo $qq['email'] ?>"></td>
						<td> <input type="tel" required class="w3-input w3-border"  name="contact" value="<?php echo $qq['contact'] ?>"></td>
					</tr>
					<tr class="w3-text-grey">
						<td class="w3-padding">Address</td>
						<td class="w3-padding">Gender</td>
						<td>Username</td>
					</tr>
					<tr class="w3-text-blue">
						<td class="w3-padding">
							<textarea name="address" required class="w3-input w3-border" style="width: 90%;"><?php echo $qq['address'] ?></textarea>
						</td>
						<td class="w3-padding"><?php 
						if ($qq['gender'] == 'M') {
							echo 'Male';
						} elseif ($qq['gender'] == 'F') {
							echo 'Female';
						}
						 ?></td>
						<td>
							<input type="text" name="uname" required value="<?php echo $qq['username'] ?>" class="w3-input w3-border">
						</td>
					</tr>
				<?php
				}
				?>		
			</table>
			<br><br>
				<button class="w3-btn w3-blue w3-round-small buutoon" type="submit">SAVE</button><br>	
				</form>		
		</div>
	</div>

</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	$(document).ready(function(){
		
	});
</script>

