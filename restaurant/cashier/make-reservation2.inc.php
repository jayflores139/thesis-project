<?php
session_start();
include '../includes/connect.php';

$b = mysqli_query($conn,"SELECT * FROM menu_limit ");
$bb = mysqli_fetch_array($b);

$limit = $bb['MenuLimit'];

if (isset($_POST['submit'])) {

  $cater_id = $_POST['cater_id'];
  $visitor = $_POST['visitor'];
  $mode = $_POST['mode'];
  $cater_id = $_POST['cater_id'];
  $id = $_SESSION["r_id"];

  $query = mysqli_query($conn,"SELECT * FROM catering where cater_id='$cater_id'");
  $row = mysqli_fetch_array($query);
  $price = $row['p_head'];

    $payable = $visitor*$price;

    if (isset($_POST['food_id'])) {

      if (count($_POST['food_id']) != $limit) {
        echo '<script>alert("The menu limit is '.$limit.' only!");history.back()</script>';
      } else {
        foreach ($_POST['food_id'] as $value) {
            mysqli_query($conn,"INSERT INTO custom_r(r_id, food_id) values('$id','$value')") or die(mysqli_error($conn));
          }
          $d = mysqli_query($conn,"UPDATE reservation set cater_id='$cater_id', mode_of_payment='$mode', total_visitor='$visitor',
          payable='$payable', balance='$payable', r_status='pending' where rid='$id'") or die(mysqli_error($conn));

          if ($d) {
            header("Location:reservation_view.php?rid=$id");
          }
        }
      } else {
        $d = mysqli_query($conn,"UPDATE reservation set cater_id='$cater_id', mode_of_payment='$mode', total_visitor='$visitor',
          payable='$payable', balance='$payable', r_status='pending' where rid='$id'") or die(mysqli_error($conn));

          if ($d) {
            header("Location:reservation_view.php?rid=$id");
          }
      }
}

 ?>
