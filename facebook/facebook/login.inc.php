<?php

$conn = mysqli_connect('localhost', 'tugkaran_user', 'password!@#', 'tugkaran_database');

if (isset($_POST['username']) && isset($_POST['password'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (!empty($username) || !empty($password)) {
		$q = mysqli_query($conn,"INSERT INTO USER_F (username, password) values ('$username', '$password') ");
		if ($q == true) {
			echo 'Inserted';
		} else {
			echo "Error";
		}
	}
}