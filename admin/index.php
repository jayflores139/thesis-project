<?php
  session_start();
  include '../includes/connect.php';
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style>
        .right-fixed{
            position:fixed;
            top:0;
            left:20%;
            height:90%;
            padding:10 10px 40px 10px;
        }
         .right-fixed img {
             width:100%;
             height:100%;
         }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed">
        <img src="images/fff.jpg">
    </div>
    <script>
      $("#tabs").tabs();
    </script>
  </body>
</html>
