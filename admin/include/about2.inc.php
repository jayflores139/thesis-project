<?php  

include '../../includes/connect.php';

if (isset($_POST['edit_about_mission'])) {
	
	$ab_id = $_POST['ab_id_mission'];
	$content = $_POST['mission'];

	$update = mysqli_query($conn,"UPDATE about set content = '$content' where ab_id = '$ab_id' ");

	if ($update == true) {
		echo "Updated";
	}
}
?>