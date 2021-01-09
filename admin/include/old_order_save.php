<?php  
include '../../includes/connect.php';

	$r = mysqli_query($conn,"SELECT * FROM dis_senior ");
	$rr = mysqli_fetch_array($r);
	$discount = $rr['discount'];

	if (isset($_POST['save_first_order'])) {
		$order_id = $_POST['order_id'];

		$insertSelect = mysqli_query($conn, "INSERT INTO food_order_details_2 (order_id, food_id, food_qty) SELECT order_id, food_id, food_qty from food_order_details where order_id = '$order_id' " ) or die(mysqli_error($conn));

		if ($insertSelect == true) {
			echo "InsertedWithSelect";
		}
	}

	if (isset($_POST['order_id_save'])) {

		$order_id_save = $_POST['order_id_save'];
		$overAllTotal = $_POST['overAllTotal'];

		$oder_amount = $overAllTotal + ($overAllTotal * 0);

		$f = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id_save' ");
		$ff = mysqli_fetch_array($f);
		//del
		$q = mysqli_query($conn,"SELECT * FROM delivery_detail where order_id = '$order_id_save' ");
		$qq = mysqli_fetch_array($q);
		//ba
		$w = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '".$qq['bd_id']."' ");
		$ww = mysqli_fetch_array($w);

		if ($ff['order_type'] == "delivery") {
			
			if ($ff['customer_type'] == "senior") {
				$orderAmountWithDiscount = ($overAllTotal - ($overAllTotal * $discount)) + $ww['deliv_charge'];

				$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$orderAmountWithDiscount' where order_id = '$order_id_save' ");

				if ($update_old_order == true) {
					echo "Update old order";
				}
			}
			elseif ($ff['customer_type'] == "junior") {

				$amountWithDeliveryCharge = $overAllTotal + ($overAllTotal * 0) + $ww['deliv_charge'];

				$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$amountWithDeliveryCharge' where order_id = '$order_id_save' ");

				if ($update_old_order == true) {
					echo "Update old order";
				}
			}
		} else {
			if ($ff['customer_type'] == "senior") {
				$orderAmountWithDiscount = $overAllTotal - ($overAllTotal * $discount);

				$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$orderAmountWithDiscount' where order_id = '$order_id_save' ");

				if ($update_old_order == true) {
					echo "Update old order";
				}
			}
			elseif ($ff['customer_type'] == "junior") {
				$amount = $overAllTotal + ($overAllTotal * 0);

				$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$amount' where order_id = '$order_id_save' ");

				if ($update_old_order == true) {
					echo "Update old order";
				}
			}
		}
		mysqli_query($conn,"DELETE FROM food_order_details_2 where order_id = '$order_id_save' ") or die(mysqli_error($conn));
	}

	if (isset($_POST['order_id_cancel'])) {
		$order_id_cancel = $_POST['order_id_cancel'];
		
		mysqli_query($conn,"DELETE FROM food_order_details where order_id = '$order_id_cancel' ");

		$old_Order = mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) select order_id, food_id, food_qty FROM food_order_details_2 where order_id = '$order_id_cancel' ") or die(mysqli_error($conn));

		if ($old_Order == true) {
			mysqli_query($conn,"DELETE FROM food_order_details_2 where order_id = '$order_id_cancel' ") or die(mysqli_error($conn));

			$food_price = mysqli_query($conn, "SELECT food_menu.price, food_order_details.food_qty from food_order_details inner join food_menu where food_order_details.food_id=food_menu.food_id and food_order_details.order_id='$order_id_cancel' ") or die(mysqli_error($conn));

			$order_amount = 0;
			while ($qq = mysqli_fetch_array($food_price)) {
				$order_amount += $qq['price'] * $qq['food_qty'];
			}
			$overAmount = $order_amount + ($order_amount * 0);

			$r = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id_cancel' ");
			$rr = mysqli_fetch_array($r);
			//del
			$q = mysqli_query($conn,"SELECT * FROM delivery_detail where order_id = '$order_id_cancel' ");
			$qq = mysqli_fetch_array($q);
			//ba
			$w = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '".$qq['bd_id']."' ");
			$ww = mysqli_fetch_array($w);

			if ($rr['order_type'] == "delivery") {

				if ($rr['customer_type'] == "senior") {
				$orderAmountWithDiscount = ($order_amount - ($order_amount * $discount)) + $ww['deliv_charge'];

				$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$orderAmountWithDiscount' where order_id = '$order_id_cancel' ");

					if ($update_old_order == true) {
						echo "Cancel new order";
					}
				}
				elseif ($rr['customer_type'] == "junior") {

					$amountWithDeliveryCharge = $order_amount + ($order_amount * 0) + $ww['deliv_charge'];

					$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$amountWithDeliveryCharge' where order_id = '$order_id_cancel' ");

					if ($update_old_order == true) {
						echo "Cancel new order";
					}
				}
			} else {

				if ($rr['customer_type'] == "senior") {
					$orderAmountWithDiscount = $order_amount - ($order_amount * $discount);

					$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$orderAmountWithDiscount' where order_id = '$order_id_cancel' ") or die(mysqli_error($conn));

					if ($update_old_order == true) {
						echo "Cancel new order";
					}
				}
				elseif ($rr['customer_type'] == "junior") {
					$amount = $order_amount + ($order_amount * 0);

					$update_old_order = mysqli_query($conn,"UPDATE food_order set order_amount = '$amount' where order_id = '$order_id_cancel' ") or die(mysqli_error($conn));

					if ($update_old_order == true) {
						echo "Cancel new order";
					}
				}
			}
		}
	}

	if (isset($_POST['submit_search'])) {
		$fname = $_POST['fname'];

		$e = mysqli_query($conn,"SELECT * FROM food_menu where food_name like '%$fname%'") or die(mysqli_error($conn));

		if (mysqli_num_rows($e) > 0) {
			while ($ee = mysqli_fetch_array($e)) { ?>

			<div class="col-md-3">
               <div class="container-food" style="height:300px">
                 <img src="../food_images/<?php echo $ee['photo'] ?>" alt="<?php echo $ee['photo'] ?>"><br>
                 <strong><?php echo $ee['food_name'] ?></strong><br>
                 <strong>P <?php echo number_format($ee['price'],2) ?></strong><br>

                    <input type="hidden" id="order_id" value="<?php echo $order_id ?>">
                    <input type="hidden" value="<?php echo $ee['food_id'] ?>" id="food_id<?php echo $ee['food_id'] ?>">
                    <input type="hidden" id="qty" value="1">
                   <button id="<?php echo $ee['food_id'] ?>" class="w3-btn w3-green add_order">Add</button>

               </div>
             </div>

		<?php
			}
		} else {
			echo "No menu found.";
		}
	}

?>