 <?php
 session_start();
 include '../includes/connect.php';
$f= false;

if (!$_GET['edit']) {
  header("Location:services.php");

}
if (isset($_GET['update'])) {
  echo '<script>alert("Update successfully!")</script>';
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
        width:60%;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <div class="right-fixed">
      <div class="search-con">
        <h2>Edit Services</h2>
      </div>

      <form class="newservices" action="include/services_edit.inc.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="hidden_id_edit" value="<?php echo $_GET['edit'] ?>">
        <?php $sql = mysqli_query($conn,"SELECT * FROM catering WHERE cater_id='".$_GET['edit']."'")or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($sql)) { ?>

          <label>Package Name
          <input class="w3-input w3-border w3-border-grey" value="<?php echo $row['event_name'] ?>" type="text" name="occasion_edit" required>
          </label>
          <label for="price">Price per head
          <input type="number" class="w3-input w3-border w3-border-grey" value="<?php echo $row['price'] ?>" name="price_edit" placeholder="Price per head" id="price" required>
          </label> <br><br>
          <label>
            Good for <br>
            <input type="number" name="PMin" class="w3-input w3-border w3-border-grey w3-left" style="width:45%" value="<?php echo $row['PMin'] ?>"> <span style="line-height: 35px;margin-left:23px">to</span>
            <input type="number" name="PMax" class="w3-input w3-border w3-border-grey w3-right" style="width:45%" value="<?php echo $row['PMax'] ?>"> <br><br>
            Persons <br><br><br>
          </label>
      <?php  } ?>

        <br>
        
        <div class="addmenu-con w3-center" id="addmenu-con">
            <h4 style="color:#333">CURRENT MENU</h4>
            <span class="w3-text-blue">|</span>
            <?php 
            $g = mysqli_query($conn,"SELECT food_menu.food_name,food_menu.food_id FROM food_menu inner join catering_details where food_menu.food_id=catering_details.food_id and catering_details.cater_id='".$_GET['edit']."' ") or die(mysqli_error($conn));
            
            while ($gg = mysqli_fetch_array($g)) { ?>
                <label class="w3-text-black" style="font-weight: normal"> <?php echo $gg['food_name']; ?> <span class="w3-text-blue">|</span></label>
            <?php
            }
            ?>
        </div>
        
        <div class="addmenu-con w3-margin-bottom" id="addmenu-con">
          <h4>CHANGE MENU</h4>
          <div class="row">

          <?php $sql = mysqli_query($conn,"SELECT * FROM category") or die(mysqli_error($conn));
          while ($row = mysqli_fetch_array($sql)) {
            $catid = $row['cat_id']; ?>
            <div class="col-md-6 ediwew">
              <div class="custom-column w3-margin-bottom w3-light-grey w3-padding-bottom">
                <p class="category_name"><?php echo $row['cat_name'] ?></p>

                <?php $sql2 = mysqli_query($conn,"SELECT * FROM food_type WHERE cat_id='$catid'") or die(mysqli_error($conn));
                while ($row2 = mysqli_fetch_array($sql2)) {
                  $tyid = $row2['type_id']; ?>
                  <p class="type_name"><?php echo $row2['type_name'] ?></p>

              <?php

              $n = mysqli_query($conn,"SELECT * FROM food_menu  where type_id = '".$row2['type_id']."' ") or die(mysqli_error($conn));
              
              while ($nn = mysqli_fetch_array($n)) { 
                ?>
                <input type="checkbox" class="w3-check" name="selected_food[]" value="<?php echo $nn['food_id'] ?>">
                <label style="font-weight: normal" class="w3-text-black"> <?php echo $nn['food_name'] ?></label><br>

                <?php
                }
                } ?>
              </div>
            </div>
        <?php
      } ?>
          </div>
        </div>
        <button type="submit" class="w3-btn w3-margin-bottom w3-light-grey w3-padding-medium w3-border" style="margin-bottom:400px" name="submit-update">Submit</button>
      </form>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $("#tabs").tabs();

    </script>
  </body>
</html>
