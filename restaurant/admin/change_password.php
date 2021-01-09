<?php
  include '../includes/connect.php';
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style type="text/css">
      textarea{
        width:100%;
        height:400px;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page">
        
          <div class="w3-white" style="height:auto;padding:20px 30px 100px 30px">

            <?php 

            if (isset($_GET['acc'])) {

              if ($_GET['acc'] == "admin") {
                $q = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
                while ($qq = mysqli_fetch_array($q)) { ?>

                  <div class="col-md-6">
                  <form method="post" id="form1" action="include/account.admin.inc.php">
                  <h3 class="w3-text-grey w3-center">Change Password</h3>

                  <label class="w3-small" style="font-weight:normal;">Current Password</label>
                  <input type="password" required class="w3-input w3-margin-bottom w3-border w3-border-teal" id="curr_pass" placeholder="Please type the current password">

                  <label class="w3-small" style="font-weight:normal;">New Password</label>
                  <input type="password" required class="w3-input w3-margin-bottom w3-border w3-border-teal" id="pass1" placeholder="Please type the new password">

                  <label class="w3-small" style="font-weight:normal;">Retype new Password</label>
                  <input type="password" required class="w3-input w3-margin-bottom w3-border w3-border-teal" id="pass2" placeholder="Retype password">
                  <input type="hidden" id="position" value="<?php echo $qq['position'] ?>">

                  <span class="w3-text-red w3-small" id="error"></span><br><br>

                  <button class="w3-btn w3-padding w3-blue" id="submit">SAVE CHANGES</button>
                  </form>
                </div>

                <?php
                }
              } elseif (isset($_GET['acc'])) {

                if ($_GET['acc'] == "cashier") {
                  $q = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'cashier' ");
                  while ($qq = mysqli_fetch_array($q)) { ?>

                    <div class="col-md-6">
                    <form method="post" id="form2" action="include/account.admin.inc.php">
                    <h3 class="w3-text-grey w3-center">Change Cashier Password</h3>

                    <label class="w3-small" style="font-weight:normal;">Current Password</label>
                    <input type="password" required class="w3-input w3-margin-bottom w3-border w3-border-teal" id="curr_pass" placeholder="Please type the current password">

                    <label class="w3-small" style="font-weight:normal;">New Password</label>
                    <input type="password" required class="w3-input w3-margin-bottom w3-border w3-border-teal" id="pass1" placeholder="Please type the new password">

                    <label class="w3-small" style="font-weight:normal;">Retype new Password</label>
                    <input type="password" required class="w3-input w3-margin-bottom w3-border w3-border-teal" id="pass2" placeholder="Retype password">
                    <input type="hidden" id="position" value="<?php echo $qq['position'] ?>">

                    <span class="w3-text-red w3-small" id="error"></span><br><br>

                    <button class="w3-btn w3-padding w3-blue" id="submit">SAVE CHANGES</button>
                    </form>
                  </div>

                  <?php
                  }
                }
              }
            } else {
              echo '<script>location="index.php"</script>';
            } 
               ?>

          </div>
        </div>
      </div>
    </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>

      $(document).ready(function(){

        $("#form1").submit(function(e){
          e.preventDefault();

          var curr_pass = $("#curr_pass").val();
          var pass1 = $("#pass1").val();
          var pass2 = $("#pass2").val(); 
          var submit = $("#submit").val();
          var position = $("#position").val();

          $.ajax({
            url: "include/change_password.inc.php",
            method:"POST",
            data:{
              curr_pass: curr_pass,
              pass1: pass1,
              pass2: pass2,
              submit: submit,
              position: position
            },
            success: function(data){

              if (data == "Updated") {
                location="accounts.php";
              } else {
                 $("#error").text(data);
              }
            }
          });

        });

        $("#form2").submit(function(e){
          e.preventDefault();

          var curr_pass = $("#curr_pass").val();
          var pass1 = $("#pass1").val();
          var pass2 = $("#pass2").val(); 
          var submit = $("#submit").val();
          var position = $("#position").val();

          $.ajax({
            url: "include/change_password.cashier.inc.php",
            method:"POST",
            data:{
              curr_pass: curr_pass,
              pass1: pass1,
              pass2: pass2,
              submit: submit,
              position: position
            },
            success: function(data){

              if (data == "Updated") {
                location="accounts.php";
              } else {
                 $("#error").text(data);
              }
            }
          });

        });
        
      });

    </script>
  </body>
</html>
