
<?php
session_start();
  include '../includes/connect.php';

  if (isset($_SESSION['user_id'])) {
    header("Location:index.php");
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style media="screen">
    *{
      box-sizing: border-box;
    }
    body{
      background-color: #31708f;
    }
    .log-in-form {
      height:auto;
      width:450px;
      transform:translate(-50%,-50%);
      top:40%;
      left: 50%;
      position: absolute;
      padding:0;
      background-color:#2a4163;
    }
    </style>
  </head>
  <body>
    <div class="log-in-form">
      <div class="log-in-form-content">

        <div class="log-in-form-contents w3-text-white w3-center">
          <h2>WELCOME</h2>
          <p class="w3-small">Tugkaran Restaurant Online Food Ordering and Reservation System</p>
        </div>

          <form action="login.inc.php" method="post" class="w3-white w3-padding-xlarge form" style="height:250px;" autocomplete="off">
            <label style="font-weight: normal;" class="w3-text-blue">Username</label>
            <input type="text" id="username" class="w3-input w3-border w3-border-blue-grey w3-margin-bottom" placeholder="Cashier username" required>
            <label style="font-weight: normal;" class="w3-text-blue">Password</label>
            <input type="password" id="password" class="w3-input w3-border w3-border-blue-grey" placeholder="Cashier password" required>
            <button type="submit" class="w3-blue w3-btn w3-margin-top w3-padding" style="width:100%" id="submit">Log in</button>
          </form>
          <span class="error w3-text-red"></span>
      </div>
    </div>
  </body>
</html>

<script>
  
  $(document).ready(function(){

    $(".form").submit(function(e){
      e.preventDefault();

      var username = $("#username").val();
      var password = $("#password").val();
      var submit = $("#submit").val();

      $.ajax({
        url: "include/login.inc.php",
        method: "POST",
        data: {
          username: username,
          password: password,
          submit: submit
        },
        success: function(da){
          if (da == "Log in successfully!") {
            location="index.php";
          } else {
          	alert(da);
          }
        }
      });

    });

  });

</script>
