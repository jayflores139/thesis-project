<?php
$total = 0;
  include '../includes/connect.php';
  session_start();

  if (!isset($_SESSION['user_id'])) {
    header("Location:index.php");
  }

$b = mysqli_query($conn,"SELECT * FROM dis_senior ");
$bb = mysqli_fetch_array($b);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
  </head>
  <body>

      <fieldset class="order_page w3-center w3-border w3-border-grey printable" style="margin-top:5px;margin-bottom:15px; height:auto;width:500px;position:absolute;top:30%;left:50%;transform:translate(-50%, -50%);">
        <legend class="w3-text-blue" style="margin:0;padding:0 5px;width:auto;font-size:14px">Payment</legend>

        <h3 class="w3-text-blue">Tugkaran Restaurant</h3>
        <p class="w3-text-grey">Online Food Ordering and Reservation System</p>

        <?php

        if (isset($_GET['id'])) {
          $order_id = $_GET['id'];
          $q = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id'");
          $qq = mysqli_fetch_array($q);
          ?>

          <table class="w3-border w3-border-grey centered">
              <tr class="w3-border">
                  <td colspan="3" align="left">Invoice number: <?php echo $qq['order_id'] ?></td>
              </tr>

              <tr>
                <th class="w3-padding-tiny w3-center">Food Name</th>
                <th class="w3-padding-tiny w3-center">Qty</th>
                <th class="w3-padding-tiny w3-center">Price</th>
              </tr>
              <?php

              $sql = mysqli_query($conn,"SELECT * FROM food_order_details natural join food_menu where order_id = '$order_id'");
              $total = 0;
              $vat = .12;
              if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql)) {
                  $total = $total + ($row['price'] * $row['food_qty']);
                  ?>

                <tr>
                  <td class="w3-padding-tiny"><?php echo $row['food_name'] ?></td>
                  <td><?php echo $row['food_qty'] ?></td>
                  <td>P <?php echo number_format($row['price'],2); ?></td>
                </tr>

              <?php
                }
                 ?>
                <tr class="w3-border-bottom">
                  <td class="w3-padding-right w3-border-top" colspan="3" align="right">
                    Sub-total: P <?php echo number_format($total,2) ?>
                  </td>
                </tr>
                <tr>
                  <td class="w3-padding-top w3-padding-right" colspan="3" align="right"> 
                   <b>Grand total:  P <?php echo number_format($qq['order_amount'], 2) ?> </b>
                  </td>
                <tr>
                <tr>
                  <td class="w3-padding-right" colspan="3" align="right"> 
                   Cash:  P <?php echo number_format($_GET['ca'], 2) ?>
                  </td>
                <tr>
                  <tr>
                    <td class="w3-padding-right" colspan="3" align="right"> 
                     Change:  P <?php echo $_GET['ch'] ?> 
                    </td>
                  <tr>
                  <td colspan="3" align="right" class="w3-padding-right"> 
                    <?php 
                    if ($qq['customer_type'] == 'junior') {
                      echo "Discount: 0%";
                    }
                    if ($qq['customer_type'] == 'senior') {
                      echo "Discount: ".$bb['discount'] * 100;
                    }
                  ?>
                  %
                  </td>
                </tr>

               <?php 
              }
              ?>

              <tr class="w3-border">
                <td class="w3-padding" colspan="3">
                    <a href="d.php?i=<?php echo $order_id ?>"><button>Back</button></a>
                  <button id="print">Print</button>
                </td>
              </tr>

          </table>

        <?php
        } else {
          header("Location:index.php");
        }
        ?>
      </fieldset>

      <?php  
        /*while ($qq = mysqli_fetch_array($q)) {
                  if ($qq['user_id'] == "0") {

                  if ($qq['customer_type'] == "senior") { ?>
                  <tr>
                    <td align="right" style="padding:0 20px" colspan="3">Discount: 20%</td>
                  </tr>
                  <tr>
                    <td align="right" style="padding:0 20px;font-weight: bold;" colspan="3">Grand Total: P
                      <?php echo number_format($qq['order_amount'], 2) ?></td>
                  </tr>
                <?php
                  } elseif ($qq['customer_type'] == "junior") {
                     ?>
                  <tr>
                    <td align="right" style="padding:0 20px;font-weight: bold;" colspan="3">Grand Total: P
                      <?php echo number_format($qq['order_amount'], 2) ?></td>
                  </tr>
                <?php
                    }
                  } else {
                      if ($qq['customer_type'] == "junior") { 
                        $c = mysqli_query($conn,"SELECT * FROM delivery_detail where order_id = '$order_id' ");
                        $cc = mysqli_fetch_array($c);
                        $v = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '".$cc['bd_id']."' ");
                        $vv = mysqli_fetch_array($v);

                        if ($qq['order_type'] == 'delivery') { ?>
                          <tr>
                            <td align="right" style="padding:0 20px" colspan="3">Delivery Charge: P <?php echo number_format($vv['deliv_charge'], 2) ?></td>
                          </tr>
                        <?php
                        }
                  }
                    if ($qq['customer_type'] == "senior") { 
                      $se = mysqli_query($conn,"SELECT * FROM dis_senior");
                      $sese = mysqli_fetch_array($se);
                      ?>
                    <tr>
                      <td align="right" style="padding:0 20px" colspan="3">Discount: <?php echo $sese['discount'] * 100 ?>%</td>
                    </tr>
                    <tr>
                      <td align="right" style="padding:0 20px;font-weight: bold;" colspan="3">Grand Total: P
                        <?php echo number_format($qq['order_amount'], 2) ?></td>
                    </tr>
                  <?php
                    } elseif ($qq['customer_type'] == "junior") {
                       ?>
                    <tr>
                      <td align="right" style="padding:0 20px;font-weight: bold;" colspan="3">Grand Total: P
                        <?php echo number_format($qq['order_amount'], 2) ?></td>
                    </tr>
                  <?php
                    }
                  }
                }*/
      ?>


    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="../print/jQuery.print.min.js"></script>
    <script>
      $(document).ready(function(){

        $('#print').click(function(){
          $(".printable").print();
        });

      });
    </script>
  </body>
</html>
