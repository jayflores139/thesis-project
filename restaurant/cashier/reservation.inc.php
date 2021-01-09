<?php
session_start();
include '../includes/connect.php';

if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

if (isset($_POST['submit'])) {
  $cu_first = $_POST['cu_first'];
  $cu_last = $_POST['cu_last'];
  $cu_add = $_POST['cu_add'];
  $cu_email = $_POST['cu_email'];
  $cu_phone = $_POST['cu_phone'];

  $today = date("Y-m-d");
  $valid_booking_date = date("Y-m-d",strtotime($today."+ 4 days"));

  $date_from = $_POST['r_date_from'];
  $date_to = $_POST['r_date_to'];

  $booking_date_from = date("Y-m-d",strtotime($date_from));
  $booking_date_to = date("Y-m-d",strtotime($date_to));

  $dd = mysqli_query($conn,"SELECT * from reservation where r_status='approve'  ") or die(mysqli_error($conn));

    $find = false;
    while ($ddd = mysqli_fetch_array($dd)) {
      
      $from = $ddd['r_date_from'];
      $to = $ddd['r_date_to'];

      if ($booking_date_from >= $from && $booking_date_to <= $to) {
        echo '<script>alert("Booking date is already reserved!");history.back()</script>';

        $find = true;
      }
      else {
        $find = false;
      }
    }

    if ($booking_date_from <= $today || $booking_date_to <= $today) {
      echo '<script>alert("Invalid booking date!\nBooking date should be 4 days advance from current date!");history.back()</script>';
      $find = true;
    }
    elseif ($booking_date_from > $booking_date_to) {
      echo '<script>alert("Invalid booking date!");history.back()</script>';

      $find = true;
    }
    elseif ($booking_date_from < $valid_booking_date || $booking_date_to < $valid_booking_date) {
			echo '<script>alert("Invalid booking date!\nBooking date should be 4 days advance from the current date!");history.back()</script>';
			$find = true;
		}

    if ($find == false) {
       mysqli_query($conn,"INSERT into reservation (cu_first, cu_last, cu_add, cu_mail, cu_phone, r_date_from, r_date_to, date_reserved)
        values ('$cu_first', '$cu_last', '$cu_add', '$cu_email', '$cu_phone', '$booking_date_from', '$booking_date_to', '$today')") or die(mysqli_error($conn));
        $id = mysqli_insert_id($conn);
        $_SESSION['r_id'] = $id;
        echo '<script>document.location="make-reservation2.php"</script>';
    }

}
 ?>
