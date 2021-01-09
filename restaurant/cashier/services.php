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
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed catering-page">
      <div class="search-con">
        <h2>Catering Services</h2>
        <a href="make-reservation.php">
          <button class="w3-btn w3-blue w3-round make-resevations">Make reservation</button>
        </a>
      </div>
      <div class="table-responsive w3-white" style="margin-top: 30px">
      <table class="w3-bordered w3-white w3-centered">
        <tr class="w3-ligt-grey w3-border w3-text-grey">
          <th >Occasion Name</th>
          <th>Price per head</th>
          <th>Combo Food</th>
        </tr>
        <?php $sql = mysqli_query($conn,"SELECT * FROM catering");
        while ($row = mysqli_fetch_array($sql)) { ?>
          <tr class="w3-border">
          <td class="w3-padding" align="left"><?php echo $row['event_name'] ?></td>
          <td class="w3-padding" align="left"><?php echo $row['p_head'] ?></td>
          <td class="w3-padding">
            <a href="services_view_menu.php?view=<?php echo $row['cater_id']; ?>">
              <button class="w3-hover-grey w3-light-grey w3-border-0">view</button>
            </a>
          </td>
        </tr>
      <?php  } ?>
      </table>
    </div>

    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      
    </script>
  </body>
</html>
