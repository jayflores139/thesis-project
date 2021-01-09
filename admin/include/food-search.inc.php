<?php  
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['submit'])) {
		$fname = $_POST['fname'];
		$types = $_POST['types'];
		$categories = $_POST['categories'];

		if (empty($types) && empty($categories)) {
			
			$sql = mysqli_query($conn,"SELECT * FROM food_menu where food_name like '%$fname%'");
			echo '
				<table class="w3-bordered w3-center w3-striped w3-padding table-custom">
				<tr class=" w3-text-blue">
		            <td>Image</td>
		            <td>Food Name</td>
		            <td>Price</td>
		            <td>Category</td>
		            <td>FoodType</td>
		            <td>Description</td>
		            <td>Action</td>
	  			</tr>';
			if (mysqli_num_rows($sql) > 0) {
				while ($row = mysqli_fetch_assoc($sql)) {
					echo '
	            <tr class="t-body w3-border">
	              <td><img src="../food_images/'.$row['photo'].'" alt="'.$row['photo'].'"></td>

	              <td>'.$row['food_name'].'</td>

	              <td>'.$row['price'].'</td>';

	               $q = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$row['catid']."'");
		              while ($w = mysqli_fetch_array($q)) { 
		              	echo '
		              		<td>'.$w['cat_name'].'</td>
		              	';
						}

	                  $wew = mysqli_query($conn,"SELECT * FROM food_type WHERE type_id = '".$row['type_id']."'");
	                  while ($e = mysqli_fetch_array($wew)) {
	                  	echo '
	                  	<td>'.$e['type_name'].'</td>
	                  	';
	                  }
	                echo '
	              <td>'.$row['descrip'].'</td>

	              <td width="18%">
	                <a href="menu.edit.php?edit='.$row['food_id'].'">
	                  <button class="action btn btn-default w3-left" style="margin-right:2px"><i class="fas fa-pencil-alt"></i> Edit</button>
	                </a>';
	                ?>

	                <input type="hidden" id="food_id<?php echo $row['food_id']; ?>" value="<?php echo $row['food_id']; ?>">
                  <button class="action delete btn btn-default w3-left" id="<?php echo $row['food_id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
	              </td>
	       		</tr>
	       <?php
				}
				echo "</table>";
			} else {
				echo '
				<tr class="t-body">
	              <td>No food menu found on this "'.$fname.'".</td>
	            </tr>
				';
			}
		} elseif (empty($types) && !empty($categories)) {
			
			$sql = mysqli_query($conn,"SELECT * FROM food_menu where food_name like '%$fname%' and catid = '$categories'");
			echo '
				<table class="w3-bordered w3-center w3-striped w3-padding table-custom">
				<tr class=" w3-text-blue">
		            <td>Image</td>
		            <td>Food Name</td>
		            <td>Price</td>
		            <td>Category</td>
		            <td>FoodType</td>
		            <td>Description</td>
		            <td>Action</td>
	  			</tr>';
			if (mysqli_num_rows($sql) > 0) {
				while ($row = mysqli_fetch_assoc($sql)) {
					echo '
	            <tr class="t-body w3-border">
	              <td><img src="../food_images/'.$row['photo'].'" alt="'.$row['photo'].'"></td>

	              <td>'.$row['food_name'].'</td>

	              <td>'.$row['price'].'</td>';

	               $q = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$row['catid']."'");
		              while ($w = mysqli_fetch_array($q)) { 
		              	echo '
		              		<td>'.$w['cat_name'].'</td>
		              	';
						}

	                  $wew = mysqli_query($conn,"SELECT * FROM food_type WHERE type_id = '".$row['type_id']."'");
	                  while ($e = mysqli_fetch_array($wew)) {
	                  	echo '
	                  	<td>'.$e['type_name'].'</td>
	                  	';
	                  }
	                echo '
	              <td>'.$row['descrip'].'</td>

	              <td width="18%">
	                <a href="menu.edit.php?edit='.$row['food_id'].'">
	                  <button class="action btn btn-default w3-left" style="margin-right:2px"><i class="fas fa-pencil-alt"></i> Edit</button>
	                </a>';
	                ?>

	                <input type="hidden" id="food_id<?php echo $row['food_id']; ?>" value="<?php echo $row['food_id']; ?>">
                  <button class="action delete btn btn-default w3-left" id="<?php echo $row['food_id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
	              </td>
	       		</tr>
	       <?php
				}
				echo "</table>";
			} else {
				echo '
				<tr class="t-body">
	              <td>No food menu found on this "'.$fname.'".</td>
	            </tr>
				';
			}
		} elseif (!empty($types) && !empty($categories)) {
			
			$sql = mysqli_query($conn,"SELECT * FROM food_menu where food_name like '%$fname%' and catid = '$categories' and type_id = '$types'");
			echo '
				<table class="w3-bordered w3-center w3-striped w3-padding table-custom">
				<tr class=" w3-text-blue">
		            <td>Image</td>
		            <td>Food Name</td>
		            <td>Price</td>
		            <td>Category</td>
		            <td>FoodType</td>
		            <td>Description</td>
		            <td>Action</td>
	  			</tr>';
			if (mysqli_num_rows($sql) > 0) {
				while ($row = mysqli_fetch_assoc($sql)) {
					echo '
	            <tr class="t-body w3-border">
	              <td><img src="../food_images/'.$row['photo'].'" alt="'.$row['photo'].'"></td>

	              <td>'.$row['food_name'].'</td>

	              <td>'.$row['price'].'</td>';

	               $q = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$row['catid']."'");
		              while ($w = mysqli_fetch_array($q)) { 
		              	echo '
		              		<td>'.$w['cat_name'].'</td>
		              	';
						}

	                  $wew = mysqli_query($conn,"SELECT * FROM food_type WHERE type_id = '".$row['type_id']."'");
	                  while ($e = mysqli_fetch_array($wew)) {
	                  	echo '
	                  	<td>'.$e['type_name'].'</td>
	                  	';
	                  }
	                echo '
	              <td>'.$row['descrip'].'</td>

	              <td width="18%">
	                <a href="menu.edit.php?edit='.$row['food_id'].'">
	                  <button class="action btn btn-default w3-left" style="margin-right:2px"><i class="fas fa-pencil-alt"></i> Edit</button>
	                </a>';
	                ?>
	                <input type="hidden" id="food_id<?php echo $row['food_id']; ?>" value="<?php echo $row['food_id']; ?>">
	                  <button class="action delete btn btn-default w3-left" id="<?php echo $row['food_id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
		              </td>
	       		</tr>

	       <?php
				}
				echo "</table>";
			} else {
				echo '
				<tr class="t-body">
	              <td>No food menu found on this "'.$fname.'".</td>
	            </tr>
				';
			}
		} elseif (!empty($types) && empty($categories)) {
			
			$sql = mysqli_query($conn,"SELECT * FROM food_menu where food_name like '%$fname%' and type_id = '$types'");
			echo '
				<table class="w3-bordered w3-center w3-striped w3-padding table-custom">
				<tr class=" w3-text-blue">
		            <td>Image</td>
		            <td>Food Name</td>
		            <td>Price</td>
		            <td>Category</td>
		            <td>FoodType</td>
		            <td>Description</td>
		            <td>Action</td>
	  			</tr>';
			if (mysqli_num_rows($sql) > 0) {
				while ($row = mysqli_fetch_assoc($sql)) {
					echo '
	            <tr class="t-body w3-border">
	              <td><img src="../food_images/'.$row['photo'].'" alt="'.$row['photo'].'"></td>

	              <td>'.$row['food_name'].'</td>

	              <td>'.$row['price'].'</td>';

	               $q = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$row['catid']."'");
		              while ($w = mysqli_fetch_array($q)) { 
		              	echo '
		              		<td>'.$w['cat_name'].'</td>
		              	';
						}

	                  $wew = mysqli_query($conn,"SELECT * FROM food_type WHERE type_id = '".$row['type_id']."'");
	                  while ($e = mysqli_fetch_array($wew)) {
	                  	echo '
	                  	<td>'.$e['type_name'].'</td>
	                  	';
	                  }
	                echo '
	              <td>'.$row['descrip'].'</td>

	              <td width="18%">
	                <a href="menu.edit.php?edit='.$row['food_id'].'">
	                  <button class="action btn btn-default w3-left" style="margin-right:2px"><i class="fas fa-pencil-alt"></i> Edit</button>
	                </a>';
	                ?>
	                <input type="hidden" id="food_id<?php echo $row['food_id']; ?>" value="<?php echo $row['food_id']; ?>">
	                  <button class="action btn btn-default delete w3-left" id="<?php echo $row['food_id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
		              </td>
	       		</tr>

	       <?php
				}
				echo "</table>";
			} else {
				echo '
				<tr class="t-body">
	              <td>No food menu found on this "'.$fname.'".</td>
	            </tr>
				';
			}
		}
	} 

?>

<script>
	$(document).ready(function(){
		
		$(".delete").click(function(){
          var id = $(this).attr("id");
          var food_id = $("#food_id"+id).val();

          if (confirm("Are you sure?") == true) {
             $.ajax({
              url: "include/delete_food.inc.php",
              method: "POST",
              data: {
                id: id,
                food_id: food_id
              },
              success: function(data){
                if (data == "Deleted") {
                  window.location="";
                }
              }
            });
          }

        });

	});
</script>