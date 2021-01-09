<?php 
include "../../includes/connect.php";

if (isset($_POST['type_id'])) {
	$type_id = $_POST['type_id'];

	$q = mysqli_query($conn,"DELETE FROM food_type where type_id = '$type_id' ");

	if ($q == true) {
		echo "Deleted";
	}
}

if (isset($_POST['type_id_edit'])) {
	$type_id = $_POST['type_id_edit'];

	$w = mysqli_query($conn,"SELECT * FROM food_type where type_id = '$type_id' ");

	while ($ww = mysqli_fetch_array($w)) {
		
		$e = mysqli_query($conn,"SELECT * FROM category where cat_id = '".$ww['cat_id']."' ");

		while ($ee = mysqli_fetch_array($e)) {
			$array = array(
				'food_type' => $ww['type_name'],
				'type_cat' => '<option value="'.$ee['cat_id'].'">'.$ee['cat_name'].'</option>'
			);
			echo json_encode($array);
		}
	}
}

if (isset($_POST['submitAdd'])) {
	$food_type = $_POST['food_type'];
	$type_cat = $_POST['type_cat'];

	$a = mysqli_query($conn,"INSERT INTO food_type (cat_id, type_name) values ('$type_cat', '$food_type') ");

	if ($a == true) {
		echo "Inserted";
	}
}