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
  <body style="background:#fcfcfc;">
    <?php include 'include/header.php'; ?>

    <div class="right-fixed green" style="background:#fcfcfc;">
      <div class="order_page" style="background:#fcfcfc; margin-top:5px;margin-bottom:15px;">

        <form class="make_reservation_form w3-center" autocomplete="off" action="reservation.inc.php" method="post">
            <h3 class="w3-text-blue">Reservation</h3>

            <label class="w3-left">First name <span class="w3-text-red">*</span></label>
            <input type="text" class="w3-input w3-padding w3-round w3-border w3-border-blue" name="cu_first" placeholder="First name" required>

            <label class="w3-left">Last name <span class="w3-text-red">*</span></label>
            <input type="text" class="w3-input w3-padding w3-round w3-border w3-border-blue" name="cu_last" placeholder="Last name" required>

            <label class="w3-left">Complete Address <span class="w3-text-red">*</span></label>
            <textarea name="cu_add" class="w3-border w3-padding w3-round w3-border-blue" rows="3" cols="80" placeholder="Complete address" required></textarea>

            <label class="w3-left">E-mail Address <span class="w3-text-red">*</span></label>
            <input type="email" class="w3-input w3-padding w3-round w3-border w3-border-blue" name="cu_email" placeholder="E-mail address" required>

            <label class="w3-left">Contact Number <span class="w3-text-red">*</span></label>
            <input type="text" class="w3-input w3-padding w3-round w3-border w3-border-blue" name="cu_phone" placeholder="Contact number" required>

            <label class="w3-left">Boking Date <span class="w3-text-red">*</span></label><br>
            <div class="w3-padding-0 w3-left" style="width:100%">
                <input type="text" class="w3-input w3-padding w3-round w3-border w3-border-blue w3-left" name="r_date_from" style="width:49%" id="booking_date_from" placeholder="From" required>

                <input type="text" class="w3-input w3-padding w3-round w3-border w3-border-blue w3-right" name="r_date_to" style="width:49%" id="booking_date_to" placeholder="To" required>
            </div>

            <button type="submit" class="w3-btn w3-round-small w3-blue" name="submit">Next</button>
          </div>

        </form>

      </div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $("#booking_date_from").datepicker();
      $("#booking_date_to").datepicker();
    </script>
  </body>
</html>
