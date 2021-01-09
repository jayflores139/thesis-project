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
    <style>

  .button-group select, .button-group input, .button-group button{
    float:left;
    margin-right:5px;
    padding:6px 8px;
    height:40px;

  }
  .button-group{
    height:40px;
  }
  .button-group input{
    margin-left:10px;
  }
  p.btn{
    cursor: default;
  }

    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page w3-margin-bottom">
        <div class="tabs" style="margin-top:-10px;">
          <h2 class="w3-text-grey w3-margin-left">Reservation</h2>
          <h3 class="w3-padding w3-text-grey">
            <p class='w3-medium btn btn-default'>
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'pending' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Pending</p><span class='w3-medium w3-padding-small'>|</span>
            <p class='w3-medium btn btn-default'>
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'cancel' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Cancel</p><span class='w3-medium w3-padding-small'>|</span>
            <p class='w3-medium btn btn-default'>
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'approve' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Approve</p><span class='w3-medium w3-padding-small'>|</span>
            <p class='w3-medium btn btn-default'>
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'finish' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Finish</p><span class='w3-medium w3-padding-small'>|</span>
            <p class='w3-medium btn btn-default'>
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             All</p>

          </h3>

          <div class="button-group">
            <form id="form_search">
              <select class="w3-select w3-border change_reservation w3-left w3-border-blue w3-text-black w3-round" style="width:200px;">
                <option value="">--Select status--</option>
                <option value="Approve">Approved</option>
                <option value="Cancel">Cancelled</option>
                <option value="Finish">Finished</option>
                <option value="Pending">Pending</option>
              </select>

              <input type="text" id="datesasaass" autocomplete="off" class="w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="Booking Date">
               <input type="text" id="cu_name" autocomplete="off" class="w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="Search name">
              <button type="submit" id="submit_search" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Search</button>
            </form>
          </div>

          <div class="w3-margin-top">
            <table class="w3-border w3-text-grey w3-center" style="font-size:14px" id="table__ble">
              <tr class="w3-border w3-text-blue">
                <td class="w3-padding-medium">Date Reserved</td>
                <td>Customer</td>
                <td>Occasion</td>
                <td colspan="2">Booking Date</td>
                <td>Payable</td>
                <td>Downpayment</td>
                <td>Status</td>
                <td width="11%">Action</td>
              </tr>
              <?php  

              $q = mysqli_query($conn,"SELECT * FROM reservation");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) { ?>
              
                 <tr class="w3-border" id="removeRow<?php echo $qq['rid'] ?>">
                  <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
                  <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
                  <td class="w3-padding-medium">
                    <?php  
                    $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
                    $ww = mysqli_fetch_array($w);
                    echo $ww['event_name'];
                    ?>
                  </td>
                  <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
                  <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
                  <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
                  <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
                  <td class="w3-padding-medium">
                    <?php 

                    if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
                    <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                      <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                        <i class="fas fa-eye"></i>
                      </button>
                    </a>
                   <?php   
                    } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "" || $qq['r_status'] == "finish") { ?>
                    <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                      <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                        <i class="fas fa-eye"></i>
                      </button>
                    </a>
                      <?php
                    }

                     ?>
                  </td>
                </tr>

                <?php
                }
              } else {
                echo '
                  <tr>
                  <td colspan="9" align="center" class="w3-padding"> No reservation! </td>
                  </tr>
                ';
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
      $(document).ready(function(){

        $("#datesasaass").datepicker();

        $("#form_search").submit(function(e){
          e.preventDefault();

          var change_reservation = $(".change_reservation").val();
          var datesasaass = $("#datesasaass").val();
          var cu_name = $("#cu_name").val();
          var submit_search = $("#submit_search").val();

          if (change_reservation == "" && datesasaass == "" && cu_name == "") {
            location.reload();
          } else {
            $.ajax({
              url: "include/r_search.inc.php",
              method: "POST",
              data: {
                change_reservation: change_reservation,
                datesasaass: datesasaass,
                cu_name: cu_name,
                submit_search:submit_search
              },
              success: function(data){
                $("#table__ble").html(data);
              }
            });
          }
        });

      });
    </script>

  </body>
</html>
