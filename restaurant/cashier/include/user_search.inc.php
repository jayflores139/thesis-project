<?php 
include '../../includes/connect.php';
	if (isset($_POST['name'])) {
		$name = $_POST['name'];

		$search = mysqli_query($conn,"SELECT * FROM users where firstname like '%$name%' or lastname like '%$name%'") or die(mysqli_error($conn));

		if (mysqli_num_rows($search) > 0) {
			echo '
			<tr class="w3-light-grey">
	            <th>Full name</th>
	            <th>Gender</th>
	            <th>Address</th>
	            <th width="13%">Contact #</th>
	            <th width="13%">Date registered</th>
	            <th>Username</th>
	        </tr>
			';
			while ($row = mysqli_fetch_array($search)) {
			echo '
				<tr class="t-body">
	                <td>'.$row['firstname'].' '. $row['lastname'].'</td>
	                <td>'.$row['gender'].'</td>
	                <td>'.$row['address'].'</td>
	                <td>'.$row['contact'].'</td>
	                <td>'.date("M d, Y", strtotime($row['dateadded'])).'</td>
	                <td>'.$row['username'].'</td>
	                <?php
	            }
	                ?>
                </tr>
			';
			}
		} else {
			echo '
				<tr class="t-body">
	                <td>No user like "'.$name.'".</td>
                </tr>
			';
		}
	}
 ?>