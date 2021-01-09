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

  //cancel
  if (isset($_GET['p'])) {
    $rid = $_GET['p'];

    mysqli_query($conn,"UPDATE reservation set r_status ='cancel' where rid = '$rid' ");
    echo '<script>location="?rid='.$rid.'"</script>';
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

          <?php  
            if (isset($_GET['rid'])) { 
          ?>
          <div class="w3-padding" style="text-align:right">
            <button class="w3-btn w3-light-grey w3-border w3-round-small print_btn w3-ripple"><i class="fas fa-print"></i> Print</button>            
          </div>

          <div id="printArea">
          <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Booking Details</a></li>
            <li><a href="#tabs-2">Client Details</a></li>
          </ul>
          <div id="tabs-1">
            <div class="row">

              <?php  
              $rid = $_GET['rid'];
              $q = mysqli_query($conn,"SELECT * FROM reservation where rid = '".$_GET['rid']."' ");
              $qq = mysqli_fetch_array($q);

              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              $cater_id = $qq['cater_id'];

              $e = mysqli_query($conn,"SELECT * FROM custom_r where r_id = '".$qq['rid']."' ");

              $d = mysqli_query($conn,"SELECT add_ons.food_qty, add_ons.food_id, food_menu.food_name, food_menu.price from add_ons inner join food_menu where add_ons.r_id='$rid' and add_ons.food_id=food_menu.food_id ");
              $o=0;
                while ($dd = mysqli_fetch_array($d)) {
                  $o += $dd['food_qty'] * $dd['price'];
                }

              ?>
              <div class="col-md-6">
                <div class="table-responsive">
                  <table>
                      
                    <tr>
                      <td class="w3-padding-small">Date reserved</td>
                      <td class="w3-padding-small">
                        <div class="w3-input w3-border w3-light-grey w3-center"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?>
                        </div>
                      </td>
                    </tr>
                    
                     <tr>
                      <td class="w3-padding-small">Catering Services</td>
                      <td class="w3-padding-small">
                        <div class="w3-input w3-border w3-light-grey w3-center" style="resize: none;height:auto;"><b><?php echo $ww['event_name'] ?></b> <br>
                        Good for <?php echo $ww['PMin'] ?> - <?php echo $ww['PMax'] ?> persons</div>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Price per head</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" style="text-align:right" disabled value="P <?php echo number_format($ww['price'],2) ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Menus</td>
                      <td class="w3-padding-small">
                        <?php  
                        if (mysqli_num_rows($e) > 0) { ?>
                        
                          <label class="w3-text-black">Customized</label>
                    
                         <?php
                        } else { ?>
                          
                            <label class="w3-text-black">Not Customize</label>
                          
                        <?php
                        }
                        ?>
                        
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Booking Date</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo date("m-d-Y", strtotime($qq['r_date_from'])) ?> - <?php echo date("m-d-Y", strtotime($qq['r_date_to'])) ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Status</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['r_status'] ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Payment Date</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo date("m-d-Y", strtotime($qq['r_date_from'].'- 4 days')) ?>">
                      </td>
                    </tr>
                    <?php  
                    if ($qq['r_status'] == 'approve' || $qq['r_status'] == 'pending') { ?>
                      <tr>
                      <td class="w3-padding-small w3-center" colspan="2">
                        <a href="?q=<?php echo $rid ?>">
                          <button class="w3-btn w3-green w3-round-small w3-margin-top w3-ripple">Add Payment</button>
                        </a>
                        <a href="?p=<?php echo $rid ?>">
                          <button class="w3-btn w3-light-grey w3-round-small w3-margin-top w3-ripple" onclick="return confirm('Are you sure?')">Cancel Reservation</button>
                        </a>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>

                  </table>
                </div>
              </div>

              <div class="col-md-6">
                <div class="table-responsive">
                  <table>

                     <tr>
                      <td class="w3-padding-small">Total Visitor</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['total_visitor'] ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small"><a href="#m">Add-ons Total</a></td>
                      <td class="w3-padding-small">
                        <?php  
                        if (mysqli_num_rows($d) > 0) { ?>
                          <div class="w3-input w3-border w3-light-grey" style="text-align:right">
                              <?php 
                              if(($qq['adOn_mis'] == "unpaid" && ($qq['r_status'] == "pending" || $qq['r_status'] == "approve")) || ($qq['adOn_mis'] == "paid" && ($qq['r_status'] == "pending"))) { ?>
                          <a href="payment_add_ons.php?pay=<?php echo $_GET['rid'] ?>"><button>add payment</button></a>
                          <?php
                          } ?> P <?php echo number_format($o,2).' - '. $qq['adOn_mis']?> </div>
                        <?php 
                        } else { ?>
                          <input type="text" class="w3-input w3-border" disabled value="No add-ons">
                        <?php
                        }
                        ?>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Payable</td>
                      <td class="w3-padding-small">
                        <div  class="w3-input w3-border w3-border w3-light-grey" style="text-align:right">
                        <?php  
                          if ($qq['balance'] == '0') { ?>    
                            <?php echo $qq['total_visitor'].' &times; '.$ww['price'].' = P '. number_format($qq['payable'],2) ?> Fully Paid
                          <?php
                          } else {
                            echo $qq['total_visitor'].' &times; '.$ww['price'].' = P '. number_format($qq['payable'],2);
                          }
                        ?>
                      </div>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Balance</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" style="text-align:right" disabled value="P <?php echo number_format($qq['balance'],2) ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Paid</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" style="text-align:right" disabled value="P <?php echo number_format($qq['downpayment'],2) ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Mode of payment</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['mode_of_payment'] ?>">
                      </td>
                    </tr>

                  </table>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-md-12">
                <div class="w3-margin-top w3-center w3-border-top">
                  <h2>Menus</h2>

                  <div class="w3-border" id="m">
                    
                    <div class="row">
                      <div class="col-md-6 w3-border-right">
                        <div>
                          <h3>Catering menu</h3>
                           <?php
                          $q = mysqli_query($conn,"SELECT * FROM category ");
                          while ($qq = mysqli_fetch_array($q)) {
                            echo "<h4 class='w3-text-green'>".$qq['cat_name']."</h4>";

                            $w = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$qq['cat_id']."' ");
                            while ($ww = mysqli_fetch_array($w)) {
                              echo "<h5 class='w3-text-blue'>".$ww['type_name']."</h5>";

                              $t = mysqli_query($conn,"SELECT food_menu.food_name FROM food_menu inner join custom_r where food_menu.food_id=custom_r.food_id and type_id = '".$ww['type_id']."' and r_id = '$rid'") or die(mysqli_error($conn));
                              if (mysqli_num_rows($t) > 0) {
                                while ($tt = mysqli_fetch_array($t)) { ?>
                                  
                                    <label class="w3-margin-left">
                                      <?php echo $tt['food_name'] ?>
                                    </label> <br>
                                  <?php
                                }
                              } else {
                                $e = mysqli_query($conn,"SELECT food_menu.food_name FROM food_menu inner join catering_details WHERE catering_details.cater_id='$cater_id' and catering_details.food_id=food_menu.food_id and type_id = '".$ww['type_id']."' and catid = '".$qq['cat_id']."' ") or die(mysqli_error($conn));
                                if (mysqli_num_rows($e) > 0) {
                                  while ($ee = mysqli_fetch_array($e)) { ?>
                                  
                                    <label class="w3-margin-left">
                                      <?php echo $ee['food_name'] ?>
                                    </label> <br>
                                  <?php
                                  }
                                }
                              } 
                            }
                          }
                        ?>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="w3-padding-small">
                          <h3>Add-ons Menu</h3>
                          <table class="w3-striped">
                            <tr class="w3-text-grey">
                               <td>Food Name</td>
                               <td>Price</td>
                               <td>Qty</td>
                               <td></td>
                             </tr>
                          <?php  
                          $d = mysqli_query($conn,"SELECT add_ons.food_qty, add_ons.food_id, food_menu.food_name, food_menu.price from add_ons inner join food_menu where add_ons.r_id='$rid' and add_ons.food_id=food_menu.food_id ");

                          $o=0;
                          if (mysqli_num_rows($d) > 0) {
                            while ($dd = mysqli_fetch_array($d)) {
                              $o += $dd['food_qty'] * $dd['price'];
                             ?>
                             <tr>
                               <td><?php echo $dd['food_name'] ?></td>
                               <td>P <?php echo number_format($dd['price'],2) ?></td>
                               <td><?php echo $dd['food_qty'] ?></td>
                               <td>P <?php echo number_format($dd['price'] * $dd['food_qty'],2 ) ?></td>
                             </tr>
                          <?php   
                            }
                            ?>
                            <tr>
                              <td class="w3-padding-small" colspan="4" align="right">Total : P <?php echo number_format($o,2) ?></td>
                            </tr>
                            <?php
                          } else {
                            echo "<tr><td colspan='4' align='center'>No add-ons menu added.</td></tr>";
                          }
                          ?>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>

            
          </div>
          <div id="tabs-2">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table>
                    <?php  
                    $q = mysqli_query($conn,"SELECT * FROM reservation where rid = '".$_GET['rid']."' ");
                    $qq = mysqli_fetch_array($q);
                    ?>
                     <tr>
                      <td class="w3-padding-small">Name</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['cu_first'].' '.$qq['cu_last'] ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Contact Number</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['cu_phone'] ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Email Address</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['cu_mail'] ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Address</td>
                      <td class="w3-padding-small">
                        <textarea class="w3-input w3-border" disabled><?php echo $qq['cu_add'] ?></textarea>
                      </td>
                    </tr>

                  </table>
                </div>
              </div>
            </div>
            
          </div>

          

          <?php /*<div class="alert alert-danger" style="margin:10px auto;text-align:left; width:100%">
            <b>PLEASE READ</b><br><br>

            Note: If you choose pera padala as your mode of payment use this NAME - <span style="text-decoration:underline;"><?php echo $kk['Name'] ?></span> and CONTACT NUMBER - <span style="text-decoration:underline;"><?php echo $kk['contact'] ?></span>. <br><br> You must pay <?php echo $pp['d_price'] * 100 ?>% of the actual price as an advance payment 4 days before the booking date, if you failed to pay the said advance payment, reservation will be CANCEL.
          </div>*/ ?>

      </div>
      </div>
      <?php 
    } else {
      if (isset($_GET['q'])) {  
        $rid = $_GET['q'];
        $q = mysqli_query($conn,"SELECT * FROM reservation where rid = '$rid' ");
        $qq = mysqli_fetch_array($q);

        $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
        $ww = mysqli_fetch_array($w);
        $cater_id = $qq['cater_id'];

        $e = mysqli_query($conn,"SELECT * FROM custom_r where r_id = '".$qq['rid']."' ");

        $d = mysqli_query($conn,"SELECT add_ons.food_qty, add_ons.food_id, food_menu.food_name, food_menu.price from add_ons inner join food_menu where add_ons.r_id='$rid' and add_ons.food_id=food_menu.food_id ");
        $o=0;
          while ($dd = mysqli_fetch_array($d)) {
            $o += $dd['food_qty'] * $dd['price'];
          }

          if (isset($_POST['submit_payment'])) {
            $downpayment = $_POST['downpayment'];

              if ($downpayment == $qq['payable']) {
                  
                  $gg = mysqli_query($conn,"SELECT * FROM reservation where rid = '$rid' and adOn_mis = 'unpaid' ");
                  if (mysqli_num_rows($gg) > 0) {
                     mysqli_query($conn,"UPDATE reservation set downpayment = '$downpayment', balance = '0', r_status='approve' where rid = '$rid' ");
                     echo '<script>location="?rid='.$rid.'";alert("Reservation is fully paid!")</script>'; 
                  } else {
                      mysqli_query($conn,"UPDATE reservation set downpayment = '$downpayment', balance = '0', r_status='finish' where rid = '$rid' ");
                      echo '<script>location="?rid='.$rid.'";alert("Reservation is fully paid!")</script>';
                  }
                
              } elseif ($downpayment > ($qq['payable'] * $pp['d_price']) && $downpayment <= $qq['payable']) {
                $balance = $qq['payable'] - $downpayment;
                mysqli_query($conn,"UPDATE reservation set downpayment = '$downpayment', balance = '$balance', r_status='approve' where rid = '$rid' ");
                echo '<script>location="?rid='.$rid.'";alert("Reservation approve!")</script>';
              } elseif ($downpayment < ($qq['payable'] * $pp['d_price'])) {
                echo '<script>location="?q='.$rid.'&d=d"</script>';
              } elseif ($downpayment == ($qq['payable'] * $pp['d_price'])) {
                $bal = $qq['payable'] - $downpayment;
                mysqli_query($conn,"UPDATE reservation set downpayment = '$downpayment', balance = '$bal', r_status='approve' where rid = '$rid' ");
                echo '<script>location="?rid='.$rid.'";alert("Reservation approve!")</script>';
              } elseif ($downpayment > $qq['payable']) {
                  echo '<script>alert("Downpayment is not valid!");history.back()</script>';
              }
            
          }

          if (isset($_POST['submit_payment_full'])) {
            $downpayment_full = $_POST['downpayment_full'];
              if ($downpayment_full > $qq['balance']) {
                  echo '<script>alert("Payment is not valid!");history.back()</script>';
              } elseif ($downpayment_full < $qq['balance']) {
                echo '<script>location="?q='.$rid.'&b=b";</script>';
              } elseif ($downpayment_full == $qq['balance']) {
                  $gg = mysqli_query($conn,"SELECT * FROM reservation where rid = '$rid' and adOn_mis = 'unpaid' ");
                  if (mysqli_num_rows($gg) > 0) {
                     mysqli_query($conn,"UPDATE reservation set downpayment = '".$qq['payable']."', balance = '0', r_status='approve' where rid = '$rid' ");
                     echo '<script>location="?rid='.$rid.'";alert("Reservation is fully paid!")</script>';   
                  } else {
                     mysqli_query($conn,"UPDATE reservation set downpayment = '".$qq['payable']."', balance = '0', r_status='finish' where rid = '$rid' ");
                     echo '<script>location="?rid='.$rid.'";alert("Reservation is fully paid!")</script>'; 
                  }
              }
            
          }

        ?>
        <div class="">
            <div class="col-md-8" style="float: none;margin:0 auto">
              
                <fieldset class="w3-margin-top" style="margin:0 auto;width:400px">
                  <legend class="w3-center w3-green">Payment Form</legend>
                  <table>
                <?php  
                  if ($qq['r_status'] == 'pending') { ?>
                    <form action="" method="POST">
                 <tr>
                  <td class="w3-padding-small">
                    <label>Total Payment</label>
                    <input type="number" step="any" disabled style="text-align:right" class="w3-input w3-border" value="<?php echo $qq['payable'] ?>"> <br>
                  </td>
                </tr>

                <tr>
                  <td class="w3-padding-small">
                    <label>Balance</label>
                    <input type="number" step="any" disabled style="text-align:right" class="w3-input w3-border" value="<?php echo $qq['balance'] ?>"> <br>
                  </td>
                </tr>
                <tr>
                  <td class="w3-padding-small">
                    <label>Downpayment = Total Payment &times; <?php echo $pp['d_price'] * 100 ?>% = <?php echo $qq['payable'] * $pp['d_price'] ?></label>
                    <input type="number" step="any" name="downpayment" style="text-align:right" required class="w3-input w3-border w3-border-pink payment" value="<?php echo $qq['payable'] * $pp['d_price'] ?>"> <br>
                  </td>
                </tr>

                <?php if (isset($_GET['d'])): ?>
                  <tr>
                  <td class="w3-padding-small">
                    <div class="w3-input w3-border-0 w3-red w3-center">
                      Downpayment is required!
                    </div>
                  </td>
                </tr>
                <?php endif ?>

                <tr>
                  <td class="w3-padding-small">
                    <button name="submit_payment" type="submit" class="w3-btn w3-light-grey w3-border">Add Payment</button>
                  </td>
                </tr>
                </form>
              
                  <?php
                  } elseif ($qq['r_status'] == 'approve') { ?>
                   <form action="" method="POST"> 
                 <tr>
                  <td class="w3-padding-small">
                    <label>Total Payment</label>
                    <input type="number" step="any" disabled style="text-align:right" class="w3-input w3-border" value="<?php echo $qq['payable'] ?>"> <br>
                  </td>
                </tr>

                <tr>
                  <td class="w3-padding-small">
                    <label>Balance</label>
                    <input type="number" step="any" disabled style="text-align:right" class="w3-input w3-border" value="<?php echo $qq['balance'] ?>"> <br>
                  </td>
                </tr>
                <tr>
                  <td class="w3-padding-small">
                    <label>Full payment is required</label>
                    <input type="number" step="any" name="downpayment_full" style="text-align:right" required class="w3-input w3-border w3-border-pink payment" value="<?php echo $qq['balance'] ?>"> <br>
                    <p class="w3-text-pink total_with_add_on"></p>
                  </td>
                </tr>

                <?php if (isset($_GET['b'])): ?>
                  <tr>
                  <td class="w3-padding-small">
                    <div class="w3-input w3-border-0 w3-red w3-center">
                      Full payment is required!
                    </div>
                  </td>
                </tr>
                <?php endif ?>

                <tr>
                  <td class="w3-padding-small">
                    <button name="submit_payment_full" type="submit" class="w3-btn w3-light-grey w3-border">Add Payment</button>
                  </td>
                </tr>

                  <?php
                  }
                ?>
              </form>
                </table>
              </fieldset>
              
            </div>
        </div>
    <?php
      }
    }

      ?>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="../print/jQuery.print.min.js"></script>
    <script>
      $( "#tabs" ).tabs();
      $(document).ready(function(){
        
        $('.print_btn').click(function(){
          $("#printArea").print();
        });

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
