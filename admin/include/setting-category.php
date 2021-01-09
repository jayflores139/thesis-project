<?php 
include "../../includes/connect.php";

if (isset($_POST['submit'])) {

	$food_categor = $_POST['food_categor'];

	$q = mysqli_query($conn,"INSERT INTO category (cat_name) VALUES ('$food_categor') ");

	if ($q == true) {
		echo "Inserted";
	}
}

if (isset($_POST['submit_edit_cat'])) {
	$cat_id = $_POST['cat_id'];

	$w = mysqli_query($conn,"SELECT * FROM category where cat_id='$cat_id' ");

	$ww = mysqli_fetch_array($w);

	echo $ww['cat_name'];
}

if (isset($_POST['submit_edit'])) {
	$food_categor = $_POST['food_categor'];
	$cat_id = $_POST['cat_id'];

	$e = mysqli_query($conn,"UPDATE category SET cat_name='$food_categor' where cat_id='$cat_id' ");

	if ($e == true) {
		echo "Updated";
	}
}

if (isset($_POST['cat_id_delete'])) {
	$cat_id = $_POST['cat_id_delete'];

	$r = mysqli_query($conn,"DELETE FROM category WHERE cat_id = '$cat_id' ");

	if ($r == true) {
		echo "Deleted";
	}
}