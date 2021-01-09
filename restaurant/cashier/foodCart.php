<?php
  include '../includes/connect.php';
  session_start();
  
if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

  if (isset($_GET['action']) && $_GET['action'] == "remove") {
    foreach ($_SESSION['shopping_cart'] as $key => $value) {
      if ($value['id'] == $_GET['id']) {
        unset($_SESSION['shopping_cart'][$key]);
      }
    }
  }

  if (isset($_POST['update_cart'])) {
      $ids = $_GET['id'];
      $fff = $_POST['update_box'];
      foreach ($_SESSION['shopping_cart'] as $key => $value) {
        if ($value['id'] == $ids) {
          if ($fff == 0) {
            $_SESSION['shopping_cart'][$key]['quantity'] = 1;
          } else {
            if ($_SESSION['shopping_cart'][$key]['id'] == $ids) {
              $_SESSION['shopping_cart'][$key]['quantity'] = $fff;
            }
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
  <body style="background:#f3f3f3;">
    <?php include 'include/header.php'; ?>

    <div class="w3-right rights-s">
      <div class="table-responsive w3-margin-top w3-left" style="padding:5px 15px 5px 15px;width:65%;">
        <table class="w3-bordered w3-round-small w3-white cart-con-table">
          <tr class="w3-light-grey">
            <td colspan="6">Cart Details</td>
          </tr>
          <tr class="w3-text-blue w3-small">
            <td width="20%">Image</td>
            <td width="30%">Food Name</td>
            <td>Price</td>
            <td>Qty</td>
            <td>Sub total</td>
            <td width="17%" align="right">Action</td>

          </tr>
          <?php if (!empty($_SESSION['shopping_cart'])) {
            $total = 0;
            foreach ($_SESSION['shopping_cart'] as $key => $value) { ?>
              <tr>
                <td><img src="../food_images/<?php echo $value['picture'] ?>" alt="<?php echo $value['picture'] ?>"></td>
                <td><?php echo $value['name'] ?></td>
                <td>P <?php echo $value['price'] ?></td>
                <td><form action="foodCart.php?action=update&id=<?php echo $value['id'] ?>" method="post">
                  <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                  <input type="text" value="<?php echo $value['quantity'] ?>" size="1" name="update_box" class="w3-center">
                </td>
                <td>P <?php echo number_format($value['quantity'] * $value['price'],2) ?></td>
                <td align="right">
                  <button type="submit" name="update_cart" class="w3-hover-grey w3-light-grey w3-border-0"
                  style="height:40px;width:40px">
                     <i class="fas fa-sync-alt"></i></button>
                   </form>

                  <a href="foodCart.php?action=remove&id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure you want to delete this?')">
                     <button class="w3-hover-grey w3-light-grey w3-border-0" style="height:40px;width:40px"><i class="fas fa-trash-alt"></i></button></a></td>
              </tr>
          <?php
          $v = $value['quantity'] * $value['price'];
          $total = $total + $v;
        }
      } else { ?>
          <tr>
            <td colspan="6" align="center">Your cart is empty.</td>
          </tr>
      <?php  } ?>
        <tr>
          <td colspan="6" align="center">
            <a class="w3-btn w3-green btn-continue w3-round" href="menu.php">Click here to add more</a>
          </td>
        </tr>
        </table>
      </div>
      <div class="w3-margin-top w3-right order-summary" style="padding:5px 15px 5px 5px; width:35%;height:auto;">
        <div class="w3-white" style="height:auto;width:100%;padding-bottom:10px">
          <h5 class="w3-light-grey" style="padding:12px;margin-top:0;font-size:15px;font-weight:normal">Order Total</h5>
            <div class="w3-padding w3-center">

              <table class="w3-bordered w3-white cart-con-table">

                <?php
                if (!empty($_SESSION['shopping_cart'])) { ?>

                  <tr>
                  <th>Grand Total:</th>
                  <td>P <?php echo number_format($total,2) ?></td>
                </tr>
                <tr>
                  <td colspan="2"> <a href="<?php
                    if (!empty($_SESSION['shopping_cart'])) {
                    echo "place_order.php";
                  } else {echo "#";} ?> "><button type="button" class="w3-btn w3-blue w3-round" name="button">Place Order</button></a> </td>
                </tr>

                  <?php
                } else {
                  ?>

                  <tr>
                  <th>Grand Total:</th>
                  <td>0.00</td>
                </tr>
                <tr>
                  <td colspan="2"> <button type="button" class="w3-btn w3-blue w3-round" name="button">Place Order</button> </td>
                </tr>

                  <?php
                }
                ?>

              </table>

            </div>
        </div>
      </div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
  </body>
</html>
