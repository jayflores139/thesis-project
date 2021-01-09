<header class="container-fluid w3-center" style="color:#fff;background-image: url(food_images/others2.jpg); height:150px;padding:30px">
	<div class="w3-right w3-padding accounts" style="position: absolute;top:5px;right:5px;"">
		
		<ul>
			<?php  

			if (isset($_SESSION['id_user'])) { 
				$q = mysqli_query($conn,"SELECT * FROM users where id = '".$_SESSION['id_user']."' ");
				$qq = mysqli_fetch_array($q);
				?>

				<li><button id="account"><?php echo $qq['firstname']."'s " ?> Account <i class="fas fa-chevron-down"></i></button>
					<ul id="id" style="display: none;">
						<li><a href="my_order.php?order=delivery"><button style="border-top:1px solid #333">My Order</button></a></li>
						<li><a href="my_reservation.php"><button>My Reservation</button></a></li>
						<li><a href="my_account.php"><button>My Account</button></a></li>
						<li><a href="includes/logout.php"><button>Log out</button></a></li>
					</ul>
				</li>
			<?php
			} else { ?>
				<li style="float: left;margin-right:2px;"><a href="login.php"><button>Login</button></a></li>
				<li style="float: left;margin-right:2px;"><a href="signup.php"><button>Sign up</button></a></li>
			<?php
			}
			?>
		</ul>

	</div>

	<div class="w3-left w3-padding">
		<img src="images/logo.png" style="width:70px;height:70px;">
	</div>

	<div class="w3-center" style="width:500px;margin:0 auto;">
		<h2>Tugkaran Restaurant</h2>
		<p>Online Food Ordering and Reservation System</p>	
	</div>	
</header>

<nav class="container-fluid w3-green" style="margin-bottom:20px">
	<ul class="w3-navbar nav-topp" style="margin:0 auto">
		<li><a href="index.php" class="actives w3-hover-blue">Home</a></li>
		<li><a href="menu.php" class="actives w3-hover-blue">Food menu</a></li>
		<li><a href="services.php" class="actives w3-hover-blue">Catering Services</a></li>
		<?php if (isset($_SESSION['id_user'])) { ?>
		<li><a href="notification.php" class="actives w3-hover-blue">Notification <span class="badge"><?php if (!empty($_SESSION['notification'])) {
			echo $_SESSION['notification'];
		} ?></span></a></li>
		<?php } ?>
		<li><a href="about-us.php" class="actives w3-hover-blue">About us</a></li>
		<li><a href="contact-us.php" class="actives w3-hover-blue">Contact us</a></li>
		<li><a href="cart.php" class="actives w3-hover-blue">Cart <span class="badge"><?php if (!empty($_SESSION['shopping_cart'])) {echo count($_SESSION['shopping_cart']);} else {echo 0;}?></span></a></li>
	</ul>
</nav>
<script>
	$(document).ready(function(){
		var ddd = document.getElementById('id');
		$("#account").click(function(){
			if (ddd.style.display == "block") {
				ddd.style.display = "none";
			} else {
				ddd.style.display = "block";
			}
		});
	});
</script>