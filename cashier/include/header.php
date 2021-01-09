<header class="container-fluid header w3-teal">
  <div class="logo-container w3-teal">
    <img src="../images/foog.png" alt="Logo">
    <h3>Tugkaran Restaurant</h3>
  </div>
  <h3 class="system-title">Online Food Ordering and Reservation System</h3>
</header>

<section class="left-fixed">
  <a href="index.php" class="w3-hover-grey">Home</a>

  <a href="#droper" id="orders" class="w3-hover-grey">Orders <i class="fas fa-chevron-down" id="arror" style="float:right;"></i></a>
  <div class="catering-dr" id="droper">
    <a href="d.php?type=dinein" class="w3-hover-grey ggg" style="border-top:1px solid #fff;border-bottom:1px solid #fff;">Dine-in</a>
    <a href="d.php?type=delivery" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Delivery</a>
    <a href="d.php?type=pickup" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Pick up</a>
    <a href="d.php?type=takeout" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Take out</a>
    <a href="d.php?type=walk in" class="w3-hover-grey ggg" style="border-bottom:1px solid #fff;">Walk in</a>
  </div>

  <a href="addFoodToCart.php" class="w3-hover-grey">Food Menu</a>
  <a href="foodCart.php" class="w3-hover-grey">Food Cart <span class="badge" id="cart_badge">
      <?php if (isset($_SESSION['shopping_cart'])) {
        echo count($_SESSION['shopping_cart']);
      } else {echo "0";} ?></span></a>
  <a href="reports.php?i=sales" class="w3-hover-grey">Reports</a>
  <a href="about.php" class="w3-hover-grey">About us</a>
  <a href="contact.php" class="w3-hover-grey">Contact us</a>
  <a href="logout.php" class="w3-hover-grey">Log out</a>
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