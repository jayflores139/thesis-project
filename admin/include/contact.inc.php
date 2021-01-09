<?php 

include '../../includes/connect.php';

	$contact = $_POST['contact'];
	$con_id = $_POST['con_id'];
    
    $q = mysqli_query($conn, "select * from contact ");
    if (mysqli_num_rows($q) > 0) {
       mysqli_query($conn,"UPDATE contact set content = '$contact' "); 
    } else {
        mysqli_query($conn,"INSERT INTO contact (content) VALUES ('$contact')");
    }
    header("Location: ../contact.php");
