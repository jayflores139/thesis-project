<?php 
	session_start();
	include 'connect.php';

	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = mysqli_query($conn, "SELECT * FROM users where username = '$username' ") or die(mysqli_error($conn));
		if (mysqli_num_rows($sql) > 0) {
			while ($row = mysqli_fetch_array($sql)) {

				$passwordVerify = password_verify($password, $row['password']);

				if ($passwordVerify === true) {
					$_SESSION['id_user'] = $row['id'];
					echo '<script>window.history.back();</script>';
				} else {
					echo '<script>
						alert("Username or password is incorrect!");
						window.history.back();</script>';
				}
			}
		} else {
			echo '<script>
			alert("Username or password is incorrect!");
			window.history.back();</script>';
		}
	}
?>