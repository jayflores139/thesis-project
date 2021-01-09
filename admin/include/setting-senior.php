<?php  

include "../../includes/connect.php";

if (isset($_POST['submit'])) {
	$discount = $_POST['discount'];

	$discountInDecimal = $discount / 100;
    
    $w = mysqli_query($conn,"SELECT * FROM dis_senior ");
    if (mysqli_num_rows($w) > 0) {
        mysqli_query($conn,"UPDATE dis_senior set discount = '$discountInDecimal' ") or die(mysqli_error($conn));
    } else {
        mysqli_query($conn,"INSERT INTO dis_senior (discount) VALUES ('$discountInDecimal')");
    }
    echo "Updated";
}