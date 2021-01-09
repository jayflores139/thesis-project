<?php
session_start();
include "includes/connect.php";

if (!isset($_SESSION['id_user'])) {
  header("location:login.php");
} else {
  $id_user = $_SESSION['id_user'];
}
$k = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
$kk = mysqli_fetch_array($k);

$p = mysqli_query($conn,"SELECT * FROM downpayment");
$pp = mysqli_fetch_array($p);
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
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
    $height = false;
?>

<div class="container w3-light-grey w3-center containersssss">
  
  <div class="row" style="margin:10px;margin-top:50px">
    <button class="w3-btn w3-padding-small w3-grey w3-left" onclick="window.history.back()">Back</button>

    <?php  
            if (isset($_GET['id'])) { 
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
              $rid = $_GET['id'];
              $q = mysqli_query($conn,"SELECT * FROM reservation where rid = '".$_GET['id']."' ");
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
                      <td class="w3-padding-small">Catering Services</td>
                      <td class="w3-padding-small">
                        <div class="w3-input w3-border w3-light-grey w3-center" style="resize: none;height:auto;"><b><?php echo $ww['event_name'] ?></b> <br>
                        Good for <?php echo $ww['PMin'] ?> - <?php echo $ww['PMax'] ?> persons</div>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Price per head</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="P <?php echo number_format($ww['price'],2) ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Menus</td>
                      <td class="w3-padding-small">
                        <?php  
                        if (mysqli_num_rows($e) > 0) { ?>
                        <a href="#m">
                          <button class="btn btn-default">Customized</button>
                        </a>
                         <?php
                        } else { ?>
                          <a href="#m">
                            <button class="btn btn-default">Not Customize</button>
                          </a>
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
                          <input type="text" class="w3-input w3-border" disabled value="P <?php echo number_format($o,2).' - '. $qq['adOn_mis']?>">
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
                        <div  class="w3-input w3-border w3-border w3-light-grey">
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
                        <input type="text" class="w3-input w3-border" disabled value="P <?php echo number_format($qq['balance'],2) ?>">
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">Paid</td>
                      <td class="w3-padding-small">
                        <input type="text" class="w3-input w3-border" disabled value="P <?php echo number_format($qq['downpayment'],2) ?>">
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
                    $q = mysqli_query($conn,"SELECT * FROM reservation where rid = '".$_GET['id']."' ");
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
    }
      ?>
        
  </div>

</div>

</body>
</html>
<script>
  $("#tabs").tabs();
  $(document).ready(function(){

    $(".cancel_r").click(function(){
      var rid = $(this).attr("id");
      var rid_in = $("#cancel_id_r"+rid).val();
        
      if (confirm("Are you sure you want to cancel your reservation?") == true) {
         $.ajax({
          url: "includes/cancel_reservation.php",
          method: "POST",
          data:{
            rid: rid,
            rid_in: rid_in
          },
          success:function(data){
            if (data == "Cancelled!") {
              window.location="";
            }
          }
        });
      }

    });
      $('.print_btn').click(function(){
          $("#printArea").print();
      });


  });

/*
  $( "#dialog" ).dialog({
  autoOpen: false,
  width: 500,
  buttons: [
    {
      text: "Ok",
      click: function() {
        $( this ).dialog( "close" );
      }
    }
  ]
});

// Link to open the dialog
$( "#dialog-link" ).click(function( event ) {
  $( "#dialog" ).dialog( "open" );
  event.preventDefault();
});

*/
</script>





































