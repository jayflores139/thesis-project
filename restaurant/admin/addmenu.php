<?php
  include '../includes/connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
$VAT = 0.12;
  
  if (isset($_POST['addMenu-submit'])) {
    $fname = $_POST['fname'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $price = $_POST['price'] + ($_POST['price'] * $VAT);
    $descrip = $_POST['descrip'];
    $image = $_FILES['picture']['name'];
    $target = "../food_images/".basename($_FILES['picture']['name']);
    
      $sql = mysqli_query($conn,"SELECT * FROM food_menu WHERE food_name='$fname'");
      if (mysqli_num_rows($sql)>0) {
        echo '<script>alert("Food name already exist!")</script>';
      }
      else {
        mysqli_query($conn,"INSERT INTO `food_menu`(`catid`, `type_id`, `food_name`, `price`, `photo`, `descrip`)
          VALUES ('$category','$type','$fname','$price','$image','$descrip')");
          if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
            header("location:menu.php?new=foodadded");
          }
      }
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
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed">
      <div class="search-con">
        <h2>Add Menu</h2>
      </div>
      <div class="order_page w3-padding w3-margin-bottom">

        <div class="table-responsive">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="post" class="addMenu" enctype="multipart/form-data">
            <table>
              
              <tr>
                <td width="50%" class="w3-padding">
                  <label for="" class="w3-text-blue">Food Name</label>
                  <input type="text" name="fname" class="w3-border w3-input" required>
                </td>

                <td class="w3-padding">
                  <label for="" class="w3-text-blue">Select Category</label>
                  <select class="w3-border w3-input" id="category" required name="category">
                    <option value="">--Select category--</option>
                    <?php
                    $sql = mysqli_query($conn,"SELECT * FROM category");
                      while ($row = mysqli_fetch_array($sql)) { ?>
                        <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name']; ?></option>
                    <?php
                      }
                     ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td class="w3-padding">
                  <label for="" class="w3-text-blue ">Select Type</label>
                  <select class="w3-border w3-input" id="type" name="type" required>
                  </select>
                </td>

                <td class="w3-padding">
                  <label for="" class="w3-text-blue">Price</label> <br>
                  <input type="number" class="w3-border w3-input w3-left" style="width:55%" required name="price">

                  <span style="line-height: 35px;margin-left:8px">+</span>
                  <input type="text" disabled value="<?php echo $VAT * 100 ?>% VAT" class="w3-input w3-white w3-border w3-right w3-text-grey" style="width:35%">
                </td>
              </tr>

              <tr>
                <td class="w3-padding" colspan="2">
                  <label for="" class="w3-text-blue">Description</label>
                  <textarea name="descrip" class="w3-border w3-input" required></textarea>
                </td>
              </tr>

              <tr>
                <td class="w3-padding">
                  <label for="" class="w3-text-blue">Add Image</label>
                  <input type="file" class="w3-border w3-input" required name="picture"> <br>
                </td>
              </tr>

              <tr>
                <td class="w3-padding">
                  <button type="submit" name="addMenu-submit" class="w3-padding w3-blue w3-input">Add Menu</button>
                </td>
              </tr>

            </table>
          </form>
        </div>
      </div>

    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    
    <script>
        $(document).ready(function(){
           
            $("#category").change(function(){
               var category = $(this).val();
               
               //alert(category);
               
               $.ajax({
                  url:"include/addMenu.inc.php",
                  method:"POST",
                  data:{category: category},
                  success:function(da){
                      $("#type").html(da);
                  }
               });
            });
            
        });
    </script>
    
  </body>
</html>
