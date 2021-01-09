<?php

session_start();
include "includes/connect.php";

if (!isset($_GET['q'])) {
    header("Location:index.php");
  } else {
    $r_id = $_GET['q'];
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
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
    $height = false;
?>

<div class="container w3-light-grey w3-margin-bottom">
  <div class="row container_daw">

          <button onclick="history.back()" class="w3-btn w3-white w3-border w3-round-small w3-right">back</button>
          <div class="w3-light-grey w3-margin-bottom w3-padding">
            <h4 class="w3-text-blue w3-center">Your Order</h4>
            <table style="width:70%;margin:0 auto">
              <tr class="w3-border w3-border-black">
                <td style="padding:10px 5px">Food Name</td>
                <td>Price</td>
                <td>qty</td>
                <td>Total</td>
                <td align="right" class="w3-padding-right"></td>
              </tr>

              <?php  
              $q = mysqli_query($conn,"SELECT add_ons.food_qty, add_ons.food_id, food_menu.food_name, food_menu.price from add_ons inner join food_menu where add_ons.r_id='$r_id' and add_ons.food_id=food_menu.food_id ");
              $overTotal = 0;

              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) { ?>

                <tr class="w3-border-bottom w3-border-black" id="removeRow<?php echo $qq['food_id'] ?>">
                  <td style="padding:10px 5px"><?php echo $qq['food_name'] ?></td>
                  <td>P <?php echo number_format($qq['price'],2) ?></td>
                  <td>
                    <input type="text" value="<?php echo $qq['food_qty'] ?>" id="quantity<?php echo $qq['food_id'] ?>" class="w3-input w3-border" style="width:40px;height:30px;text-align:center">
                  </td>
                  <td>
                    P <?php echo number_format($qq['food_qty'] * $qq['price'],2) ?>
                  </td>
                  <td align="right">
                    <input type="hidden" id="food_id_delete<?php echo $qq['food_id'] ?>" value="<?php echo $qq['food_id'] ?>">
                    <input type="hidden" id="food_id_update<?php echo $qq['food_id'] ?>" value="<?php echo $qq['food_id'] ?>">

                    <input type="hidden" id="order_id_delete" value="<?php echo $r_id ?>">
                    <input type="hidden" id="order_id_update" value="<?php echo $r_id ?>">

                    <button style="width:40px;height:30px;" class="w3-border-0 update" id="<?php echo $qq['food_id'] ?>"><i class="fas fa-sync-alt"></i></button>
                    <button style="width:40px;height:30px;" class="w3-border-0 delete" id="<?php echo $qq['food_id'] ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>

              <?php 
              $overTotal += $qq['food_qty'] * $qq['price'];
                }
              } else {
                echo "<tr><td style='padding:10px 5px' colspan='5' align='center'>No menu added.</td></tr>";
              }
              ?>

              <tr>
                <td class="w3-padding" colspan="4" align="right">
                  Over all Total: P <span class="totalOverAll"><?php echo number_format($overTotal,2) ?></span>
                </td>
              </tr>
              <tr>
                <td align="center" colspan="5" class="w3-padding">
                  <input type="hidden" id="order_id_save" value="<?php echo $r_id ?>">
                  <input type="hidden" id="order_id_cancel" value="<?php echo $r_id ?>">

                  <input type="hidden" id="overAllTotal" value="<?php echo $overTotal ?>" >

                  <button class="w3-green w3-btn w3-padding-small w3-round-small save_new_order">Save Order</button>
                  <button class="w3-white w3-border w3-padding-small w3-btn w3-round-small cancel_new_order">Cancel</button>
                </td>
              </tr>

            </table>
          </div>

          <div class="col-md-12" id="search_menu">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM food_menu");
             while ($row = mysqli_fetch_array($sql)) { ?>

             <div class="col-md-3 w3-center w3-margin-bottom">
              <div class="w3-border vvvvv" style="padding:10px">
                <div class="image">
                <img src="food_images/<?php echo $row['photo'] ?>" alt="<?php echo $row['photo'] ?>" style="width:100%"><br>
              </div>
              <div class="food_name">
                <strong><?php echo $row['food_name'] ?></strong><br>
              </div>
              <div class="food_price">
                <strong>P <?php echo number_format($row['price'],2) ?></strong><br>
              </div>
              <div class="food_button">
                  <input type="hidden" id="r_id" value="<?php echo $r_id ?>">
                  <input type="hidden" value="<?php echo $row['food_id'] ?>" id="food_id<?php echo $row['food_id'] ?>">
                  <input type="hidden" id="qty" value="1">
                 <button id="<?php echo $row['food_id'] ?>" class="w3-btn w3-green add_order">Add</button>
              </div>
              </div>
            </div>

           <?php
            }
           ?>
          </div>

        </div>    
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>


       $(document).ready(function(){
         $(".add_order").click(function(){
          var id = $(this).attr("id");
          var food_id = $("#food_id"+id).val();
          var qty = $("#qty").val();
          var r_id = $("#r_id").val();
          
          $.ajax({
            url: "admin/include/add_ons.inc.php",
            method: "POST",
            data: {
              id: id,
              food_id: food_id,
              qty: qty,
              r_id: r_id
            },
            success: function(dataw){
              if (dataw == "Update") {
                window.location.reload();
              }
            }
          });

         });

         $(".delete").click(function(){
          var delet = $(this).attr("id");
          var food_id = $("#food_id_delete"+delet).val();
          var r_id = $("#order_id_delete").val();

          $.ajax({
            url: "admin/include/add_ons.inc.php",
            method: "POST",
            data: {
              delet: delet,
              food_id:food_id,
              r_id:r_id
            },
            success: function(dataw){
              if (dataw == "Delete") {
                location.reload();
              }          
            }
          });
         });

         $(".update").click(function(){

          var update = $(this).attr("id");
          var food_id = $("#food_id_update"+update).val();
          var r_id = $("#order_id_update").val();
          var quantity = $("#quantity"+update).val();

          $.ajax({
            url: "admin/include/add_ons.inc.php",
            method: "POST",
            data: {
              update: update,
              food_id:food_id,
              r_id: r_id,
              quantity: quantity
            },
            success: function(d){
              if (d == "Bley Bley") {
              location.reload();
              }
            }
          });
         });  
      
      $(".save_new_order").click(function(){
        window.history.back();
      });

      $(".cancel_new_order").click(function(){
        var order_id_cancel = $("#order_id_cancel").val();

        $.ajax({
          url: "admin/include/add_ons_save.inc.php",
          method:"POST",
          data: {order_id_cancel: order_id_cancel},
          success: function(response) {
            if (response == "Cancel new order") {
              window.history.back();
            }
          }
        });

      });

      });

    </script>
