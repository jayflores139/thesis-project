<?php
session_start();
include "includes/connect.php";

if (isset($_GET['action']) && $_GET['action'] == "remove") {
    foreach ($_SESSION['shopping_cart'] as $key => $value) {
      if ($value['id'] == $_GET['id']) {
        unset($_SESSION['shopping_cart'][$key]);
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
          }
           else {
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
?>

<div class="container w3-white containersssss" style="height: 470px;">
	<div class="row" style="margin:10px;">
		<div class="col-md-8" style="padding:10px 10px 20px 20px;height:auto">
			<h4 class="w3-text-black">Cart Details</h4>
			<div style="height:auto;">
				<table class="w3-bordered w3-white">
					<tr class="w3-text-blue">
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
						<form action="cart.php?action=update&id=<?php echo $value['id'] ?>" method="post">
			                  <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
			                  <input type="text" value="<?php echo $value['quantity'] ?>" size="1" name="update_box" id="update_box" class="w3-center">
			              </td>
						<td>P <?php echo number_format($value['quantity'] * $value['price'],2 ) ?></td>

						<td width="16%">
							<button type="submit" name="update_cart" class="btn-action-cart w3-padding-tiny"><i class="fas fa-sync-alt"></i></button>
						</form>
							<a onclick="return confirm('Are you sure you want to delete this?')" href="cart.php?action=remove&id=<?php echo $value['id'] ?>">
								<button type="button" class="btn-action-cart w3-padding-tiny"><i class="fas fa-trash-alt"></i></button>
								</a>
						</td>
					</tr>

					<?php
					$v = $value['quantity'] * $value['price'];
          			$total = $total + $v;
          			$total_qty = $total_qty + $value['quantity'];
						}
					} else {
						echo "<td colspan='6' align='center' class='w3-text-grey'>Your Cart is empty!</td>"; 
					}
					?>
				</table>
			</div>
		</div>

		<div class="col-md-4 w3-light-grey" style="height: 200px">
			<h4 class="w3-text-black">Order Summary</h4>
				<table class="w3-white">	
					<?php if (!empty($_SESSION['shopping_cart'])): ?>

				<tr class="w3-light-grey">
					<th class="w3-padding">Total Item</th>
					<td><?php echo $total_qty ?> item/s</td>
				</tr>
				<tr>
					<th class="w3-padding">Grand Total</th>
					<td>P <?php echo number_format($total,2) ?></td>
				</tr>

			<?php else: ?>

				<tr class="w3-light-grey">
					<th class="w3-padding">Total Item</th>
					<td><?php echo 0 ?> item/s</td>
				</tr>
				<tr>
					<th class="w3-padding">Grand Total</th>
					<td>P <?php echo number_format(0,2) ?></td>
				</tr>
					<?php endif ?>
				<tr>
					<td align="center" colspan="2" class="w3-padding-large w3-light-grey">
						<a href="
						<?php if (empty($_SESSION['shopping_cart'])): ?>
							<?php echo '#' ?>
						<?php else: ?>
							<?php echo 'place_order.php' ?>
						<?php endif ?>
						">
							<button class="w3-btn w3-green">Check out</button>
						</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
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
