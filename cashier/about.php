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
        
    <h3 class="w3-text-grey">About us</h3>
  <div class="w3-white row" style="height:auto;padding:20px 30px 100px 30px">
    
    <?php  
    $q = mysqli_query($conn,"SELECT * FROM about where remark = 'history' ");
     while ($qq = mysqli_fetch_array($q)) { ?>
      
      <div class="w3-padding-large col-md-4">
        <div class="w3-padding w3-light-grey" style="height:auto;">
          <h4>History</h4>
          <form class="w3-center" method="POst" id="form_history">
            <textarea id="history" disabled class="w3-input w3-border"><?php echo $qq['content'] ?></textarea>
            <input type="hidden" id="ab_id_history" value="<?php echo $qq['ab_id'] ?>">
           </form>
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
          <form class="w3-center" id="form_mission" method="POst" action="include/about.inc.php">
            <textarea id="mission" disabled class="w3-input w3-border"><?php echo $qqq['content'] ?></textarea>
            <input type="hidden" id="ab_id_mission" value="<?php echo $qqq['ab_id'] ?>">
           </form>
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
            <textarea id="vision" disabled class="w3-input w3-border"><?php echo $qqqq['content'] ?></textarea>
            <input type="hidden" id="ab_id_vision" value="<?php echo $qqqq['ab_id'] ?>">
           </form>
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

        $("#form_history").submit(function(e){
          e.preventDefault();

          var history = $("#history").val();
          var ab_id_history = $("#ab_id_history").val();
          var edit_about_history = $("#edit_about_history").val();

         if (history == "") {
          location.reload();
         } else {
          $.ajax({
            url: "include/about.inc.php",
            method: "POST",
            data: {
              history: history,
              ab_id_history: ab_id_history,
             edit_about_history: edit_about_history 
            },
            success: function(data){
              if (data == "Updated") {
                location.reload();
              }
            }
          })
         }

        });

        $("#form_mission").submit(function(e){
          e.preventDefault();

          var mission = $("#mission").val();
          var ab_id_mission = $("#ab_id_mission").val();
          var edit_about_mission = $("#edit_about_mission").val();

         if (mission == "") {
          location.reload();
         } else {
          $.ajax({
            url: "include/about2.inc.php",
            method: "POST",
            data: {
              mission: mission,
              ab_id_mission: ab_id_mission,
             edit_about_mission: edit_about_mission 
            },
            success: function(data){
              if (data == "Updated") {
                location.reload();
              }
            }
          })
         }

        });

        $("#form_vision").submit(function(e){
          e.preventDefault();

          var vision = $("#vision").val();
          var ab_id_vision = $("#ab_id_vision").val();
          var edit_about_vision = $("#edit_about_vision").val();

         if (vision == "") {
          location.reload();
         } else {
          $.ajax({
            url: "include/about3.inc.php",
            method: "POST",
            data: {
              vision: vision,
              ab_id_vision: ab_id_vision,
             edit_about_vision: edit_about_vision 
            },
            success: function(data){
              if (data == "Updated") {
                location.reload();
              }
            }
          })
         }

        });
        
      });

    </script>
  </body>
</html>
