<?php
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['id'])) {
		$food_id = $_POST['food_id'];

		$delete = mysqli_query($conn,"DELETE FROM food_menu where food_id = '$food_id'") or die(mysqli_error($conn));

		if ($delete == true) {
			echo "Deleted";
		}
	}



if (isset($_POST['submit'])) {
	$fname = $_POST['fname'];

	$sql = mysqli_query($conn,"SELECT * FROM food_menu where food_name like '%$fname%'") or die(mysqli_error($conn));

	if (mysqli_num_rows($sql) > 0) {
		while ($row = mysqli_fetch_array($sql)) {
			echo '
			<div class="col-md-3">
               <div class="container-food">
                 <img src="../food_images/'.$row['photo'].'" alt="'.$row['photo'].'"><br>
                 <strong>'.$row['food_name'].'</strong><br>
                 <strong>P '.number_format($row['price'],2).'</strong><br>
                 '; ?>
                 <form action="addFoodToCart.php?acton=add&id=<?php echo $row['food_id'] ?>" method="post">
                   <input type="hidden" name="hidden_name" value="<?php echo $row['food_name'] ?>">
                   <input type="hidden" name="hidden_pic" value="<?php echo $row['photo'] ?>">
                   <input type="hidden" name="hidden_prc" value="<?php echo $row['price'] ?>">
                   <input type="hidden" name="hidden_qty" value="1">
                   <button type="submit" name="submit_add" class="w3-btn w3-green add_to_cart">Add to cart</button>
                 </form>

               </div>
         	</div>

         <?php
		}
	} else {
		echo "No result found in '".$fname."'.";
	}
}
?>