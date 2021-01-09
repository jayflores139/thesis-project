<?php
  include '../includes/connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

  if (isset($_POST['submit_add'])) {
    if (isset($_SESSION['shopping_cart'])) {
      $count = count($_SESSION['shopping_cart']);
      $product_ids = array_column($_SESSION['shopping_cart'],'id');

      if (!in_array($_GET['id'], $product_ids)) {
        $_SESSION['shopping_cart'][$count] = array(
          'id' => $_GET['id'],
          'picture' => $_POST['hidden_pic'],
          'name' => $_POST['hidden_name'],
          'price' => $_POST['hidden_prc'],
          'quantity' => $_POST['hidden_qty']
        );
      }
      else {
        for ($i=0; $i < count($product_ids); $i++) {
          if ($product_ids[$i] == $_GET['id']) {
            $_SESSION['shopping_cart'][$i]['quantity'] += $_POST['hidden_qty'];
          }
        }
      }
    }
    else {
      $_SESSION['shopping_cart'][0] = array(
        'id' => $_GET['id'],
        'picture' => $_POST['hidden_pic'],
        'name' => $_POST['hidden_name'],
        'price' => $_POST['hidden_prc'],
        'quantity' => $_POST['hidden_qty']
      );
    }
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
        <h2>Food Menu</h2>
        <form class="w3-right search_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off" method="post">
          <button type="submit" class="w3-btn w3-blue w3-round w3-right w3-border-0" id="submit-search" style="margin-left:5px;">Search</button>
          <input type="text" id="fname" class="w3-right w3-round w3-border-blue" placeholder="Search menu here..." style="width:250px ">
        </form>
      </div>
      <div class="order_page foodcart">
        <div class="row container_daw">

          <?php
            $sql = mysqli_query($conn, "SELECT * FROM food_menu");
             while ($row = mysqli_fetch_array($sql)) { ?>
             <div class="col-md-3">
               <div class="container-food">
                 <img src="../food_images/<?php echo $row['photo'] ?>" alt="<?php echo $row['photo'] ?>"><br>
                 <strong><?php echo $row['food_name'] ?></strong><br>
                 <strong>P <?php echo number_format($row['price'],2) ?></strong><br>

                 <form action="<?php echo $_SERVER['PHP_SELF'].'?acton=add&id='.$row['food_id'] ?>" method="post">
                   <input type="hidden" name="hidden_name" value="<?php echo $row['food_name'] ?>">
                   <input type="hidden" name="hidden_pic" value="<?php echo $row['photo'] ?>">
                   <input type="hidden" name="hidden_prc" value="<?php echo $row['price'] ?>">
                   <input type="hidden" name="hidden_qty" value="1">
                   <button type="submit" name="submit_add" class="w3-btn w3-green add_to_cart">Add to cart</button>
                   </form>

               </div>
             </div>
           <?php
            }
           ?>

        </div>
      </div>

    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $(document).ready(function(){

        $(".search_form").submit(function(eve){
          eve.preventDefault();

          var submit = $("#submit-search").val();
          var fname = $("#fname").val();

          if (fname == "") {
            window.location.reload();
          } else {
            $.ajax({
              url: "include/delete_food.inc.php",
              method: "POST",
              data: {
                submit: submit,
                fname: fname
              },
              success: function(data){
                $(".container_daw").html(data);
              }
            })
          }
        })
      });
    </script>
  </body>
</html>
