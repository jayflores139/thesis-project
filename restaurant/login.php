<?php

session_start();
include "includes/connect.php";
if (isset($_SESSION['id_user'])) {
  header("Location:index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylesheet/style0.css">
	<link rel="stylesheet" type="text/css" href="includes/icon/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/w3.css">
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
		$height = false;
?>

<div class="container w3-light-grey" style="height:470px;">
	<fieldset style="float:none;margin:50px auto" class="qwwwwwwwwwwwww col-md-5">
		<h4 class="w3-center w3-padding w3-text-grey">Log in</h4>
		<form method="post" action="includes/login.inc.php">
			<label class="w3-text-blue">Username</label>
			<input type="text" name="username" class="w3-round w3-border w3-border-blue" placeholder="Username" required>
			<label class="w3-text-blue">Password</label>
			<input type="password" name="password" class="w3-round w3-border w3-border-blue" placeholder="Password" required>

			<div class="w3-right w3-center" style="width:100%">
				<button style="width:100%" class="w3-btn w3-green w3-round w3-padding w3-margin-top w3-margin-bottom" type="submit" name="login">Login</button>
			</div>
			<div class="w3-left w3-center" style="width:100%">
				<a href="forgot_password.php" class="w3-text-blue">Forgot password?</a><br>
				<a href="signup.php" class="w3-text-blue">Sign up!</a>
			</div>
		</form>
	</fieldset>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	var sad = "<?php echo $height ?>";
	if (sad == true) {
		$("#rowsss").css("height", "400px");
	}

	$(document).ready(function(){
	});
</script>
