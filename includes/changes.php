<?php  
	include 'connect.php';
	session_start();
	if (!isset($_SESSION['id_user'])) {
		header("Location:../login.php");
	} else {
		$id_user = $_SESSION['id_user'];
	}

	if (isset($_POST['change'])) {
		$change = $_POST['change'];
		
		$changes = mysqli_query($conn,"SELECT * FROM reservation where cu_id = '$id_user' and r_status = '$change'") or die(mysqli_error($conn));

		if (mysqli_num_rows($changes) > 0) {
			echo '
				<tr class="w3-border w3-text-blue">
					<td class="w3-padding-medium">Date Reserved</td>
					<td>Occassion</td>
					<td colspan="2">Booking Date</td>
					<td>Balance</td>
					<td>Status</td>
					<td align="center" style="padding-right:5px;">Action</td>
				</tr>
			';

			while ($qq = mysqli_fetch_array($changes)) {
				echo '
				<tr class="w3-border w3-text-black">
					<td class="w3-padding-medium">'.date("M d, Y", strtotime($qq['date_reserved'])).' </td>	
			';  
				$cater = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."'") or die(mysqli_error($conn));
				while ($caters = mysqli_fetch_array($cater)) {
					echo '<td>'.$caters['event_name'].'</td>';
					echo '
					<td colspan="2">'.date("M d, Y", strtotime($qq['r_date_from'])).'<span style="line-height:35px;"> -- </span>'.date("M d, Y", strtotime($qq['r_date_to'])).'</td>
					<td>P '.number_format($qq['balance'],2).'</td>
					<td>'.$qq['r_status'].' </td>
					'; ?>

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
			} 
		} else {
			echo '
			<tr class="w3-border w3-text-blue">
				<td class="w3-padding-medium">Nothing reservation that '.$change.'.</td>
			</tr>
			';
		}
	}
?>

<script type="text/javascript">
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
							window.location="";
						}
					}
				});
			}
		});

	});
</script>
					

