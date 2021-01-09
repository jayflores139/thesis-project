<?php
include "../../includes/connect.php";

if (isset($_POST['downpayment'])) {
	$downpayment = $_POST['downpayment'];

	$downpaymentInDecimal = $downpayment / 100;
    
    $D = mysqli_query($conn,"SELECT * FROM downpayment ");
    if (mysqli_num_rows($D) > 0) {
        mysqli_query($conn,"UPDATE downpayment SET d_price = '$downpaymentInDecimal' ");
    } else {
        mysqli_query($conn,"INSERT INTO downpayment(d_price) values ('$downpaymentInDecimal') ");
    }
    echo "Updated";
}