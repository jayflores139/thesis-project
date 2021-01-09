<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
  include '../includes/connect.php';
  $k = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
  $kk = mysqli_fetch_array($k);

  $p = mysqli_query($conn,"SELECT * FROM downpayment");
  $pp = mysqli_fetch_array($p);

  $today = date("Y-m-d");
  $valid_booking_date = date("Y-m-d",strtotime($today."+ 4 days"));

  if (isset($_POST['submit1'])) {
    $validate = false;

    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $cAddress = $_POST['cAddress'];
    $cNumber = $_POST['cNumber'];
    $cEmail = $_POST['cEmail'];

    $bookFrom = $_POST['bookFrom'];
    $bookTo = $_POST['bookTo'];

    $rDateFrom = date("Y-m-d", strtotime($bookFrom));
    $rDateto = date("Y-m-d", strtotime($bookTo));

    $q = mysqli_query($conn,"SELECT * FROM reservation where r_status = 'approve' ");

      while ($qq = mysqli_fetch_array($q)) {
        if ($rDateFrom >= $qq['r_date_from'] && $rDateto <= $qq['r_date_to']) {
          $validate = true;
          echo '<script>alert("Booking date is already reserved!");history.back()</script>';
        }
      }

      if ($rDateFrom <= $today || $rDateto <= $today) {
          echo '<script>alert("Invalid booking date!\nBooking date should be 4 days advance from current date!");history.back()</script>';
          $validate = true;
      } elseif ($rDateFrom > $rDateto) {
          echo '<script>alert("Invalid booking date!");history.back()</script>';
          $validate = true;
      } elseif ($rDateFrom < $valid_booking_date || $rDateto < $valid_booking_date) {
          echo '<script>alert("Invalid booking date!\nBooking date should be 4 days advance from the current date!");history.back()</script>';
          $validate = true;
      }

      if ($validate == false) {
        mysqli_query($conn,"INSERT into reservation (cu_first, cu_last, cu_add, cu_mail, cu_phone, r_date_from, r_date_to, date_reserved)
          values ('$fName', '$lName', '$cAddress', '$cEmail', '$cNumber', '$rDateFrom', '$rDateto', '$today')") or die(mysqli_error($conn));

        $id = mysqli_insert_id($conn);
        $_SESSION['r_id'] = $id;

        echo '<script>location="make-reservation2.php"</script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style type="text/css">
      label{
        font-weight: normal;
        width:100%;
      }
    </style>
  </head>
  <body style="background:#fcfcfc;">
    <?php include 'include/header.php'; ?>

    <div class="right-fixed green" style="background:#fcfcfc;margin-bottom:80px">
      <div class="order_page" style="background:#fcfcfc; margin-top:5px;margin-bottom:15px;">

          <h3 class="w3-text-blue">Reservation</h3>
            
          <div class="row">
            <form action="" method="post" style="margin:0 auto">
            <div class="col-md-6">
              <div class="w3-padding">
                
                <label>
                  First Name
                  <input type="text" name="fName" class="w3-input w3-border w3-border-grey w3-round-small" required>
                </label> <br><br>

                <label>
                  Last Name
                  <input type="text" name="lName" class="w3-input w3-border w3-border-grey w3-round-small" required>
                </label> <br><br>

                <label>
                  Complete Address
                  <textarea name="cAddress" class="w3-input w3-border w3-border-grey w3-round-small" required></textarea>
                </label> <br><br>

              </div>
            </div>

            <div class="col-md-6">
              <div class="w3-padding">
                <label>
                  Contact Number
                  <input type="tel" name="cNumber" class="w3-input w3-border w3-border-grey w3-round-small" required>
                </label> <br><br>

                <label>
                  Email Address
                  <input type="email" name="cEmail" class="w3-input w3-border w3-border-grey w3-round-small" required>
                </label> <br><br>

                <label>
                  Booking date <br>
                  <input type="text" name="bookFrom" placeholder="from" id="date1" class="w3-input w3-border w3-border-grey w3-left w3-round-small" required style="width:45%">
                  <input type="text" name="bookTo" placeholder="to" id="date2" class="w3-input w3-border w3-border-grey w3-right w3-round-small" required style="width:45%">
                </label> <br><br>

                <button class="w3-btn w3-round-small w3-light-grey w3-border" name="submit1">Next</button>

              </div>
            </div>
            </form> 
          </div>
              </div>
            </div>
            </form> 
          </div>

      </div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $(document).ready(function(){
        $("#date1,#date2").datepicker();

        $(".cater_id").click(function(){
          var cater_id = $(this).attr("id");

          var cater_n = $(".cater_n").attr("id");
          $(".caterddddd").text(cater_n);
          
          $.ajax({
            url:"include/load_menu.php",
            method:"POST",
            data: {
              cater_id: cater_id
            },
            success: function(d) {
              $(".loadMenu").html(d);
            }
          });
        });

        $(".custom").click(function(){
         
          $(".loadMenu").load("include/loadAll.php"); 

        });

        });

    </script>
  </body>
</html>
