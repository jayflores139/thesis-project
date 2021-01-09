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
		<h4 class="w3-center w3-padding w3-text-grey">Reset your password</h4>
		<form method="post" class="form_create" action="includes/create-password.inc.php">

			<input type="hidden" id="email_url" value="<?php echo $_GET['email'] ?>">

			<label class="w3-text-blue">New password</label>
			<input type="password" id="pass" class="w3-round w3-text-grey w3-border w3-border-blue" placeholder="Please type your new password... " required>
			<label class="w3-text-blue">Re-type password</label>
			<input type="password" id="pass2" class="w3-round w3-text-grey w3-border w3-border-blue" placeholder="Retype your password... " required>

			<div class="w3-right w3-center" style="width:100%">
				<button style="width:100%" class="w3-btn w3-green w3-round w3-padding w3-margin-top w3-margin-bottom" type="submit" id="submit">Submit</button>
			</div>

			<div id="error" class="w3-panel w3-left w3-round alert alert-danger w3-center" style="width: 100%;display: none">
				
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

		$(".form_create").submit(function(e){
			e.preventDefault();

			var email_url = $("#email_url").val();
			var pass = $("#pass").val();
			var pass2 = $("#pass2").val();
			var submit = $("#submit").val();

			$.ajax({

				url: "includes/create-password.inc.php",
				method: "POST",
				data: {
					email_url: email_url,
					pass: pass,
					pass2: pass2,
					submit: submit
				},
				success: function(data) {
					if (data == "Password does'nt match!") {
						$("#error").show();
						$("#error").text(data);
					} else if (data == "Your password has been reset") {
						location="login.php";
					}
				}

			});

		});

	});
</script>
