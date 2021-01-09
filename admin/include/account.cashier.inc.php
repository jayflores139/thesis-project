<?php 

include '../../includes/connect.php';

if (isset($_POST['submit'])) {
	
	$picture_acc = $_FILES['picture_acc']['name'];
	$name = $_POST['name'];
	$uname = $_POST['uname'];
	$contact = $_POST['contact'];

	$target = "../images/".basename($_FILES['picture_acc']['name']);

	if (empty($picture_acc)) {
		mysqli_query($conn,"UPDATE tbl_admin set Name = '$name', username = '$uname', contact = '$contact' where position = 'cashier' ");
		echo '<script>history.back()</script>';
	} else {
		mysqli_query($conn,"UPDATE tbl_admin set Name = '$name', username = '$uname', picture = '$picture_acc', contact = '$contact' where position = 'cashier' ");

		if (move_uploaded_file($_FILES['picture_acc']['tmp_name'], $target)) {
            echo '<script>history.back()</script>';
          }
	}

}