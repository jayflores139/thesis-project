<?php  
include '../../includes/connect.php';

	if (isset($_POST['order_id_cancel'])) {
		$order_id_cancel = $_POST['order_id_cancel'];	
		mysqli_query($conn,"DELETE FROM add_ons where r_id = '$order_id_cancel' ");

		echo "Cancel new order";
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

                    <input type="hidden" id="r_id" value="<?php echo $r_id ?>">
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