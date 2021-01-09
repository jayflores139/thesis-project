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

<div class="container w3-light-grey" style="height:auto">
	<fieldset style="margin:50px auto;float:none" class="qwwwwwwwwwwwww col-md-6">
    <h4 class="w3-margin w3-center w3-text-grey">Sign up</h4>
		<form id="sign_up_form">

        <label class="w3-text-blue">First Name <span class="w3-text-red">*</span></label>
      <input type="text" name="fname" class="w3-round w3-border w3-border-blue" id="fname" placeholder="First name" required>

      <label class="w3-text-blue">Last Name <span class="w3-text-red">*</span></label>
      <input type="text" name="lname" class="w3-round w3-border w3-border-blue" id="lname" placeholder="Last name" required>

      <label class="w3-text-blue">Contact number <span class="w3-text-red">*</span></label>
      <input type="text" name="cnum" class="w3-round w3-border w3-border-blue" id="cnum" placeholder="Contact number" required>

      <label class="w3-text-blue">Address <span class="w3-text-red">*</span></label>
      <input type="text" name="address" class="w3-round w3-border w3-border-blue" id="address" placeholder="Address" required>

      <label class="w3-text-blue ">Gender <span class="w3-text-red">*</span></label>
      <select name="gender" class="w3-round w3-border w3-border-blue" id="gender">
        <option value="F">Female</option>
        <option value="M">Male</option>
      </select>

      <label class="w3-text-blue">Email <span class="w3-text-red">*</span></label>
      <input type="email" name="email" class="w3-round w3-border w3-border-blue" id="email" placeholder="Email" required>

      <label class="w3-text-blue">Username <span class="w3-text-red">*</span></label>
      <input type="text" name="username" class="w3-round w3-border w3-border-blue" id="username" placeholder="Username" required>

      <label class="w3-text-blue">Password <span class="w3-text-red">*</span></label>
      <input type="password" name="password" class="w3-round w3-border w3-border-blue" id="password" placeholder="Password" required>

      <label class="w3-text-blue">Confirm password <span class="w3-text-red">*</span></label>
      <input type="password" name="password2" class="w3-round w3-border w3-border-blue" id="password2" placeholder="Confirm password" required>

      <div class="w3-center">
        <button class="w3-btn w3-green w3-center w3-padding w3-green w3-round" type="submit" id="sign_up" name="signup" style="width:100%">Sign up</button><br><br>
      <a href="login.php" class=" w3-center btn btn-default">Log in</a>
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
    $("#sign_up_form").submit(function(event){
      event.preventDefault();

      var fname = $("#fname").val();
      var lname = $("#lname").val();
      var cnum = $("#cnum").val();
      var address = $("#address").val();
      var gender = $("#gender").val();
      var username = $("#username").val();
      var password = $("#password").val();
      var password2 = $("#password2").val();
      var sign_up = $("#sign_up").val();
      var email = $("#email").val();

      $.ajax({
        url:"includes/signup.inc.php",
        method:"POST",
        data:{
          fname:fname,
          lname:lname,
          cnum:cnum,
          address:address,
          gender:gender,
          email:email,
          username:username,
          password:password,
          password2:password2,
          sign_up:sign_up
        },

        success:function(data){
          alert(data);
          if (data == "Sign up Successfully!") {
            window.location="index.php";
          }
        }
      });

    });
  });

</script>
