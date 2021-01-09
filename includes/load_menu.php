<?php
include "connect.php";
	if (isset($_POST['id'])) {
		$id = $_POST['id'];

		$sql = mysqli_query($conn,"SELECT * FROM  catering where cater_id = '$id'") or die(mysqli_error($conn));
		while ($row = mysqli_fetch_array($sql)) {
			$cater_id = $row['cater_id'];
			?>
			<div class="content-panels w3-border-0">
				<h3><?php echo $row['event_name'] ?></h3>
				<p>P <?php echo number_format($row['p_head'],2) ?> per head</p><br>

				<div id="food_list" class="w3-center" >
					<?php
				$d = mysqli_query($conn,"SELECT * FROM category") or die(mysqli_error($conn));
				while ($dd = mysqli_fetch_array($d)) {
					$catid = $dd['cat_id']; ?>
					<h2 class="w3-text-green"><?php echo $dd['cat_name'] ?></h2>
				<?php
				$f = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '$catid'") or die(mysqli_error($conn));
					while ($ff = mysqli_fetch_array($f)) {
						$tyid = $ff['type_id']; ?>
						<strong style="margin-right:50px" class="w3-text-blue"><?php echo $ff['type_name'] ?></strong><br>
						<?php
						$c = mysqli_query($conn,"SELECT * FROM food_menu natural join catering_details where type_id = '$tyid' and cater_id = '$cater_id'") or die(mysqli_error($conn));
						if (mysqli_num_rows($c) >0) {
						    while ($cc = mysqli_fetch_array($c)) { ?>
    						<p class="w3-text-black"><?php echo $cc['food_name'] ?></p>
    						<?php
    						}
						} else {
						    echo "<span class='w3-text-grey'>[ No menu added ]</span><br>";
						}
					}
				}
				?>
				</div>
			</div>
			<?php
		}
	}
?>
