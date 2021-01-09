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
	<fieldset style="width:40%;margin:50px auto" class="qwwwwwwwwwwwww">
		<h4 class="w3-center w3-padding w3-text-grey">Email verification</h4>
		<form method="post" action="includes/forgot_password.inc.php">
			<label class="w3-text-blue">Email</label>
			<input type="email" name="email" class="w3-round w3-text-grey w3-border w3-border-blue" placeholder="Please type your email... " required>
			<div class="w3-right w3-center" style="width:100%">
				<button style="width:100%" class="w3-btn w3-green w3-round w3-padding w3-margin-top w3-margin-bottom" type="submit" name="submit_email">Submit</button>
			</div>
			<?php  

			if (isset($_GET['send'])) {
				if ($_GET['send'] == "error") { ?>
			<div id="error" class="w3-panel w3-left w3-round alert alert-danger w3-center" style="width: 100%">
				<?php echo "Sorry, the email you type is not available! "  ?>
			</div>
			<?php		
				} elseif ($_GET['send'] == "success") { ?>
			<div id="error" class="w3-panel w3-left w3-round alert alert-success w3-center" style="width: 100%">
			<?php echo "Please visit your email account to reset your password! "  ?>
			</div>
			<?php		
				}
			}

			?>
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
