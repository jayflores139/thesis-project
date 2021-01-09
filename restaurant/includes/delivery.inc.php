<?php  
	include 'connect.php';
	session_start();
	$id_user = $_SESSION['id_user'];

	if (isset($_POST['delivery'])) {
		$select = $_POST['delivery'];

		$q = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and status = '$select' and order_type = 'delivery'") or die(myssqli_error($conn));
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
								<button class="w3-transparent w3-round w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue" style="height:30px;margin-right:3px">
													view
												</button>
							</a>
				';
				$now = date("Y-m-d");
				if ($qq['status'] == "cancel" || ($qq['status'] == "approve" and date("Y-m-d",strtotime($qq['order_date'])) < $now)) {
					echo '
						<input type="hidden" id="order_id'.$qq['order_id'].'" value="'.$qq['order_id'].'">
						
							<button class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red w3-round" id="'.$qq['order_id'].'" style="width:40px;height:30px;">
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
		} else {
			echo '
				<tr>
				<td colspan="6" align="center" class="w3-padding">Nothing result in '.$select.' Delivery!</td>
				</tr>
			';
		}
	}


	if (isset($_POST['pickup'])) {
		$select = $_POST['pickup'];

		$q = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and status = '$select' and order_type = 'pickup'") or die(myssqli_error($conn));
		if (mysqli_num_rows($q) > 0) {

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
							<a href="order_view.php?id='.$qq['order_id'].'&typeo=pickup">
								<button class="w3-transparent w3-round w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue" style="height:30px;margin-right:3px">
													view
												</button>
							</a>
				';
				$now = date("Y-m-d");
				if ($qq['status'] == "cancel" || ($qq['status'] == "approve" and date("Y-m-d",strtotime($qq['order_date'])) < $now)) {
						echo '
							<input type="hidden" id="order_id'.$qq['order_id'].'" value="'.$qq['order_id'].'">

								<button id="'.$qq['order_id'].'" class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red w3-round" style="width:40px;height:30px;">
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
		} else {
			echo '
				<tr>
				<td colspan="6" align="center" class="w3-padding">Nothing result in '.$select.' Pick up!</td>
				</tr>
			';
		}
	}



	if (isset($_POST['dinein'])) {
		$select = $_POST['dinein'];

		$q = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and status = '$select' and order_type = 'dinein'") or die(myssqli_error($conn));
		if (mysqli_num_rows($q) > 0) {

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
							<a href="order_view.php?id='.$qq['order_id'].'&typeo=dinein">
								<button class="w3-transparent w3-round w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue" style="height:30px;margin-right:3px">
													view
												</button>
							</a>
				';
				$now = date("Y-m-d");
				if ($qq['status'] == "cancel" || ($qq['status'] == "approve" and date("Y-m-d",strtotime($qq['order_date'])) < $now)) {
						echo '
								<input type="hidden" id="order_id'.$qq['order_id'].'" value="'.$qq['order_id'].'">
								<button id="'.$qq['order_id'].'" class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red w3-round" style="width:40px;height:30px;">
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
		} else {
			echo '
				<tr>
				<td colspan="6" align="center" class="w3-padding">Nothing result in '.$select.' dine-in!</td>
				</tr>
			';
		}
	}

	if (isset($_POST['takeout'])) {
		$select = $_POST['takeout'];

		$q = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id_user' and status = '$select' and order_type = 'takeout'") or die(myssqli_error($conn));
		if (mysqli_num_rows($q) > 0) {

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
							<a href="order_view.php?id='.$qq['order_id'].'&typeo=takeout">
								<button class="w3-transparent w3-round w3-left w3-text-blue w3-border w3-border-blue w3-hover-blue" style="height:30px;margin-right:3px">
													view
												</button>
							</a>
				';
				$now = date("Y-m-d");
				if ($qq['status'] == "cancel" || ($qq['status'] == "approve" and date("Y-m-d",strtotime($qq['order_date'])) < $now)) {
						echo '
								<input type="hidden" id="order_id'.$qq['order_id'].'" value="'.$qq['order_id'].'">
								<button id="'.$qq['order_id'].'" class="delete w3-round w3-transparent w3-left w3-border w3-border-red w3-text-red w3-hover-red w3-round" style="width:40px;height:30px;">
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
		} else {
			echo '
				<tr>
				<td colspan="6" align="center" class="w3-padding">Nothing result in '.$select.' Take out!</td>
				</tr>
			';
		}
	}
?>

<script>
	$(document).ready(function(){
		$(".delete").click(function(){
			var id = $(this).attr("id");
			var input = $("#order_id"+id).val();

			if (confirm("Are you sure?") == true) {
				$.ajax({
					url:"includes/delete_order.php",
					method:"GET",
					data:{
						id:id,
						input: input
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