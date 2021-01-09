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
      div#history,div#mission,div#vision{
        width:100%;
        height:400px;
        background-color:#fff;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page">
        
    <h3 class="w3-text-grey">About us</h3>
  <div class="w3-white row" style="height:auto;padding:20px 30px 100px 30px">
    
    <?php  
    $q = mysqli_query($conn,"SELECT * FROM about where remark = 'history' ");
    while ($qq = mysqli_fetch_array($q)) { ?>
      
      <div class="w3-padding-large col-md-4">
        <div class="w3-padding w3-light-grey" style="height:auto;">
          <h4>History</h4>
            <div id="history" class="w3-input"><?php echo $qq['content'] ?></div>
        </div>
      </div>

    <?php
      }
      ?>

      <?php  
    $q = mysqli_query($conn,"SELECT * FROM about where remark = 'mission' ");
    while ($qqq = mysqli_fetch_array($q)) { ?>
      
      <div class="w3-padding-large col-md-4">
        <div class="w3-padding w3-light-grey" style="height:auto;">
          <h4>Mision</h4>
            <div id="mission" class="w3-input"><?php echo $qqq['content'] ?></div>
        </div>
      </div>

    <?php
      }
      ?>

       <?php  
    $q = mysqli_query($conn,"SELECT * FROM about where remark = 'vision' ");
    while ($qqqq = mysqli_fetch_array($q)) { ?>
      
      <div class="w3-padding-large col-md-4">
        <div class="w3-padding w3-light-grey" style="height:auto;">
          <h4>Vision</h4>
          <form class="w3-center" method="POst" id="form_vision" action="include/about.inc.php">
            <div id="vision" class="w3-input"><?php echo $qqqq['content'] ?></div>
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

      $(document).ready(function(){
        
      });

    </script>
  </body>
</html>
