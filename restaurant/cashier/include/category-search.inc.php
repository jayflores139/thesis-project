<?php  
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['category'])) {
		
		$sql = mysqli_query($conn,"SELECT * FROM food_menu where catid = '".$_POST['category']."'");
		if (mysqli_num_rows($sql) > 0) {
			echo '
			<tr class="w3-light-grey w3-text-grey">
	            <th>Image</th>
	            <th>Food Name</th>
	            <th>Price</th>
	            <th>Category</th>
	            <th>FoodType</th>
	            <th>Description</th>
  			</tr>';
			while ($row = mysqli_fetch_assoc($sql)) {
				echo '
            <tr class="t-body">
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
              <td>'.$row['descrip'].'</td>';
              ?>
       		</tr>
       <?php
			}
		} else {
      echo '
        <tr>
          <td class="w3-padding w3-center" colspan="6">No menu found.</td>
        </tr>
      ';
    }
	}
?>
