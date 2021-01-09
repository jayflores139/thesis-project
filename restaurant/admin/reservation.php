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
            <button class='w3-medium btn btn-default status' id="pending">
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'pending' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Pending</button><span class='w3-medium w3-padding-small'>|</span>
            <button class='w3-medium btn btn-default status' id="cancel">
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'cancel' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Cancel</button><span class='w3-medium w3-padding-small'>|</span>

            <button class='w3-medium btn btn-default status' id="approve">
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'approve' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Approve</button><span class='w3-medium w3-padding-small'>|</span>

            <button class='w3-medium btn btn-default status' id="finish">
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation where r_status = 'finish' ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             Finish</button><span class='w3-medium w3-padding-small'>|</span>

            <button class='w3-medium btn btn-default' onclick="location.reload()" id="all">
              <?php 
                $e = mysqli_query($conn,"SELECT COUNT(r_status) as count from reservation ");
                $ee = mysqli_fetch_array($e);
                echo $ee['count'];
               ?>
             All</button>

          </h3>

          <div class="button-group">
            <form id="form_search">
              <input type="text" id="datesasaass" class="form-control w3-left w3-text-grey w3-round" style="width:30%" placeholder="Booking Date">
               <input type="text" id="cu_name" class="form-control w3-left w3-text-grey w3-round" style="width:30%" placeholder="Search name">
              <button type="submit" id="submit_search" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Search</button>
            </form>
          </div>

          <div class="w3-margin-top">
            <table class="w3-striped w3-text-grey w3-center w3-border w3-border-grey" style="font-size:14px" id="table__ble">
              <tr class="w3-text-grey">
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
              
                 <tr id="removeRow<?php echo $qq['rid'] ?>">
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

                    <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                      <button class="btn btn-default">
                        <i class="fas fa-search"></i> View
                      </button>
                    </a>

                     <input type="hidden" id="del<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
                      <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                        <i class="fas fa-trash-alt"></i> Delete
                      </button>

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

          var datesasaass = $("#datesasaass").val();
          var cu_name = $("#cu_name").val();
          var submit_search = $("#submit_search").val();

          if (datesasaass == "" && cu_name == "") {
            location.reload();
          } else {
            $.ajax({
              url: "include/r_search.inc.php",
              method: "POST",
              data: {
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

        $(".delete").click(function(){
            var delelte = $(this).attr("id");

            if (confirm("Are you sure?") == true) {
              $.ajax({
                url: "include/r_delete.inc.php",
                method:"POST",
                data:{delelte: delelte},
                success:function(data){
                  if (data == "Deleted") {
                    $("#removeRow"+delelte).remove();
                  }
                }
              });
            }
          });

        $(".status").click(function(){
          var status = $(this).attr("id");

          $.ajax({
              url: "include/r_search.inc.php",
              method: "POST",
              data: {
                status: status
              },
              success: function(data){
                $("#table__ble").html(data);
              }
            });

        });

      });
    </script>

  </body>
</html>
