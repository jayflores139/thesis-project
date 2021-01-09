<?php
session_start();
  include '../includes/connect.php';
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
  if (!isset($_GET['edit'])) {
    header("Location:menu.php");
  }
    if (isset($_POST['edit-submit'])) {
      $fname = $_POST['fname'];
      $id = $_POST['id'];
      $price = $_POST['price'];
      $category = $_POST['category'];
      $type = $_POST['type'];
      $descrip = $_POST['descrip'];
      $target = "../food_images/".basename($_FILES['updateimg']['name']);

      if (empty($_FILES['updateimg']['name'])) {
        $error = mysqli_query($conn,"UPDATE food_menu SET
          catid='$category', type_id='$type', food_name='$fname', price='$price', descrip='$descrip' WHERE food_id='$id'");
          if ($error) {
            header("Location:menu.php?update=success");
          }
      }
      else {
        if ($_FILES['updateimg']['name']) {
          $photo = $_FILES['updateimg']['name'];
          mysqli_query($conn,"UPDATE food_menu SET
            catid='$category', type_id='$type', food_name='$fname', price='$price', photo='$photo', descrip='$descrip' WHERE food_id='$id'");
            if (move_uploaded_file($_FILES['updateimg']['tmp_name'], $target)) {
              header("Location:menu.php?update=success");
            }
        }
      }
    }

   ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed">
      <div class="search-con">
        <h2>Food Menu</h2>
      </div>
      <div class="order_page menu-edit">
        <?php

          $sql = mysqli_query($conn,"SELECT * FROM food_menu WHERE food_id = '".$_GET['edit']."'");
          while ($row = mysqli_fetch_array($sql)) { ?>
            <div class="image-view">
              <img src="../food_images/<?php echo $row['photo'] ?>" alt="<?php echo $row['photo'] ?>" class="editimg">
            </div>

            <form class="editform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $_GET['edit'] ?>">
              <label for="file" class="w3-text-blue">Upload new Picture</label>
              <input type="file" name="updateimg" class="w3-border w3-border-blue w3-round">

              <label for="file" class="w3-text-blue">Food Name</label>
              <input type="text" name="fname" class="w3-border w3-border-blue w3-round" value="<?php echo $row['food_name']; ?>"><br>

              <label for="file" class="w3-text-blue">Food Price</label>
              <input type="text" name="price" class="w3-border w3-border-blue w3-round" value="<?php echo $row['price']; ?>"><br>

              <label for="file" class="w3-text-blue">Category</label>
              <select name="category" class="w3-border w3-border-blue w3-round">
                <?php $sqlq = mysqli_query($conn,"SELECT * FROM category");
                while ($roww = mysqli_fetch_array($sqlq)) {?>
                <option value="<?php echo $roww['cat_id'] ?>"><?php echo $roww['cat_name'] ?></option>
              <?php  }?>
              </select>

              <label for="file" class="w3-text-blue">Food Type</label>
              <select name="type" class="w3-border w3-border-blue w3-round">
                <?php $sqlm = mysqli_query($conn,"SELECT * FROM food_type WHERE type_id = '".$row['type_id']."'");
                while ($rowg = mysqli_fetch_array($sqlm)) {?>
                <option value="<?php echo $rowg['type_id'] ?>"><?php echo $rowg['type_name'] ?></option>
              <?php  }?>
              </select>

              <label for="file" class="w3-text-blue">Food Description</label>
              <textarea name="descrip" class="w3-border w3-border-blue w3-round"><?php echo $row['descrip']; ?></textarea>

            <?php
          } ?>
              <button type="submit" class="w3-blue w3-round" name="edit-submit">Update</button>
            </form>
      </div>

    </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
  </body>
</html>
