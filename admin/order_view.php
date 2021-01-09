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
      
  .button-group select, 
  .button-group input, 
  .button-group button{
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

    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <?php 
    if (isset($_GET['cancel'])) {
      $orderId = $_GET['cancel'];

      mysqli_query($conn,"UPDATE food_order set status = 'cancel' where order_id = '$orderId'");
      echo '<script>window.history.back()</script>';
    }
    $seniorDiscount = mysqli_query($conn,"SELECT * FROM dis_senior");
    $seniordiscount = mysqli_fetch_array($seniorDiscount);
     ?>

    <div class="right-fixed w3-white">
      <div class="order_page">
        <button class="w3-btn w3-padding-small w3-grey w3-round" onclick="window.history.back()">back</button>
        <div class="tabs" style="margin-top:-10px;">
          <h3 class="w3-padding w3-text-grey">
            <?php 
                if (isset($_GET['typeo']) && $_GET['typeo'] == "dinein") {
                  echo "Dine-in";
                } elseif (isset($_GET['typeo']) && $_GET['typeo'] == "delivery") {
                  echo "Delivery";
                } elseif (isset($_GET['typeo']) && $_GET['typeo'] == "pickup") {
                  echo "Pick up";
                } elseif(isset($_GET['typeo']) && $_GET['typeo'] == "takeout") {
                  echo "Take out";
                }
            ?>
          Order</h3>
          <p class="w3-center w3-light-grey" style="padding:5px">
            <?php 
            if (isset($_GET['id'])) {
              $order_id = $_GET['id'];

              $_SESSION['order_id'] = $order_id;
              
              $sql = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id'");
              while ($row = mysqli_fetch_array($sql)) {
                
                $sql1 = mysqli_query($conn,"SELECT * FROM users where id = '".$row['user_id']."'");
                if (mysqli_num_rows($sql1) > 0) {
                  $rows = mysqli_fetch_array($sql1);
                  echo '<span style="font-weight:bold">'.$rows['firstname'].' '.$rows['lastname'].'</span>';
                } else {
                  echo "Walk in";
                }
              }
            }
            ?>
           Orders</p>

          <div class="w3-margin-top">
            <div class="row" style="margin:10px;">
              <div class=" col-md-12 w3-padding">
      <div class=" w3-white" style="padding: 10px">
  
          <table class="w3-border w3-border-blue w3-text-black">
            <tr>
              <td colspan="2" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER DETAILS</h4></td>
            </tr>
            <?php  

            if (isset($_GET['id'])) {
              $order_id = $_GET['id'];

              $sql = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id'");
              if (mysqli_num_rows($sql) > 0) {

                $cu = mysqli_query($conn,"SELECT * FROM pick_up_details where order_id = '$order_id' ");
                $cucu = mysqli_fetch_array($cu);

                while ($row = mysqli_fetch_array($sql)) { 
                  if ($row['user_id'] == '0') { ?>
                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Customer's name: </td>
                      <td  align="left"><?php echo $cucu['p_to_pick'] ?></td>
                    </tr>

                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Contact number: </td>
                      <td  align="left"><?php echo $cucu['contact'] ?></td>
                    </tr>
                  <?php
                  } else {
                    $u = mysqli_query($conn,"SELECT * FROM users where id = '".$row['user_id']."' ");
                    $uu = mysqli_fetch_array($u); ?>

                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Customer's name: </td>
                      <td  align="left"><?php echo $uu['firstname'].' '.$uu['lastname'] ?></td>
                    </tr>

                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Contact number: </td>
                      <td  align="left"><?php echo $uu['contact'] ?></td>
                    </tr>

                  <?php
                  }
                  ?>

                <tr class="w3-border w3-border-blue">
                  <td class="w3-padding w3-text-blue" align="left">Date ordered: </td>
                  <td  align="left"><?php echo date("M d, Y", strtotime($row['curr_order_date'])) ?></td>
                </tr>
                 <tr class="w3-border w3-border-blue">
                  <td class="w3-padding w3-text-blue" align="left">Order Type: </td>
                  <td  align="left">

                    <?php 
                    if ($row['order_type'] == "delivery") {
                      echo "Delivery";
                    } elseif ($row['order_type'] == "dinein") {
                      echo "Dine-in";
                    } elseif ($row['order_type'] == "pickup") {
                      echo "Pick up";
                    } elseif ($row['order_type'] == "takeout") {
                      echo "Take out";
                    } 
                    ?>
                      
                    </td>
                </tr>
                <tr class="w3-border w3-border-blue">
                  <td class="w3-padding w3-text-blue" align="left">Mode of Payment</td>
                  <td align="left"><?php echo $row['payment_mode'] ?></td>
                </tr>
                <tr class="w3-border w3-border-blue">
                  <td class="w3-padding w3-text-blue" align="left">
                  <?php 
                  if ($row['order_type'] == "delivery") {
                      echo "Delivery";
                    } elseif ($row['order_type'] == "dinein") {
                      echo "Dine-in";
                    } elseif ($row['order_type'] == "pickup") {
                      echo "Pick up";
                    } elseif ($row['order_type'] == "takeout") {
                      echo "Take out";
                    }  
                  ?> date:</td>
                  <td align="left">
                  <?php echo date("M d, Y", strtotime($row['order_date'])) ?>
                  </td>
                </tr>
                <tr class="w3-border w3-border-blue">
                  <td class="w3-padding w3-text-blue" align="left">
                  <?php 
                  if ($row['order_type'] == "delivery") {
                      echo "Delivery";
                    } elseif ($row['order_type'] == "dinein") {
                      echo "Dine-in";
                    } elseif ($row['order_type'] == "pickup") {
                      echo "Pick up";
                    } elseif ($row['order_type'] == "takeout") {
                      echo "Take out";
                    }  
                  ?> time:</td>
                  <td align="left"><?php echo date("h:i A", strtotime($row['order_time'])) ?></td>
                </tr>
                <?php 
                  if ($row['order_type'] == "delivery") {
                    $bd_id = mysqli_fetch_array($sql);

                    $sql1 = mysqli_query($conn,"SELECT * FROM delivery_detail where order_id = '$order_id'");
                    while ($sql11 = mysqli_fetch_array($sql1)) {
                      $sql = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '".$sql11['bd_id']."'");
                      while ($sql_ = mysqli_fetch_array($sql)) { ?>

                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Delivery address:</td>
                      <td align="left"><?php echo $sql11['house_street'].', '.$sql_['barangay'] ?> , Aurora, Zamboanga del sur</td>
                    </tr>
                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Delivery Charge</td>
                      <td align="left">P <?php echo number_format($sql_['deliv_charge'],2) ?></td>
                    </tr>

                    <?php    
                      }
                    }
                  } else if ($row['order_type'] == "pickup") {
                    $q = mysqli_query($conn, "SELECT * FROM pick_up_details WHERE order_id = '$order_id'");
                    if (mysqli_num_rows($q) > 0) {
                      $qq = mysqli_fetch_array($q);
                      ?>

                      <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Person to pick up :</td>
                      <td align="left"><?php echo $qq['p_to_pick'] ?></td>
                    </tr>
                    <tr class="w3-border w3-border-blue">
                      <td class="w3-padding w3-text-blue" align="left">Contact number : </td>
                      <td align="left"><?php echo $qq['contact'] ?></td>
                    </tr>
                    <?php
                    }    
                  }
                  ?>
                  <tr class="w3-border w3-border-blue">
                    <td class="w3-padding w3-text-blue">Order Amount:</td>
                    <td>
                      <?php  
                      $sql = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '$order_id'");
                      $total = 0;
                      while ($qqqqqqq = mysqli_fetch_array($sql)) {
                        $sql1 = mysqli_query($conn,"SELECT * FROM food_menu where food_id = '".$qqqqqqq['food_id']."'");
                        while ($rows = mysqli_fetch_array($sql1)) { 
                          $total = $total + ($qqqqqqq['food_qty'] * $rows['price']);
                        }
                      }
                       echo number_format($total,2);
                      ?>
                    </td>
                  </tr>
                  <tr class="w3-border w3-border-blue">
                    <?php  
                    if ($row['customer_type'] == "senior") { ?>
                      <td class="w3-padding w3-text-blue">Discount:</td>
                      <td><?php echo $seniordiscount['discount'] * 100 ?>%</td>
                    <?php
                    } elseif ($row['customer_type'] == "junior"){ ?>
                    <td class="w3-padding w3-text-blue">VAT:</td>
                    <td>12%</td>
                    <?php
                    }
                    ?>
                  </tr>
                  <tr class="w3-border w3-border-blue">
                    <td class="w3-padding w3-text-blue" align="left">Total Payment:</td>
                    <td align="left">P  <?php echo number_format($row['order_amount'],2); ?></td>
                  </tr>
                   <tr class="w3-border w3-border-blue">
                    <td class="w3-padding w3-text-blue" align="left">Status:</td>
                    <td align="left"><?php echo $row['status'] ?></td>
                  </tr>

            <?php
                $now = date("Y-m-d");
                  if ( $row['status'] == "pending") { ?>
                      <tr class="w3-border w3-border-blue">
                        <td class="w3-padding w3-center w3-text-blue" colspan="2">
                          <a href="order_view.php?cancel=<?php echo $row['order_id'] ?>" onclick="return confirm('Are you sure you want to cancel the order?')">
                            <button class="w3-btn w3-round w3-border w3-border-red w3-text-red w3-transparent">Cancel order</button>
                          </a>
                            <button class="w3-btn w3-round w3-border w3-border-blue w3-text-blue w3-transparent addPaymentBtn">Add payment</button>
                          
                        </td>
                      </tr>
                <?php
                  }

                  ?>
                    <div id="dialog" title="Payment" class="w3-center">

                      <form id="addPaymentForm">
                        <label style="font-weight:normal;" class="w3-text-green">Add payment</label>
                        <input type="hidden" id="order_id<?php echo $row['order_id'] ?>" value="<?php echo $row['order_id'] ?>">
                        <input type="number" value="<?php echo $row['order_amount'] ?>" class="w3-center inputPayment w3-input w3-border w3-border-blue w3-round w3-margin-bottom">
                        <button id="<?php echo $row['order_id'] ?>" class="w3-btn w3-blue w3-round paymentBtnSubmit">Add Payment</button>
                      </form>

                    </div>
                  <?php
                }
              }
            }

            ?>
             
      </table>
     
      </div>
    </div>

    <div class="col-md-12 w3-padding">
    
      <div class="table-responsive w3-white" style="padding: 10px">
      
        <table class="w3-border w3-border-blue w3-text-black">
          <tr>
            <td colspan="5" class="w3-padding" align="center"><h4 class="w3-text-blue">ORDER ITEMS</h4>
              <?php  
              $sql = mysqli_query($conn,"SELECT * FROM food_order where order_id = '".$_SESSION['order_id']."' ");
              $qq = mysqli_fetch_array($sql);
              $t = false;

              if ($qq['status'] == 'approve' || $qq['status'] == 'cancel') {
                $t = true;
              } else { ?>
              <input type="hidden" id="order_id<?php echo $_SESSION['order_id'] ?>" value="<?php echo $_SESSION['order_id'] ?>" >
                <button class="btn btn-default w3-border-black w3-text-black w3-hover-black save_first_order" id="<?php echo $_SESSION['order_id'] ?>">Edit order
                <i class="fas fa-pencil-alt"></i> </button>
              <?php
              }
              ?>
                   
            </td>
          </tr>
          <tr class="w3-border w3-border-blue w3-text-blue">
            <td class="w3-padding">IMAGE</td>
            <td>FOOD NAME </td>
            <td>PRICE</td>
            <td>QTY</td>
            <td>COST</td>
          </tr>
         
         <?php  
         if (isset($_GET['id'])) {
              $order_id = $_GET['id'];

          $sql = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '$order_id'");
          $total = 0;
          while ($row = mysqli_fetch_array($sql)) {
            $sql1 = mysqli_query($conn,"SELECT * FROM food_menu where food_id = '".$row['food_id']."'");
            while ($rows = mysqli_fetch_array($sql1)) { 
              $total = $total + ($row['food_qty'] * $rows['price']);
              ?>
        
          <tr class="w3-border w3-border-blue">
            <td class="w3-padding"><img src="../food_images/<?php echo $rows['photo'] ?>" style="margin:10px;height: 60px;width:60px"></td>
            <td><?php echo $rows['food_name'] ?></td>
            <td>P <?php echo number_format($rows['price'],2) ?></td>
            <td><?php echo $row['food_qty'] ?></td>
            <td>P <?php echo number_format($row['food_qty'] * $rows['price'],2) ?></td>
          </tr>

        <?php 
            }
          }
          ?>
          <tr>
            <td class="w3-padding" colspan="4" align="right">Total : </td>
            <td>P <?php echo number_format($total,2) ?></td>
        </tr>
        <?php
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
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>

      $(document).ready(function(){

        $( "#dialog" ).dialog({
          autoOpen: false,
          width: 400,
        });

      $( ".addPaymentBtn" ).click(function( event ) {
        $( "#dialog" ).dialog( "open" );
        event.preventDefault();
      });

      $("#addPaymentForm").submit(function(e){
        e.preventDefault();

        var idk = "<?php echo $_GET['id'] ?>";
        var inputPayment = $(".inputPayment").val();
        var paymentBtnSubmit = $(".paymentBtnSubmit").val();
        var order_id = $(".paymentBtnSubmit").attr("id");
        var id = $("#order_id"+order_id).val();

        if (inputPayment == "") {
          alert("Input payment please.");
        } else {
          $.ajax({
            url: "include/order_payment.inc.php",
            method: "POST",
            data: {
              inputPayment: inputPayment,
              paymentBtnSubmit: paymentBtnSubmit,
              id: id
            },
            success: function(q) {
              alert(q);
              if (q == "Added payment successfully!") {
                window.location="payment.php?id="+idk;
              }
            }
          });
        }
      });


      $(".save_first_order").click(function(){
          var save_first_order = $(this).attr("id");
          var order_id = $("#order_id"+save_first_order).val();
          
          $.ajax({
            url: "include/old_order_save.php",
            method: "POST",
            data: {
              save_first_order: save_first_order,
              order_id: order_id
            },
            success: function(data){
              if (data == "InsertedWithSelect") {
                window.location="new_order.php?i="+order_id;
              }
            }
          });
        });


      });

    </script>
  </body>
</html>
