<?php  

include '../../includes/connect.php';

if (isset($_POST['edit_about_vision'])) {
	
	$ab_id = $_POST['ab_id_vision'];
	$content = $_POST['vision'];

	$update = mysqli_query($conn,"UPDATE about set content = '$content' where ab_id = '$ab_id' ");

	if ($update == true) {
		echo "Updated";
	}
}
?>