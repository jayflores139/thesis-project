<?php  

include '../../includes/connect.php';

if (isset($_POST['edit_about_history'])) {
	
	$ab_id = $_POST['ab_id_history'];
	$content = $_POST['history'];

	$update = mysqli_query($conn,"UPDATE about set content = '$content' where ab_id = '$ab_id' ");

	if ($update == true) {
		echo "Updated";
	}
}
?>