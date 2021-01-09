<?php
  include '../includes/connect.php';
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

  $k = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
  $kk = mysqli_fetch_array($k);

  $p = mysqli_query($conn,"SELECT * FROM downpayment");
  $pp = mysqli_fetch_array($p);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'include/link.php'; ?>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="w3-padding w3-white w3-margin-bottom w3-center containersssss">

    <button class="btn btn-default w3-padding-small print_btn w3-round w3-right"><i class="fas fa-print"></i> Print</button>

  <div style="margin:10px;margin-top:50px">
    <button class="w3-btn w3-padding-small w3-light-grey w3-hover-white w3-round w3-left w3-text-blue" onclick="window.history.back()">Back</button>
    <?php
      if (isset($_GET['rid'])) {
        $rid = $_GET['rid'];

        $query = mysqli_query($conn,"SELECT * FROM reservation where rid = '$rid'") or die(mysqli_error($conn));

        if (mysqli_num_rows($query) > 0) {
          while ($q = mysqli_fetch_array($query)) {?>

          <fieldset style="margin-top:10px;margin:5px" class="w3-border-0 w3-center">
            <?php
            if ($q['r_status'] == "cancel") {
              echo ' <h3 class="w3-text-grey">Reservation Cancelled</h3> ';
            } elseif ($q['r_status'] == "pending") {
              echo ' <h3 class="w3-text-grey">Reservation Pending</h3> ';
            } elseif ($q['r_status'] == "approve") {
              echo ' <h3 class="w3-text-grey">Reservation Approve</h3> ';
            } elseif ($q['r_status'] == "finish") {
              echo ' <h3 class="w3-text-grey">Reservation Finished</h3> ';
            }
            ?>

          </fieldset>
<div id="printArea">
          <div class="col-md-12">
            <?php
              $quer = mysqli_query($conn,"SELECT * FROM reservation where rid = '$rid'") or die(mysqli_error($conn));
              while ($row = mysqli_fetch_array($quer)) {
                if ($row['r_status'] != "finish") {

                $down = mysqli_query($conn,"SELECT * FROM downpayment") or die(mysqli_error($conn));
                while ($downs = mysqli_fetch_array($down)) { ?>

            <div class="alert alert-danger" style="margin-top:10px;text-align:left;">
              <b>PLEASE READ</b><br><br>

              Note: If you choose pera padala as your mode of payment use this NAME - <span style="text-decoration:underline;"><?php echo $kk['Name'] ?></span> and CONTACT NUMBER - <span style="text-decoration:underline;"><?php echo $kk['contact'] ?></span>. <br> You must pay at least <?php echo $pp['d_price'] * 100 ?>% of the actual price as an advance payment 4 days before the booking date, if you failed to pay the said advance payment, reservation will be CANCEL.
            </div>

             <?php
             }
                }
              }
            ?>
          </div>

   <fieldset style="margin-top:10px;margin:5px" class="w3-border row w3-border-blue">
          <legend style="width:auto; padding:1px 5px;margin:0;font-size:18px" class="w3-text-blue">Booking Details</legend>
          <div  class="col-md-6" style="padding:5px">
            <table>
            <tr class="w3-border">
              <th class="w3-padding" width="30%">Name</th>
              <td><?php echo $q['cu_first'].' '.$q['cu_last'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Address</th>
              <td><?php echo $q['cu_add'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Contact number</th>
              <td><?php echo $q['cu_phone'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Boooking Date</th>
              <td><?php echo date("M d, Y", strtotime($q['r_date_from'])) ?> <span style="line-height:35px">-</span> <?php echo date("M d, Y", strtotime($q['r_date_to'])) ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Status</th>
              <td><?php echo $q['r_status'] ?></td>
            </tr>
          </table>
          </div>

          <div class="col-md-6" style="padding:5px">
            <table class=" w3-border">
        <?php
        $cater = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$q['cater_id']."'") or die(mysqli_error($conn));
        if (mysqli_num_rows($cater) > 0) {
          while ($caters = mysqli_fetch_array($cater)) { ?>
          <tr>
            <th class="w3-padding">Catering Services</th>
            <td><?php echo $caters['event_name'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Price per head</th>
              <td>P <?php echo number_format($caters['p_head'],2) ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Menu</th>
              <?php
              $check = mysqli_query($conn,"SELECT * FROM custom_r where r_id = '".$q['rid']."'") or die(mysqli_error($conn));
              if (mysqli_num_rows($check) > 0) { ?>
              <td>
                <a href="#print_also">
                  <button id="dialog-link" class="ui-button ui-widget w3-green w3-border-0" style="padding:1px 3px;">Customized</button>
                </a>
              </td>
              <?php
              } else { ?>
              <td> <span class="w3-blue" style="padding:1px 3px;">Not customized</span> </td>
              <?php
              }
              ?>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">No. of person</th>
              <td><?php echo $q['total_visitor'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Mode of payment</th>
              <td><?php echo $q['mode_of_payment'] ?></td>
            </tr>
            <tr class="w3-border">
              <td class="w3-padding" colspan="2"><?php echo $q['total_visitor'].' <span>&times;</span> P '.number_format($caters['p_head'],2) ?> =  P <?php echo number_format($q['total_visitor'] * $caters['p_head'],2 ) ?></td>
            </tr>
        <?php
          }
        }
        ?>
        </table>
          </div>
        </fieldset>

<?php //////////////////////////////////////////////////////////////////////////////para dili libug ?>
        <fieldset style="margin:5px;" class="w3-border w3-border-blue">
            <legend style="width:auto; padding:1px 5px;margin:0;font-size:18px" class="w3-text-blue">Payment Details</legend>

            <?php
            if ($q['r_status'] == "pending") { ?>



            <?php
            }
            ?>
            <div class="col-md-12 w3-center" style="margin:0 auto">
              <table>
                <tr class="w3-border">
                  <th class="w3-padding" style="text-align:right;">Payment Date</th>
                  <td align="left"><?php
                  if ( date("M d, Y", strtotime($q['r_date_from'].'-4 days')) == date("M d, Y")) {
                    echo "Today, ".date("M d, Y", strtotime($q['r_date_from'].'-4 days'));
                  } else {
                    echo date("M d, Y", strtotime($q['r_date_from'].'-4 days'));
                  }
                  ?></td>
                </tr>
                <tr class="w3-border">
                  <th class="w3-padding" style="text-align:right;">Total Payment</th>
                  <td align="left">P <?php echo number_format($q['payable'],2) ?></td>
                </tr>
                <tr class="w3-border">
                  <th class="w3-padding" style="text-align:right;">Balance</th>
                  <td align="left">P <?php echo number_format($q['balance'],2) ?></td>
                </tr>
                <tr class="w3-border">
                  <th class="w3-padding" style="text-align:right;">Down Payment</th>
                  <td align="left">P <?php echo number_format($q['downpayment'],2) ?></td>
                </tr>
              </table>
            </div>

          </fieldset>

<!-- ================CUSTOM MENU ===================-->
    <div class="print_also w3-border w3-border-blue w3-margin-top w3-padding-small" id="print_also" style="margin:5px">
      <div style="margin:0 auto;width:200px;" class="w3-center">
        <?php
          $check = mysqli_query($conn,"SELECT * FROM custom_r where r_id = '".$q['rid']."'") or die(mysqli_error($conn));
          if (mysqli_num_rows($check) > 0) { ?>
          <h3 class="w3-margin-bottom" style="text-decoration: underline;">Menu customized</h3>
          <?php
          } else { ?>
          <h3 class="w3-margin-bottom" style="text-decoration: underline;">Menu</h3>
          <?php
          }
          ?>
      <?php
      $e = mysqli_query($conn,"SELECT * FROM category") or die(mysqli_error($conn));
      if (mysqli_num_rows($e) > 0) {
        while ($ee = mysqli_fetch_array($e)) {
        echo "<b class='w3-light-grey' style='font-size:20px'>".$ee['cat_name']."</b><br>";

        $r = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$ee['cat_id']."'") or die(mysqli_error($conn));
          while ($rr = mysqli_fetch_array($r)) {
            echo "<b class='w3-text-blue' style='font-size:17px'>".$rr['type_name']."</b><br>";

            $t = mysqli_query($conn,"SELECT * FROM food_menu natural join custom_r where type_id = '".$rr['type_id']."' and r_id = '$rid'") or die(mysqli_error($conn));
            if (mysqli_num_rows($t) > 0) {
                if (mysqli_num_rows($t)) {
                    while ($tt = mysqli_fetch_array($t)) {
                      echo "<li>".$tt['food_name']."</li>";
                    }
                } else {
                  echo "<span class='w3-text-grey'>[ No menu added ]</span><br>";
              }
            } else {
              $t = mysqli_query($conn,"SELECT * FROM food_menu natural join catering_details where type_id = '".$rr['type_id']."' and cater_id = '".$q['cater_id']."'") or die(mysqli_error($conn));
              if (mysqli_num_rows($t) > 0) {
                 while ($tt = mysqli_fetch_array($t)) {
                    echo "<li>".$tt['food_name']."</li>";
                } 
              } else {
                  echo "<span class='w3-text-grey'>[ No menu added ]</span><br>";
              }
              
            }
          }
        }
      }
      ?>
      </div>
    </div>
<!-- ================CUSTOM MENU ===================-->
</div>
    <?php
      }
    }
      } else {
        echo 'index.php';
      }
      ?>

  </div>
</div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="../print/jQuery.print.min.js"></script>
    <script>
    $(document).ready(function(){

      $("#closest").click(function(){
        $(".modal-menu").hide(500);
      });

      $("#open_custom").click(function(){
        $(".modal-menu").css("display","block");
      });

      $('.print_btn').click(function(){
      $("#printArea").print();
    });


      $("#pending_btn").click(function(){
        var pending_input = $("#pending_input").val();
        var pending_input_hidden = $("#pending_input_hidden").val();
        var pending_btn = $(this).val();

        if (pending_input == "") {
          alert("Downpayment is required to complete the reservation!");
        } else {
          $.ajax({
            url: "include/add_payment.php",
            method: "POST",
            data: {
              pending_input: pending_input,
              pending_input_hidden: pending_input_hidden,
              pending_btn: pending_btn
            },
            success: function(data){
              alert(data);
              if (data == "Reservation approve!" || data == "Reservation finished!") {
                 window.location.reload();
              }
            }
          });
        }
      });


      $("#approve_btn").click(function(){
        var approve_input = $("#approve_input").val();
        var approve_input_hidden = $("#approve_input_hidden").val();
        var approve_btn = $(this).val();

        if (approve_input == "") {
          alert("Full payment is required!");
        } else {
          $.ajax({
            url: "include/add_payment.php",
            method: "POST",
            data: {
              approve_input: approve_input,
              approve_input_hidden: approve_input_hidden,
              approve_btn: approve_btn
            },
            success: function(data){
              alert(data);
              if (data == "Reservation approve!" || data == "Reservation finished!") {
                 window.location.reload();
              }
            }
          });
        }
      });


      $(".cancel_r").click(function(){

        var cancel = $(this).attr("id");
        var cancel_id_r = $("#cancel_id_r" + cancel).val();

        if (confirm("Are you sure?") == true) {
          $.ajax({
            url: "include/cancel_reservation.php",
            method: "POST",
            data: {
              cancel: cancel,
              cancel_id_r: cancel_id_r
            },
            success: function(data){
              if (data == "Cancelled!") {
                window.location.reload();
              } else if (confirm(data) == true) {
                var cancety = "YES";
               $.ajax({
                url: "include/cancel_reservation.php",
                method: "POST",
                data: {
                  cancety: cancety,
                  cancel_id_r: cancel_id_r
                },
                success: function(data2){
                  if (data2 == "Cancelled!") {
                    window.location.reload();
                  }
                }
              });
              }
            }
          });
        }

      });


    });
    </script>
  </body>
</html>