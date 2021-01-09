<?php

session_start();
include "includes/connect.php";

if (!isset($_SESSION['id_user'])) {
  header("location:login.php");
} else {
  $id_user = $_SESSION['id_user'];
}

$today = date("Y-m-d");
$valid_booking_date = date("Y-m-d", strtotime($today."+ 4 days"));
  
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
          mysqli_query($conn,"INSERT into reservation (cu_id, cu_first, cu_last, cu_add, cu_mail, cu_phone, r_date_from, r_date_to, date_reserved)
            values ('$id_user', '$fName', '$lName', '$cAddress', '$cEmail', '$cNumber', '$rDateFrom', '$rDateto', '$today')") or die(mysqli_error($conn));

          $id = mysqli_insert_id($conn);

          header("Location: make-reservation2.php?id=".$id);
      }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tugkaran Home Page</title>
  <?php include 'includes/links.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="stylesheet/style0.css">
  <link rel="stylesheet" type="text/css" href="includes/icon/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="admin/css/w3.css">
  <style type="text/css">
    label{
      width:100%;
      text-align: left;
    }
  </style>
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
    $height = false;
?>

<div class="container w3-light-grey w3-margin-bottom">
  
  <div>
    <div class="row w3-center" id="rowsss"  style="margin:10px;">
        <div class="right-fixed green" style="background:#fcfcfc;margin-bottom:80px">
      <div style="background:#fcfcfc; margin-top:5px;margin-bottom:15px;padding: 30px 50px 30px 50px">

          <h3 class="w3-text-blue">Reservation</h3>
            
          <div class="row">
            <form action="" method="post" style="margin:0 auto">
            <div class="col-md-6">
              <div class="w3-padding">
                <?php  
                $b = mysqli_query($conn,"SELECT * FROM users where id = '$id_user' ");
                $bb = mysqli_fetch_array($b);
                ?>
                <label>
                  First Name
                  <input type="text" name="fName" class="w3-input w3-border w3-border-grey w3-round-small" value="<?php echo $bb['firstname'] ?>" required>
                </label> <br><br>

                <label>
                  Last Name
                  <input type="text" name="lName" class="w3-input w3-border w3-border-grey w3-round-small" value="<?php echo $bb['lastname'] ?>" required>
                </label> <br><br>

                <label>
                  Complete Address
                  <textarea name="cAddress" class="w3-input w3-border w3-border-grey w3-round-small" required><?php echo $bb['address'] ?></textarea>
                </label> <br><br>

              </div>
            </div>

            <div class="col-md-6">
              <div class="w3-padding">
                <label>
                  Contact Number
                  <input type="tel" name="cNumber" class="w3-input w3-border w3-border-grey w3-round-small" value="<?php echo $bb['contact'] ?>" required>
                </label> <br><br>

                <label>
                  Email Address
                  <input type="email" name="cEmail" class="w3-input w3-border w3-border-grey w3-round-small" value ="<?php echo $bb['email'] ?> " required>
                </label> <br><br>

                <label>
                  Booking date <br>
                  <input type="text" name="bookFrom" placeholder="from" id="date1" class="w3-input w3-border w3-border-grey w3-left w3-round-small" required style="width:45%">
                  <input type="text" name="bookTo" placeholder="to" id="date2" class="w3-input w3-border w3-border-grey w3-right w3-round-small" required style="width:45%">
                </label> <br><br>

                <button class="w3-btn w3-round-small w3-green w3-right" style="width:200px" name="submit1">Next</button>
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
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
  $("#date1,#date2").datepicker();
  var sad = "<?php echo $height ?>";
  if (sad == true) {
    $("#rowsss").css("height", "600px");
  }
</script>
