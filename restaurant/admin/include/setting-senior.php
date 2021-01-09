<?php  

include "../../includes/connect.php";

if (isset($_POST['submit'])) {
	$discount = $_POST['discount'];

	$discountInDecimal = $discount / 100;

	$q = mysqli_query($conn,"UPDATE dis_senior set discount = '$discountInDecimal' where dis_id = 1 ");

	echo "Updated";
}