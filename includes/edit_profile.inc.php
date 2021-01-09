<?php  
include 'connect.php';
session_start();

$id_user = $_SESSION['id_user'];

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$uname = $_POST['uname'];

$q = mysqli_query($conn,"UPDATE users set firstname = '$fname', lastname = '$lname', address = '$address', contact = '$contact', email = '$email', username = '$uname' where id = '$id_user' ");

if ($q == true) {
	header("location: ../my_account.php");
}

?>