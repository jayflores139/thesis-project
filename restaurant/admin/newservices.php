<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
  include '../includes/connect.php';


if (isset($_POST['submit'])) {
  $packageName = $_POST['packageName'];
  $price = $_POST['price'];

    if (!empty($_POST['food_id'])) {
      $q = mysqli_query($conn,"INSERT INTO catering (event_name, price, PMin, PMax) values ('$packageName','$price', '".$_POST['goodForMin']."', '".$_POST['goodForMax']."') ");

      if ($q == true) {
        $l = mysqli_insert_id($conn);
      }

      foreach ($_POST['food_id'] as $value) {
        $w = mysqli_query($conn,"INSERT INTO catering_details (cater_id, food_id) values ('$l', '$value') ");
      }
      echo '<script>location="services.php"</script>';
    } else {
      echo '<script>alert("Please select menu!");history.back()</script>';
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
        font-weight:normal;
        text-align: left;
        width:80%;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <div class="right-fixed">
      <div class="search-con w3-border-0">
      </div>

      <div class="row" style="margin-bottom:50px">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="POST" enctype="multipart/form-data">
        <div class="col-md-5">

          <div class=" w3-center w3-padding">
            <h3>Add new package</h3> <br>
              <div>
                <label>
                  Package Name
                  <input type="text" name="packageName" required class="w3-input w3-border w3-border-grey">
                </label> <br><br>

                <label>
                  Good for <br>
                  <input type="number" name="goodForMin" required class="w3-input w3-border w3-border-grey w3-left" style="width:45%" placeholder="Min">
                  <input type="number" name="goodForMax" required class="w3-input w3-border w3-border-grey w3-right" style="width:45%" placeholder="Max">
                  Persons
                </label><br><br>

                <label>
                  Price per head
                  <input type="number" name="price" required class="w3-input w3-border w3-border-grey">
                </label><br><br>

                <button type="submit" name="submit" class="w3-btn w3-round-small w3-light-grey w3-border">Submit</button>
              </div>
          </div>

        </div>

        <div class="col-md-6 w3-border-left w3-margin-right">

          <div> 
            <h3>Add menu</h3><br>
          </div>

          <?php  
            $q = mysqli_query($conn,"SELECT * FROM category ");
            while ($qq = mysqli_fetch_array($q)) {
              echo "<h4 class='w3-text-green'>".$qq['cat_name']."</h4>";

              $w = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$qq['cat_id']."' ");
              while ($ww = mysqli_fetch_array($w)) {
                echo "<h5>".$ww['type_name']."</h5>";

                $e = mysqli_query($conn,"SELECT * FROM food_menu WHERE type_id = '".$ww['type_id']."' and catid = '".$qq['cat_id']."' ");
                while ($ee = mysqli_fetch_array($e)) { ?>
                  
                  <label class="w3-margin-left">
                    <input type="checkbox" name="food_id[]" value="<?php echo $ee['food_id'] ?>">
                    <?php echo $ee['food_name'] ?>
                  </label> <br>
                <?php
                }
              }
            }
          ?>

        </div>
      </div>
      </form>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $("#tabs").tabs();
    </script>
  </body>
</html>
