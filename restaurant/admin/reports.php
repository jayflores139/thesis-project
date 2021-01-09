<?php
  include '../includes/connect.php';
  session_start();
  $now = date("Y-m-d");
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
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

  .circlee {
    color:#53da71;
    padding:4px 5px;
    border-radius:5px;
   }
   .circlee1 {
    color:#e25d6e;
    border-radius:5px;
   }
   .circlee2 {
    color:#5d9de2;
    padding:4px 5px;
    border-radius:5px;
   }
   .circlee3 {
    color:#c25de2;
    padding:4px 5px;
    border-radius:5px;
   }
    </style>
  
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page">
        <div class="tabs" style="margin-top:-10px;">
          <h3 class="w3-padding w3-text-grey">
            <?php  
            if (isset($_GET['i'])) {
              if ($_GET['i'] == "sales") {
                echo "Sales";
              } elseif ($_GET['i'] == "orders") {
                echo "Orders";
              }elseif ($_GET['i'] == "reservations") {
                echo "Reservations";
              }
              echo " Reports";
            }
            ?>
          </h3>
          
          <div class="w3-left" style="width:100%">
              <button class="w3-right btn btn-default" onclick="printElem()" style="margin:5px"><i class="fas fa-print"></i> Print </button>
          </div><br><br>
        
        <div id="printFields">
          <?php  
            if (isset($_GET['i'])) {
              if ($_GET['i'] == "sales") { ?>
<!--SALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESSALESVVVSALESSALESALESSALESSALESSSALES-->
                <fieldset class="w3-margin-bottom">
              <legend class="w3-padding-0" style="width:auto;margin:0;font-size:15px">
                <ul class="w3-navbar nav-top">
                  <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=sales" class=" w3-hover-light-grey">Sales</a></li>
                  <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=orders" class=" w3-hover-light-grey">Orders</a></li>
                  <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=reservations" class=" w3-hover-light-grey">Reservations</a></li>
                </ul>
              </legend>
              <div class="button-group w3-margin-bottom w3-margin-top" style="width:60%;margin:0 auto">
                  <input type="text" id="date_from" class="date_from w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="From" style="margin-left:20px">
                  <input type="text" id="date_to" class="date_to w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="To" style="margin-left:20px">
                  <button type="button" id="submit_filter" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Filter</button>
              </div>
              <div class="w3-padding w3-center w3-border-bottom">
                <p class="text-info">Total Sales as of <span id="dateddd"><?php echo date("F d, Y") ?></span><span id="datedd2"></span>.</p>
              </div>
              <table class="w3-striped w3-text-black w3-centered" id="table__ble">
                <tr class=" w3-text-blue">
                  <td class="w3-padding-medium">Date</td>
                  <td>Food Menu</td>
                  <td>Price</td>
                  <td>Total Quantity</td>
                  <td align="center" style="padding-right:5px;">Amount</td>
                </tr>
                <?php  
                $now = date("Y-m-d");
                $nowto = date("Y-m-d", strtotime($now."+ 30 days"));
                $q = mysqli_query($conn,"SELECT * FROM food_menu order by food_name");
                $grand = 0;
                while ($qq = mysqli_fetch_array($q)) { ?>
                <tr class="w3-text-black">
                <?php
                  $w = mysqli_query($conn,"SELECT sum(food_order_details.food_qty) as totalQty, food_order.curr_order_date FROM food_order_details inner join food_order 
                              where food_order.order_id=food_order_details.order_id 
                              and ( food_order.status='Approve' and food_order.curr_order_date='$now') 
                              and food_order_details.food_id='".$qq['food_id']."' ") or die(mysqli_error($conn));
                  if (mysqli_num_rows($w) > 0) {
                    $total = 0;
                    while ($ww = mysqli_fetch_array($w)) { ?>
                    <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($now)) ?></td>
                    <td><?php echo $qq['food_name'] ?></td>
                    <td>P <?php echo number_format($qq['price'],2) ?></td>  
                    <td> <?php echo '('.$ww['totalQty'].')'; ?></td> 
                  <?php
                  $total += $qq['price'] * $ww['totalQty'];
                    }  
                    ?>
                    <td>P <?php echo number_format($total,2) ?></td>  
                  <?php   
                  }
                  $grand += $total;
                  ?> 
                  </tr>
                  <?php
                }
                ?>
                <tr class=" w3-flat-midnight-blue">
                  <td colspan="6" class="w3-padding w3-light-" style="text-align:right;font-size:19px">GRAND TOTAL: P <?php echo number_format($grand,2) ?></td>
                </tr>                
              </table>
            </fieldset> 
                <?php
              } elseif ($_GET['i'] == "orders") { ?>
<!--ORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERSORDERS-->
               <fieldset class="w3-margin-bottom">
                    <legend class="w3-padding-0" style="width:auto;margin:0;font-size:15px">
                      <ul class="w3-navbar nav-top">
                        <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=sales" class=" w3-hover-light-grey">Sales</a></li>
                        <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=orders" class=" w3-hover-light-grey">Orders</a></li>
                        <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=reservations" class=" w3-hover-light-grey">Reservations</a></li>
                      </ul>
                    </legend>
                    <div class="button-group w3-margin-bottom w3-margin-top" style="width:60%;margin:0 auto">
                        <input type="text" id="date_from" class="date_from_order w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="From" style="margin-left:20px">
                        <input type="text" id="date_to" class="date_to_order w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="To" style="margin-left:20px">
                        <button type="button" id="submit_filter_orers" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Filter</button>
                    </div>
                    <table class="w3-striped w3-text-black w3-centered" id="table__ble2">
                      <tr class="w3-text-blue">
                        <td class="w3-padding-medium">Food Menu</td>
                        <td>Date Order</td>
                        <td align="center" style="padding-right:5px;">Remarks</td>
                      </tr>

                      <?php  

                    $q = mysqli_query($conn, "SELECT * FROM food_menu");
                     while ($qq = mysqli_fetch_array($q)) { 
                                  ?>
                                
                  
                        <tr>
                          <td><?php echo $qq['food_name'] ?></td>
                          <td>
                            <?php 
                            $n = mysqli_query($conn,"SELECT food_order.curr_order_date from food_order inner join food_order_details where food_order.status='Approve' and food_order_details.food_id='".$qq['food_id']."' ");
                            $nn = mysqli_fetch_array($n);
                            echo date("M d, Y", strtotime($now));
                             ?>
                          </td>
                          <td> <br>
                            <span class='circlee'>
                            Delivery - <?php 
                              $w = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$now' and food_order.order_type='delivery' and food_order.status = 'Approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
                              $ww = mysqli_fetch_array($w);
                              echo $ww['remarkCount']." times</span><br>";
                             ?> 
                             <span class='circlee1'>
                            Dine-in - <?php 
                              $y = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date ='$now' and food_order.order_type='dinein' and food_order.status = 'Approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
                              $yy = mysqli_fetch_array($y);
                              echo " ".$yy['remarkCount']." times</span><br>";
                             ?> 
                             <span class='circlee2'>
                            Take out - <?php 
                              $m = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$now' and food_order.order_type='takeout' and food_order.status = 'Approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
                              $mm = mysqli_fetch_array($m);
                              echo " ".$mm['remarkCount']." times</span><br>";
                             ?> 
                             <span class='circlee3'>
                            Pick up - <?php 
                              $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$now' and food_order.order_type='pickup' and food_order.status = 'Approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
                              $gg = mysqli_fetch_array($g);
                              echo " ".$gg['remarkCount']." times</span><br>";
                             ?>
                             <span class='circlee3'>
                            Walk-in - <?php 
                              $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$now' and food_order.order_type='walk in' and food_order.status = 'Approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
                              $gg = mysqli_fetch_array($g);
                              echo " ".$gg['remarkCount']." times</span>";
                             ?>
                             <br>
                             <br>
                          </td>
                        </tr>

  <?php 
  }
   ?>
                      
                    </table>
            </fieldset> 
               <?php
              }elseif ($_GET['i'] == "reservations") { ?>
<!-- RESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATIONRESERVATION-->
              <fieldset class="w3-margin-bottom">
                  <legend class="w3-padding-0" style="width:auto;margin:0;font-size:15px">
                    <ul class="w3-navbar nav-top">
                      <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=sales" class=" w3-hover-light-grey">Sales</a></li>
                      <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=orders" class=" w3-hover-light-grey">Orders</a></li>
                      <li class="w3-padding-0 btn btn-default"><a href="reports.php?i=reservations" class=" w3-hover-light-grey">Reservations</a></li>
                    </ul>
                  </legend>
                  <div class="button-group w3-margin-bottom w3-margin-top" style="width:60%;margin:0 auto">
                      <input type="text" id="date_from" class="date_from_reser w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="From" style="margin-left:25px">
                      <input type="text" id="date_to" class="date_to_reser w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="To" style="margin-left:25px">
                      <button type="button" id="submit_filter_reser" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Filter</button>
                  </div>
                  <div class="w3-padding">
                  </div>
                  <table class=" w3-text-black w3-striped w3-centered" id="table__bleff">
                    <tr class="w3-text-blue">
                      <td class="w3-padding-medium">Date</td>
                      <td>Occasion</td>
                      <td>Remarks</td>
                    </tr>
                    <?php  

                    $q = mysqli_query($conn,"SELECT * FROM catering");
                    while ($qq = mysqli_fetch_array($q)) { ?>
                      <tr class="w3-text-black">
                      <?php                                     
                      $w = mysqli_query($conn,"SELECT count(cater_id) as countCatering FROM reservation where 
                        date_reserved = '$now' and (r_status='approve' || r_status='finish') and cater_id = '".$qq['cater_id']."' ");
                      $ww = mysqli_fetch_array($w);
                      ?>
                      <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($now)) ?></td>
                      <td><?php echo $qq['event_name']; ?></td>
                      <td>Reserve <?php echo $ww['countCatering']; ?> times</td>

                      </tr>
                    <?php
                    }
                    ?>
                  </table>
            </fieldset> 
            <?php
              }
            } else {
                echo "The Page is unavailable!";
              }
            ?>
            </div>
          </div>
        </div>
      </div>

    


    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
