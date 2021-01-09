<?php
  include '../includes/connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

  if (!isset($_SESSION['order_id'])) {
    header("Location:index.php");
  } else {
    $order_id = $_SESSION['order_id'];
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Food Menu</title>
    <?php include 'include/link.php'; ?>
  </head>
  <body>
    <?php include 'include/header.php'; ?>


    <div class="right-fixed">
      <div class="search-con">
        <h2>Add Order</h2>
        <form class="w3-right search_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
          <button type="submit" class="w3-btn w3-blue w3-round w3-right w3-border-0" id="submit-search" style="margin-left:5px;">Search</button>
          <input type="text" id="fname" class="w3-right w3-round w3-border-blue" placeholder="Search menu here..." style="width:250px ">
        </form>
      </div>
      <div class="order_page foodcart">
        <div class="row container_daw">

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
              $q = mysqli_query($conn,"SELECT food_order_details.food_qty, food_order_details.food_id, food_menu.food_name, food_menu.price from food_order_details inner join food_menu where food_order_details.order_id='$order_id' and food_order_details.food_id=food_menu.food_id ");
              $overTotal = 0;

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

                  <input type="hidden" id="order_id_delete" value="<?php echo $order_id ?>">
                  <input type="hidden" id="order_id_update" value="<?php echo $order_id ?>">

                  <button style="width:40px;height:30px;" class="w3-border-0 update" id="<?php echo $qq['food_id'] ?>"><i class="fas fa-sync-alt"></i></button>
                  <button style="width:40px;height:30px;" class="w3-border-0 delete" id="<?php echo $qq['food_id'] ?>"><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>

              <?php 
              $overTotal += $qq['food_qty'] * $qq['price'];
              }
              ?>

              <tr>
                <td class="w3-padding" colspan="4" align="right">
                  Over all Total: P <span class="totalOverAll"><?php echo number_format($overTotal,2) ?></span>
                </td>
              </tr>
              <tr>
                <td align="center" colspan="5" class="w3-padding">
                  <input type="hidden" id="order_id_save" value="<?php echo $order_id ?>">
                  <input type="hidden" id="order_id_cancel" value="<?php echo $order_id ?>">

                  <input type="hidden" id="overAllTotal" value="<?php echo $overTotal ?>" >

                  <button class="w3-green btn w3-round-small w3-border w3-border-green save_new_order">Save Order</button>
                  <button class="w3-transparent w3-text-red w3-hover-red btn w3-round-small w3-border w3-border-red cancel_new_order">Cancel</button>
                </td>
              </tr>

            </table>
          </div>

          <div class="col-md-12" id="search_menu">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM food_menu");
             while ($row = mysqli_fetch_array($sql)) { ?>
             <div class="col-md-3">
               <div class="container-food" style="height:300px">
                 <img src="../food_images/<?php echo $row['photo'] ?>" alt="<?php echo $row['photo'] ?>"><br>
                 <strong><?php echo $row['food_name'] ?></strong><br>
                 <strong>P <?php echo number_format($row['price'],2) ?></strong><br>

                    <input type="hidden" id="order_id" value="<?php echo $order_id ?>">
                    <input type="hidden" value="<?php echo $row['food_id'] ?>" id="food_id<?php echo $row['food_id'] ?>">
                    <input type="hidden" id="qty" value="1">
                   <button id="<?php echo $row['food_id'] ?>" class="w3-btn w3-green add_order">Add</button>

               </div>
             </div>
           <?php
            }
           ?>
          </div>

        </div>
      </div>

    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>


       $(document).ready(function(){
         $(".add_order").click(function(){
          var id = $(this).attr("id");
          var food_id = $("#food_id"+id).val();
          var qty = $("#qty").val();
          var order_id = $("#order_id").val();
          
          $.ajax({
            url: "include/new_order.inc.php",
            method: "POST",
            data: {
              id: id,
              food_id: food_id,
              qty: qty,
              order_id: order_id
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
          var order_id = $("#order_id_delete").val();

          $.ajax({
            url: "include/new_order.inc.php",
            method: "POST",
            data: {
              delet: delet,
              food_id:food_id,
              order_id:order_id
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
          var order_id = $("#order_id_update").val();
          var quantity = $("#quantity"+update).val();

          $.ajax({
            url: "include/new_order.inc.php",
            method: "POST",
            data: {
              update: update,
              food_id:food_id,
              order_id: order_id,
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
        var order_id_save = $("#order_id_save").val();
        var overAllTotal = $("#overAllTotal").val();

        $.ajax({
          url: "include/old_order_save.php",
          method:"POST",
          data:{
            order_id_save: order_id_save,
            overAllTotal: overAllTotal
          },
          success: function(data){
            if (data == "Update old order") {
              window.history.back();
            }
          }
        });
      });

      $(".cancel_new_order").click(function(){
        var order_id_cancel = $("#order_id_cancel").val();

        $.ajax({
          url: "include/old_order_save.php",
          method:"POST",
          data: {order_id_cancel: order_id_cancel},
          success: function(response) {
            if (response == "Cancel new order") {
              window.history.back();
            }
          }
        });

      });

      $(".search_form").submit(function(e){
        e.preventDefault();

        var submit_search = $("#submit-search").val();
        var fname = $("#fname").val();

        if (fname == "") {
          location.reload();
        } else {
          $.ajax({
            url: "include/old_order_save.php",
            method:"POST",
            data: {
              submit_search: submit_search,
              fname: fname
            },
            success: function(q) {
              if (q == "No menu found.") {
                alert("No menu like "+fname+" found!");
              } else {
                $("#search_menu").html(q);
              }
            }
          });
        }

      });

      });

    </script>
  </body>
</html>