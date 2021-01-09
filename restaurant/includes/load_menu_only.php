<?php
include "connect.php";
?>
		<?php
	$d = mysqli_query($conn,"SELECT * FROM category") or die(mysqli_error($conn));
	while ($dd = mysqli_fetch_array($d)) {
		$catid = $dd['cat_id']; ?>
		<h2 class="w3-text-green"><?php echo $dd['cat_name'] ?></h2><br>
	<?php
	$f = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '$catid'") or die(mysqli_error($conn));
		while ($ff = mysqli_fetch_array($f)) {
			$tyid = $ff['type_id']; ?>
			<strong style="margin-right:50px" class="w3-text-blue"><?php echo $ff['type_name'] ?></strong><br>
			<?php
			$c = mysqli_query($conn,"SELECT * FROM food_menu where type_id = '$tyid'") or die(mysqli_error($conn));
			while ($cc = mysqli_fetch_array($c)) { ?>
			
				<label class="w3-text-black"><input type="checkbox" name="food_id[]" value="<?php echo $cc['food_id'] ?>"><?php echo $cc['food_name'] ?></label><br>
			<?php
			}
		}
	}
	?>
