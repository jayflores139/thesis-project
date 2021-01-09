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
      div#conn{
        width:100%;
        height:200px;
        background-color:#fff;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page">

  <div class="w3-white row" style="height:auto;padding:20px 30px 100px 30px">
    
    <?php  
    $q = mysqli_query($conn,"SELECT * FROM contact");
    while ($qq = mysqli_fetch_array($q)) { ?>
      
      <div class="w3-padding-large col-md-6">
        <div class="w3-padding w3-light-grey" style="height:auto;">
          <h4>Contact us</h4>
            <div name="contact" id="conn" class="w3-input w3-border-0"><?php echo $qq['content'] ?></div>
        </div>
      </div>
    <?php
     } 
    ?>

  </div>
        </div>
      </div>
    </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
    </script>
  </body>
</html>
