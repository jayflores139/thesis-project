<?php
include "../../includes/connect.php";

if (isset($_POST['downpayment'])) {
	$downpayment = $_POST['downpayment'];

	$downpaymentInDecimal = $downpayment / 100;

	$q = mysqli_query($conn,"UPDATE downpayment SET d_price = '$downpaymentInDecimal' ");

	if ($q == true) {
		echo "Updated";
	}
}

if (isset($_POST['submit_limit'])) {
	$limit_menu = $_POST['limit_menu'];

	if ($limit_menu >= 1 && $limit_menu <= 3) {
		echo "Menu limitation too small!";
	} else {
		$d = mysqli_query($conn,"UPDATE menu_limit set MenuLimit = '$limit_menu'");
		if ($d == true) {
			echo "Updated limit";
		}

	}
}