/*dateddd
datedd2*/

      $(document).ready(function(){

        $("#date_from").datepicker();
        $("#date_to").datepicker();


      $("#submit_filter").click(function(){
        var submit_filter = $(this).val();
        var date_from = $(".date_from").val();
        var date_to = $(".date_to").val();

        if (date_from != "" && date_to != "") {
          $("#dateddd").html(date_from);
          $("#datedd2").html(" to "+date_to);
          $("#dateddd").show(); 
          $("#datedd2").show();
        } else if (date_from == "") {
          $("#dateddd").hide();
          $("#datedd2").html(date_to);
          $("#datedd2").show();
        } else if (date_to == "") {
          $("#dateddd").show();
          $("#dateddd").html(date_from);
          $("#datedd2").hide();
        }

        if (date_from == "" && date_to == "") {
          window.location.reload();
        } else {
          $.ajax({
            url: "include/report_search.inc.php",
            method: "POST",
            data: {
              submit_filter: submit_filter,
              date_from: date_from,
              date_to: date_to
            },
            success: function(data){
              $("#table__ble").html(data);
            }
          });
        }

      });


      $("#submit_filter_orers").click(function(){
        var from = $(".date_from_order").val();
        var to = $(".date_to_order").val();
        var submit_filter_orers = $(this).val();
        if (from == "" && to == "") {
          window.location.reload();
        } else {
          $.ajax({
            url: "include/report_search.inc.php",
            method: "POST",
            data: {
              submit_filter_orers: submit_filter_orers,
              from: from,
              to: to
            },
            success: function(data2){
              $("#table__ble2").html(data2);
            }
          });
        }
      });
      
      $("#submit_filter_reser").click(function(){
        var date_from_reser = $(".date_from_reser").val();
        var date_to_reser = $(".date_to_reser").val();
        var submit_filter_reser = $(this).val();
        
        if (date_from_reser == "" && date_to_reser == ""){
            location.reload();
        }else {
            $.ajax({
               url: "include/report_search.inc.php",
               method: "POST",
               data: {
                  date_from_reser: date_from_reser,
                  date_to_reser: date_to_reser,
                  submit_filter_reser: submit_filter_reser
               },
               success: function(data2) {
                $("#table__bleff").html(data2);
               }
            });
        }
        
      });


      });
      
    function printElem() {
    var content = document.getElementById('printFields').innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=1000');

    mywindow.document.write('<html><head><title>Print</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}

    </script>
  </body>
</html>

