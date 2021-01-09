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
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="search-con w3-white">
        <h2>Food Menu</h2>
        <form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

          <select class="w3-border w3-border-blue" id="category">
            <option value="">--Food Category--</option>
            <?php $sql = mysqli_query($conn,"SELECT * FROM category");
            while ($row = mysqli_fetch_array($sql)) { ?>
              <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name'] ?></option>
          <?php  } ?>
          </select>

          <select class="w3-border w3-border-blue" id="type">
            <option value="">--Food type--</option>
            <?php $sql = mysqli_query($conn,"SELECT * FROM food_type");
            while ($row = mysqli_fetch_array($sql)) { ?>
              <option value="<?php echo $row['type_id'] ?>"><?php echo $row['type_name'] ?></option>
            <?php } ?>
          </select>
          <input type="text" id="fname" class=" w3-border w3-border-blue " placeholder="Search menu here..." style="margin-left:5px;margin-right:5px;">
          <button type="submit" id="submit-search" class="w3-border-0  w3-blue">Search</button>
        </form>
      </div>

      <div class="order_page w3-margin-bottom">
          <div class="w3-left" style="width:100%">
          <a href="addmenu.php">
          <button type="button" name="button" class="neworder w3-border w3-border-blue w3-white w3-text-blue w3-hover-blue">
            <i class="fas fa-plus"></i> Add Menu</button>
        </a>
        <a href="addFoodToCart.php">
          <button type="button" name="button" class=" w3-border w3-border-blue w3-white w3-text-blue w3-hover-blue addtocart">
            <i class="fas fa-plus"></i> Add Food to cart</button>
        </a>
          </div>
          <?php
        if (isset($_GET['new']) && $_GET['new'] == "foodadded") { ?>
           <div class="alert alert-success w3-left alert-dismissible" id="alert" style="width:100%">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              New food menu added successfully!
            </div>
        <?php
        }
        if (isset($_GET['update']) && $_GET['update'] == "success") { ?>
           <div class="alert alert-success w3-left alert-dismissible" id="alert1" style="width:100%">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Update successfully!
            </div>
        <?php
        }
        ?>

        <div class="table-responsive" id="table">
          <table class="w3-bordered w3-center w3-striped w3-padding table-custom">
          <tr class="w3-text-blue">
            <td>Image</td>
            <td>Food Name</td>
            <td>Price</td>
            <td>Category</td>
            <td>FoodType</td>
            <td>Description</td>
            <td>Action</td>
          </tr>
          <?php
          $sql = mysqli_query($conn,"SELECT * FROM food_menu");
          if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_array($sql)) { ?>

            <tr class="t-body w3-border" id="removeRow<?php echo $row['food_id']; ?>">
              <td><img src="../food_images/<?php echo $row['photo']; ?>" alt="<?php echo $row['photo']; ?>"></td>

              <td><?php echo $row['food_name']; ?></td>

              <td><?php echo $row['price']; ?></td>

                  <?php $q = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$row['catid']."'");
                  while ($w = mysqli_fetch_array($q)) { ?>
              <td><?php echo $w['cat_name']; ?></td>
                  <?php } ?>

                  <?php $wew = mysqli_query($conn,"SELECT * FROM food_type WHERE type_id = '".$row['type_id']."'");
                  while ($e = mysqli_fetch_array($wew)) { ?>
              <td><?php echo $e['type_name']; ?></td>
                  <?php } ?>

              <td><?php echo $row['descrip']; ?></td>

              <td width="18%">
                <a href="menu.edit.php?edit=<?php echo $row['food_id']; ?>">
                  <button class="action btn btn-default w3-left" style="margin-right:2px"><i class="fas fa-pencil-alt"></i> Edit</button>
                </a>
                  <input type="hidden" id="food_id<?php echo $row['food_id']; ?>" value="<?php echo $row['food_id']; ?>">
                  <button class="action delete btn btn-default w3-left" id="<?php echo $row['food_id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
              </td>
              <?php
                if (isset($_GET['delete'])) {
                  $id = $_GET['delete'];
                  mysqli_query($conn,"DELETE from food_menu where food_id='$id'");
                  mysqli_query($conn,"DELETE from catering_details WHERE food_id='$id'") or die(mysqli_error($conn));
                  echo '<script>window.location.href="menu.php"</script>';

                }
              }
          } else {
            echo '<tr class="t-body w3-white"><td colspan="7">No menu added yet.</td></tr>'; 
          }
          ?>
        </tr>
        <?php

            ?>
        </table>
        </div>
      </div>
    </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $(document).ready(function(){

        $("#type").change(function(){

          var type = $(this).val();
          if (type == "") {
            location.reload();
          } else {
            $.ajax({
              url: "include/type-search.inc.php",
              method: "POST",
              data: {type: type},
              success: function(da){
                $('#table').html(da);
                $("#alert, #alert1").hide();
              }
            });
          }

        });

        $("#category").change(function(){
          var category =  $(this).val();

          if (category == "") {
            location.reload();
          } else {

            $.ajax({
              url: "include/category-search.inc.php",
              method: "POST",
              data: {category: category},
              success: function(data){
                $('#table').html(data);
                $("#alert, #alert1").hide();
              }
            });

          }

        });

        $("form").submit(function(ev) {
          ev.preventDefault();

          var types = $("#type").val();
          var categories = $("#category").val();
          var fname = $("#fname").val();
          var submit = $("#submit-search").val();
          

          if (types == "" && categories == "" && fname == "") {
            location.reload();
          } else {

            $.ajax({
              url: "include/food-search.inc.php",
              method: "POST",
              data: {
                types: types,
                categories: categories,
                fname: fname,
                submit: submit
              },
              success: function(data){
                $('#table').html(data);
                $("#alert, #alert1").hide();
              }

            });
          }

        });


        $(".delete").click(function(){
          var id = $(this).attr("id");
          var food_id = $("#food_id"+id).val();

          if (confirm("Are you sure?") == true) {
             $.ajax({
              url: "include/delete_food.inc.php",
              method: "POST",
              data: {
                id: id,
                food_id: food_id
              },
              success: function(data){
                if (data == "Deleted") {
                  $("#removeRow"+id).remove();
                  $("#alert, #alert1").hide();
                }
              }
            });
          }

        });


      });
    </script>
  </body>
</html>
