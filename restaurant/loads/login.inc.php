<?php

include "../includes/connect.php";
session_start();
$errorEmpty = false;
$errorPass = false;
if (isset($_POST['btn_log'])) {
	$uname = $_POST['uname_log'];
	$pass = $_POST['pass_log'];

	if (empty($uname) || empty($pass)) {
		echo "Please fill in all fields!";
		$errorEmpty = true;
	}else{
		$sql = mysqli_query($conn,"SELECT * FROM users WHERE username='$uname' AND password='$pass'");
		if (mysqli_num_rows($sql)>0) {
			while ($row = mysqli_fetch_array($sql)) {
				$_SESSION['userId'] = $row['id'];
				}
				echo '<script> window.location.href="menu.php"</script>';
			}else{
				echo "Username or Password is incorrect!";
				$errorPass = true;
			}
	}
}

 ?>

 <script>
 	var x = "<?php echo $errorEmpty; ?>";
 	var y = "<?php echo $errorPass; ?>";

 	if (x==true) {
 		$("#uname_log, #pass_log").css({"backgroundColor":"#ffe6e6","border":"1px solid #ffb3b3"});
 	}else{
		if (y==true) {
	 		$("#uname_log, #pass_log").css({"backgroundColor":"#ffe6e6","border":"1px solid #ffb3b3"});
	 	}
	}

 </script>
