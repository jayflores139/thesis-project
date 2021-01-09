<?php
session_start();
include "includes/connect.php";
if (empty($_SESSION['shopping_cart'])) {
	header("Location:cart.php");
}

if (isset($_GET['action']) && $_GET['action'] == "remove") {
    foreach ($_SESSION['shopping_cart'] as $key => $value) {
      if ($value['id'] == $_GET['id']) {
        unset($_SESSION['shopping_cart'][$key]);
        echo '<script>window.location="place_order.php"</script>';
      }
    }
  }

  if (isset($_POST['update_cart'])) {
      $ids = $_GET['id'];
      $fff = $_POST['update_box'];
      foreach ($_SESSION['shopping_cart'] as $key => $value) {
        if ($value['id'] == $ids) {
          if ($fff == 0) {
            $_SESSION['shopping_cart'][$key]['quantity'] = 1;
          } else {
            if ($_SESSION['shopping_cart'][$key]['id'] == $ids) {
              $_SESSION['shopping_cart'][$key]['quantity'] = $fff;
            }
          }
        }
      }
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
		$heights = false;
		$count = 0;
?>

<div class="container containersssss" style="padding-bottom:60px;height:auto;">
	<?php

	if (!isset($_SESSION['id_user'])) {
		$heights = true;
		?>
		<fieldset style="width:40%;margin:50px auto" class="qwwwwwwwwwwwww w3-light-grey">
		<h4 class="w3-center w3-padding w3-text-grey">Please log in!</h4>
		<form method="post" action="includes/login.inc.php">
			<label class="w3-text-blue">Username</label>
			<input type="text" name="username" class="w3-round w3-border w3-border-blue" placeholder="Username" required>
			<label class="w3-text-blue">Password</label>
			<input type="password" name="password" class="w3-round w3-border w3-border-blue" placeholder="Password" required>

			<div class="w3-right w3-center" style="width:100%">
				<button style="width:100%" class="w3-btn w3-green w3-round w3-padding w3-margin-top w3-margin-bottom" type="submit" name="login">Login</button>
			</div>
			<div class="w3-left w3-center" style="width:100%">
				<a href="forgot_password.php" class="w3-text-blue">Forgot password?</a><br>
				<a href="signup.php" class="w3-text-blue">Sign up!</a>
			</div>
		</form>
	</fieldset>
	<?php
	} else {
	?>
	<h3 class="w3-margin w3-padding-large">Place order</h3>
	<fieldset class="w3-border-blue w3-margin">
		<legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Verify the Order</legend>
		<table class="w3-bordered w3-white">
					<tr class="w3-text-grey">
						<td class="w3-padding">Image</td>
						<td>Food Name</td>
						<td>Price</td>
						<td>Qty</td>
						<td>Subtotal</td>
						<td>Action</td>
					</tr>
					<?php if (!empty($_SESSION['shopping_cart'])) {
						if (count($_SESSION['shopping_cart']) >= 5) {
							$height = true;
						}
						$total = 0;
						$total_qty = 0;
						foreach ($_SESSION['shopping_cart'] as $key => $value) { ?>
					<tr>
						<td style="padding:10px"><img src="food_images/<?php echo $value['picture'] ?>"></td>
						<td><?php echo $value['name'] ?></td>
						<td>P <?php echo number_format($value['price'],2) ?></td>
						<td>
						<form action="place_order.php?action=update&id=<?php echo $value['id'] ?>" method="post">
			                  <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
			                  <input type="text" value="<?php echo $value['quantity'] ?>" size="1" name="update_box" class="w3-center">
			              </td>
						<td>P <?php echo number_format($value['quantity'] * $value['price'],2 ) ?></td>

						<td width="16%">
							<button type="submit" name="update_cart" class="btn-action-cart w3-padding-tiny"><i class="fas fa-sync-alt"></i></button>
						</form>
							<a href="place_order.php?action=remove&id=<?php echo $value['id'] ?>"  onclick="return confirm('Are you sure delete this?')">
								<button type="button" class="btn-action-cart w3-padding-tiny"><i class="fas fa-trash-alt"></i></button>
							</a>
						</td>
					</tr>

					<?php
					$v = $value['quantity'] * $value['price'];
          			$total = $total + $v;
          			$total_qty = $total_qty + $value['quantity'];
						}
						?>
						<tr>
							<th colspan="4" style="text-align: right;" class="w3-padding">Grand Total :</th>
							<td>P <?php echo number_format($total, 2) ?></td>
						</tr>
					<?php
					}
					?>
				</table>
	</fieldset>
	<fieldset class="w3-border-blue w3-margin">
		<legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Order Type</legend>
		<div class="w3-padding" style="color:#555"> 
			<label>
				<input type="radio" name="radio" value="delivery" class="order_type" id="DELIVERY">
				Delivery
			</label><br>

			<label>
				<input type="radio" name="radio" value="dinein" class="order_type" id="DINEIN">
				Dine-in
			</label><br>

			<label>
				<input type="radio" name="radio" value="pickup" class="order_type" id="PICKUP">
				Pick up
			</label><br>

			<label>
				<input type="radio" name="radio" value="takeout" class="order_type" id="TAKEOUT">
				Take out
			</label><br><br>

			<div>
				<label>
					<span class="typeKITA">Delivery</span> Date
					<input type="text" id="tran_date" class="w3-input w3-border w3-border-grey w3-round-small">
				</label><br><br>

				<label>
					<span class="typeKITAtime">Delivery</span> Time

					<div>
						<select class="w3-border w3-border-grey w3-round-small w3-left HOUR" style="padding:8px;margin-right:5px">
							<?php 
							for ($i=1; $i <= 12; $i++) { ?>

							<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php
							}
							?>
						</select>

						<select class="w3-border w3-border-grey w3-round-small w3-left MINUTE" style="padding:8px;margin-right:5px">
							<option value="00">00</option>
							<?php 
							for ($i=15; $i <= 60; $i++) {
								if ($i % 15 == 0) { ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php
								}
							}
							?>
						</select>

						<select class="w3-border w3-border-grey w3-round-small w3-left AMPM" style="padding:8px;margin-right:5px">
							<option value="AM">AM</option>
							<option value="PM">PM</option>
						</select>
					</div>
				</label>

			</div>
		</div>
			
	</fieldset>

	<fieldset class="w3-border-blue w3-margin delivery_details_only" style="display:none">
		<legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Delivery Details</legend>

		<div class="w3-padding" style="color:#555">
			<p class="w3-text-red">Note: The delivery is in Aurora, Zamboanga del Sur only.</p><br>

			<label>Barangay <br>
				<select class="w3-border w3-border-grey w3-round-small BARANGAY w3-select" style="padding:8px;color:#555;width:400px">
					<option value="">--select--</option>
					<?php 
						$q = mysqli_query($conn,"SELECT * FROM barangay_delivery");
						while ($qq = mysqli_fetch_array($q)) { ?>
					<option value="<?php echo $qq['bd_id'] ?>"><?php echo $qq['barangay'] ?></option>
					<?php		
						}
					?>
				</select><br>
				<span style="font-weight:normal;" class="text-danger charge"></span>
			</label><br><br>

			<label>
				House Number / Street
				<input type="text" class="w3-input w3-border w3-border-grey w3-round-small HOUSESTREET" style="width:400px">
			</label>
		</div>
			
	</fieldset>

	<fieldset class="w3-border-blue w3-margin sasasaa" style="display: none">
		<legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Mode of Payment</legend>

		<div class="w3-padding" style="color:#555">

			<label>Mode of payment <br>
				<select class="w3-border w3-border-grey w3-round-small MODEofPAYMENT w3-select" style="padding:8px;color:#555;width:400px">
					<option value="Cash">Cash</option>
				</select>
			</label><br>

		</div>
			
	</fieldset>

	<fieldset class="w3-border-0 w3-margin sasasaa">

		<div class="w3-padding" style="color:#555">
			<button class="w3-btn w3-round-small w3-green submitDELIVERY" style="display:block;">Submit</button>
			<button class="w3-btn w3-round-small w3-green submitDINEIN" style="display:none;">Submit</button>
			<button class="w3-btn w3-round-small w3-green submitTAKEOUT" style="display:none;">Submit</button>
			<button class="w3-btn w3-round-small w3-green submitPICKUP" style="display:none;">Submit</button>
		</div>
			
	</fieldset>

	<?php
	}
	?>
</div>

<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	
$(document).ready(function(){

	$("#tran_date").datepicker();

	$(".order_type").click(function(){
		var order_type = $(this).val();
		if (order_type == "delivery") {

			$(".delivery_details_only").show();
			$(".pickup_details_only").hide();

			$(".typeKITA").text('Delivery');
			$(".typeKITAtime").text('Delivery');

			$(".submitDELIVERY").show();
			$(".submitTAKEOUT").hide();
			$(".submitPICKUP").hide();
			$(".submitDINEIN").hide();
		} 
		else if (order_type == "dinein") {

			$(".delivery_details_only").hide();
			$(".pickup_details_only").hide();

			$(".submitDINEIN").show();
			$(".submitTAKEOUT").hide();
			$(".submitPICKUP").hide();
			$(".submitDELIVERY").hide();

			$(".typeKITA").text('Dine-in');
			$(".typeKITAtime").text('Dine-in');
		} 
		else if (order_type == "takeout") {

			$(".delivery_details_only").hide();
			$(".pickup_details_only").hide();

			$(".submitTAKEOUT").show();
			$(".submitDINEIN").hide();
			$(".submitPICKUP").hide();
			$(".submitDELIVERY").hide();

			$(".typeKITA").text('Take out');
			$(".typeKITAtime").text('Take out');
		} 
		else if (order_type == "pickup") {

			$(".delivery_details_only").hide();
			$(".pickup_details_only").show();

			$(".submitPICKUP").show();
			$(".submitTAKEOUT").hide();
			$(".submitDINEIN").hide();
			$(".submitDELIVERY").hide();

			$(".typeKITA").text('Pick up');
			$(".typeKITAtime").text('Pick up');
		}
	});

	$(".BARANGAY").change(function(){
		var bd_id = $(this).val();

		$.ajax({
			url: "includes/deliv_charge.inc.php",
			method:"POST",
			data: {
				bd_id: bd_id,
			},
			success: function(data){
				$(".charge").text('Delivery Charge of '+data);
			}
		});
	});


	$('.submitDELIVERY').click(function(){

		var submitDELIVERY = $(this).val();
		var DELIVERY = $("#DELIVERY").val();

		var DELIVERY_date = $("#tran_date").val();

		var HOUR = $(".HOUR").val();
		var MINUTE = $(".MINUTE").val();
		var AMPM = $(".AMPM").val();

		var BARANGAY = $(".BARANGAY").val();
		var HOUSESTREET = $(".HOUSESTREET").val();

		var MODEofPAYMENT = $(".MODEofPAYMENT").val();

		if (DELIVERY_date == "" || MODEofPAYMENT == "" || BARANGAY == "" || HOUSESTREET == "") {
			alert("Pease fill in completely!");
		} else {
			$.ajax({
				url: "includes/place_order.inc.php",
				method: "POST",
				data: {
					DELIVERY: DELIVERY,
					DELIVERY_date: DELIVERY_date,
					HOUR: HOUR,
					MINUTE: MINUTE,
					MODEofPAYMENT: MODEofPAYMENT,
					submitDELIVERY: submitDELIVERY,
					BARANGAY: BARANGAY,
					HOUSESTREET: HOUSESTREET,
					AMPM: AMPM

				},
				success: function (data) {
					alert(data);
					if (data == "Your order was successfully done!\nThank you.") {
						location = "order_summary.php";
					}
				}
			});
		}
	});

	$('.submitDINEIN').click(function(){

		var submitDINEIN = $(this).val();
		var DINEIN = $("#DINEIN").val();

		var DINEIN_date = $("#tran_date").val();

		var HOUR = $(".HOUR").val();
		var MINUTE = $(".MINUTE").val();
		var AMPM = $(".AMPM").val();

		var MODEofPAYMENT = $(".MODEofPAYMENT").val();

		if (DINEIN_date == "" || MODEofPAYMENT == "") {
			alert("Pease fill in completely!");
		} else {
			$.ajax({
				url: "includes/place_order.inc.php",
				method: "POST",
				data: {
					DINEIN: DINEIN,
					DINEIN_date: DINEIN_date,
					HOUR: HOUR,
					MINUTE: MINUTE,
					MODEofPAYMENT: MODEofPAYMENT,
					submitDINEIN: submitDINEIN,
					AMPM: AMPM

				},
				success: function (data) {
					alert(data);
					if (data == "Your order was successfully done!\nThank you.") {
						location = "order_summary.php";
					}
				}
			});
		}
	});

	$('.submitTAKEOUT').click(function(){

		var submitTAKEOUT = $(this).val();
		var TAKEOUT = $("#TAKEOUT").val();

		var TAKEOUT_date = $("#tran_date").val();

		var HOUR = $(".HOUR").val();
		var MINUTE = $(".MINUTE").val();
		var AMPM = $(".AMPM").val();

		var MODEofPAYMENT = $(".MODEofPAYMENT").val();

		if (TAKEOUT_date == "" || MODEofPAYMENT == "") {
			alert("Pease fill in completely!");
		} else {
			$.ajax({
				url: "includes/place_order.inc.php",
				method: "POST",
				data: {
					TAKEOUT: TAKEOUT,
					TAKEOUT_date: TAKEOUT_date,
					HOUR: HOUR,
					MINUTE: MINUTE,
					MODEofPAYMENT: MODEofPAYMENT,
					submitTAKEOUT: submitTAKEOUT,
					AMPM: AMPM
				},
				success: function (data) {
					alert(data);
					if (data == "Your order was successfully done!\nThank you.") {
						location = "order_summary.php";
					}
				}
			});
		}
	});

	$('.submitPICKUP').click(function(){

		var submitPICKUP = $(this).val();
		var PICKUP = $("#PICKUP").val();

		var PICKUP_date = $("#tran_date").val();

		var HOUR = $(".HOUR").val();
		var MINUTE = $(".MINUTE").val();
		var AMPM = $(".AMPM").val();

		var MODEofPAYMENT = $(".MODEofPAYMENT").val();

		if (PICKUP_date == "" || MODEofPAYMENT == "") {
			alert("Pease fill in completely!");
		} else {
			$.ajax({
				url: "includes/place_order.inc.php",
				method: "POST",
				data: {
					PICKUP: PICKUP,
					PICKUP_date: PICKUP_date,
					HOUR: HOUR,
					MINUTE: MINUTE,
					MODEofPAYMENT: MODEofPAYMENT,
					submitPICKUP: submitPICKUP,
					AMPM: AMPM
				},
				success: function (data) {
					alert(data);
					if (data == "Your order was successfully done!\nThank you.") {
						location = "order_summary.php";
					}
				}
			});
		}
	});

});

</script>
