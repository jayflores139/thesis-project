<?php  
include "../../includes/connect.php";

$r = false;

	if (isset($_POST['submit-update'])) {
		$hidden_id_edit = $_POST['hidden_id_edit'];
		$occasion_edit = $_POST['occasion_edit'];
		$price_edit = $_POST['price_edit'];
		$PMin = $_POST['PMin']; 
		$PMax = $_POST['PMax'];

		$u = mysqli_query($conn,"UPDATE catering set event_name='$occasion_edit',price='$price_edit', PMin = '$PMin', PMax = '$PMax' WHERE cater_id='$hidden_id_edit'")
		or die(mysqli_error($conn));

		if ($u == true) {
			$r = true;
		}

		if (isset($_POST['selected_food'])) {
			if (!empty($_POST['selected_food'])) {
				
			$q = mysqli_query($conn,"SELECT * FROM catering_details where cater_id='$hidden_id_edit' ") or die(mysqli_error($conn));
			if (mysqli_num_rows($q) > 0) {
				mysqli_query($conn,"DELETE FROM catering_details where cater_id='$hidden_id_edit' ");
			}
			foreach ($_POST['selected_food'] as $value) {
				mysqli_query($conn,"INSERT INTO catering_details (cater_id, food_id) VALUES ('$hidden_id_edit', '$value')") or die(mysqli_error($conn));
			}
			$r = true;
			}
		}
		if ($r == true) {
			echo '<script>location="../services_edit.php?edit='.$hidden_id_edit.'&update=success"</script>';
		}
	}