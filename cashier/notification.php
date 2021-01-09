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

  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page">
        <div class="tabs">
          <ul>
            <li class="w3-light-grey" style="width:100%;">Notification</li>
          </ul>
          <div class="tabs-content table-responsive">
            <?php
            $d = mysqli_query($conn,"SELECT * from reservation where r_status = 'pending'") or die(mysqli_query($conn));
            $dd = mysqli_query($conn,"SELECT * from food_order where status = 'pending'") or die(mysqli_query($conn));
            /*$ddd = mysqli_query($conn,"SELECT * from food_order where order_type = 'Dine in' status = 'Pending'") or die(mysqli_query($conn));
            $dddd = mysqli_query($conn,"SELECT * from food_order where order_type = 'Pick up' status = 'Pending'") or die(mysqli_query($conn));*/

            if (mysqli_num_rows($d) > 0 || mysqli_num_rows($dd) > 0) { ?>

            <table class="w3-white w3-left w3-bordered w3 w3-table">
              <tr>
                <th>Date</th>
                <th>Message</th>
              </tr>
                <?php
                while ($rr = mysqli_fetch_array($d)) { ?>
                  <tr>
                    <td><a href="reservation_view.php?rid=<?php echo $rr['rid'] ?>"><?php echo date("F d, Y",strtotime($rr['date_reserved'])); ?></a></td>
                    <td><a href="reservation_view.php?rid=<?php echo $rr['rid'] ?>"> You have new <b>reservation catering</b> request from <b><?php echo $rr['cu_first']." ".$rr['cu_last'] ?></b>.</a></td>
                  </tr>
                <?php
                }
                $date = date("Y-m-d");
                $date2 = date("Y-m-d", strtotime($date."-1 day"));

                while ($rrr = mysqli_fetch_array($dd)) { ?>
                  <tr>
                    <td><a href="d.php?i=<?php echo $rrr['order_id'] ?>"><?php echo date("F d, Y",strtotime($rrr['curr_order_date'])); ?></a></td>
                    <td><a href="d.php?i=<?php echo $rrr['order_id'] ?>"> You have new orders incoming this <?php echo date("M d, Y", strtotime($rrr['order_date'])) ?>.</a></td>
                  </tr>
                <?php
                }
              }
              else {
                echo "You have no notification!";
              }
              ?>
            </table>
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
