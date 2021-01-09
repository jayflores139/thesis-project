<?php  
include '../../includes/connect.php';
if (isset($_POST['delete_id'])) {
	$id = $_POST['delete_id'];
	$q = mysqli_query($conn,"DELETE FROM tbl_admin where id = '$id' ") or die(mysqli_error($conn));
	if ($q == true) {
		echo "del";
	}
}