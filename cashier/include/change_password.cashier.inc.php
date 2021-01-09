<?php  

include '../../includes/connect.php';

if (isset($_POST['submit'])) {
	$curr_pass = $_POST['curr_pass'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	$position = $_POST['position'];

	$q = mysqli_query($conn,"SELECT * FROM tbl_admin where position = '$position' ");

	if (mysqli_num_rows($q) > 0) {
		
		while ($qq = mysqli_fetch_array($q)) {
			
			$password_verify = password_verify($curr_pass, $qq['passsword']);

			if ($password_verify === true) {
				if ($pass1 == $pass2) {
					$password_hash = password_hash($pass1, PASSWORD_DEFAULT);

					mysqli_query($conn,"UPDATE tbl_admin set passsword = '$password_hash' where position = '$position' ");

					echo "Updated";
				} else {
					echo "Passwords does'nt match!";
				}
			}  else {
					echo "Incorrect password!";
				}

		}

	}
	
}