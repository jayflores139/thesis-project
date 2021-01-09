<header class="container-fluid header w3-teal">
  <div class="logo-container w3-teal">
    <img src="../images/foog.png" alt="Logo">
    <h3>Tugkaran Restaurant</h3>
  </div>
  <h3 class="system-title">Online Food Ordering and Reservation System</h3>
  <div class="account-container">
    <a type="button" class="a drop-to-drop"><i class="fas fa-user"></i>  ADMIN  <i class="fas fa-chevron-down"></i></a>
      <div id="admin-drop" class="admin-drop w3-white w3-round-small w3-center" style="padding:3px 10px 5px 10px;display: none;position:absolute;right:15px;top:60px;box-shadow:1px 1px 5px #ccc;">
        <a href="accounts.php">Account Setting</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?')">Log out</a>
      </div>

    <a href="notification.php" class="b"><i class="fas fa-bell"></i> <span class="badge" id="cart_badge">
      <?php
      $d = mysqli_query($conn,"SELECT * from reservation where r_status = 'Pending'") or die(mysqli_query($conn));
      $dd = mysqli_query($conn,"SELECT * from food_order where status = 'Pending'") or die(mysqli_query($conn));
        echo mysqli_num_rows($d) + mysqli_num_rows($dd);
      ?>
    </span></a>
    <a href="foodCart.php" class="c"><i class="fas fa-shopping-cart"></i> <span class="badge" id="cart_badge">
      <?php if (isset($_SESSION['shopping_cart'])) {
        echo count($_SESSION['shopping_cart']);
      } else {echo "0";} ?></span></a>
  </div>
</header>

<section class="left-fixed">
  <a href="index.php" class="w3-hover-grey">Home</a>

  <a href="#drop" id="cater" class="w3-hover-grey">Catering<i class="fas fa-chevron-down"style="float:right;"></i></a>
    <div class="catering-dr" id="drop">
      <a href="reservation.php" class="w3-hover-grey vvv" style="border-top:1px solid #fff;border-bottom:1px solid #fff;">Reservation List</a>
      <a href="services.php" class="w3-hover-grey vvv" style="border-bottom:1px solid #fff;"
      >Services</a>
    </div>

  <a href="#droper" id="orders" class="w3-hover-grey">Orders <i class="fas fa-chevron-down" id="arror" style="float:right;"></i></a>
  <div class="catering-dr" id="droper">
    <a href="d.php?type=dinein" class="w3-hover-grey ggg" style="border-top:1px solid #fff;border-bottom:1px solid #fff;">Dine-in</a>
    <a href="d.php?type=delivery" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Delivery</a>
    <a href="d.php?type=pickup" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Pick up</a>
    <a href="d.php?type=takeout" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Take out</a>
    <a href="d.php?type=walk in" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Walk in</a>
  </div>

  <a href="menu.php" class="w3-hover-grey">Food Menu</a>
  <a href="user.php" class="w3-hover-grey">Users</a>
  <a href="setting.php?p=downpayment" class="w3-hover-grey">Settings</a>
  <a href="reports.php?i=sales" class="w3-hover-grey">Reports</a>
  <a href="about.php" class="w3-hover-grey">About us</a>
  <a href="contact.php" class="w3-hover-grey">Contact us</a>
</section>
<script>

  $(document).ready(function(){
    $("#cater").click(function(){
      $(this).css("background", "#ccc");
      var drop = document.getElementById('drop');
      if (drop.style.display == 'block') {
        drop.style.display='none';
        $(".vvv").css("background", "#fcfcfc");
        $(this).css("background", "#fcfcfc");
      } else {
        drop.style.display='block';
        $(".vvv").css("background", "#ccc");
      }
    });

    $("#orders").click(function(){
      $(this).css("background", "#ccc");
      var dropss = document.getElementById('droper');
      if (dropss.style.display == 'block') {
        dropss.style.display='none';
        $(this).css("background", "#fcfcfc");
      } else {
        dropss.style.display='block';
        $(".ggg").css("background", "#ccc");

      }
    });

    $(".drop-to-drop").click(function(){
      var dropssss = document.getElementById('admin-drop');
      if (dropssss.style.display == 'block') {
        dropssss.style.display='none';
      } else {
        dropssss.style.display='block';
      }

    });
  });

</script>