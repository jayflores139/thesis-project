<?php  

	session_start();
	include 'connect.php';

	$direct = "";
	if (isset($_POST['sign_up'])) {
		$email = $_POST['email'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$cnum = $_POST['cnum'];
		$address = $_POST['address'];
		$gender = $_POST['gender'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$now = date("Y-m-d");

		$ss = mysqli_query($conn,"SELECT * FROM users where username = '$username'") or die(mysqli_error($conn));
		if (mysqli_num_rows($ss) > 0) {
			echo "Someone uses your username you type!";
		} else {
			if ($password != $password2) {
				echo "Passwords does not match!";
			} else {
				$passwordHash = password_hash($password, PASSWORD_DEFAULT);
				$query = mysqli_query($conn,"INSERT INTO users (firstname, lastname, gender, address, contact, dateadded, email, username, password) 
					values ('$fname', '$lname' ,'$gender' ,'$address', '$cnum', '$now', '$email', '$username', '$passwordHash')") or die(mysqli_error($conn));
				if ($query) {
					$last_id = mysqli_insert_id($conn);
					$_SESSION['id_user'] = $last_id;
					echo $direct = "Sign up Successfully!";
				}
			}
		}
	}

?>
