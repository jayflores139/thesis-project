<?php 
	include('connect.php');

	if (isset($_POST['submit'])) {
		$current_password = $_POST['current_password'];
		$new_password = $_POST['new_password'];
		$retype_password = $_POST['retype_password'];

		$user_id = $_POST['user_id'];

		$q = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		if (mysqli_num_rows($q) > 0) {
			
			while ($qq = mysqli_fetch_array($q)) {
				
				$password_verify = password_verify($current_password, $qq['password']);

				if ($password_verify === true) {
					
					if (strlen($new_password) >= 6 ) {

						if ($new_password == $retype_password) {
							$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

							$update = mysqli_query($conn,"UPDATE users set password = '$password_hash' where id = '$user_id' ");

							if ($update == true) {
								echo "Update successfully!";
							}
						} else {
							echo "Passwords does'nt match!";
						}
					} else {
						echo "Invalid length of password characters!";
					}

				} else {
					echo "Password is incorrect.";
				}
			}

		} else {
			echo "Password is incorrect.";
		}
		
	}

 ?>