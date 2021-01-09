<?php

session_start();
include "includes/connect.php";

 if (isset($_POST['submit_add'])) {
    if (isset($_SESSION['shopping_cart'])) {
      $count = count($_SESSION['shopping_cart']);
      $product_ids = array_column($_SESSION['shopping_cart'],'id');

      if (!in_array($_GET['id'], $product_ids)) {
        $_SESSION['shopping_cart'][$count] = array(
          'id' => $_GET['id'],
          'picture' => $_POST['food_pic'],
          'name' => $_POST['food_name'],
          'price' => $_POST['food_price'],
          'quantity' => $_POST['food_qty']
        );
      }
      else {
        for ($i=0; $i < count($product_ids); $i++) {
          if ($product_ids[$i] == $_GET['id']) {
            $_SESSION['shopping_cart'][$i]['quantity'] += $_POST['food_qty'];
          }
        }
      }
    }
    else {
      $_SESSION['shopping_cart'][0] = array(
        'id' => $_GET['id'],
        'picture' => $_POST['food_pic'],
        'name' => $_POST['food_name'],
        'price' => $_POST['food_price'],
        'quantity' => $_POST['food_qty']
      );
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylesheet/style0.css">
	<link rel="stylesheet" type="text/css" href="includes/icon/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/w3.css">
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
		$height = false;
?>

<div class="container w3-light-grey w3-margin-bottom">
    
    <div class="search-container">
		<form class="w3-right" method="post">
			<input type="text" name="search_menu" class="w3-input" style="padding:5px;" placeholder="Search menu">
			<button class="w3-green w3-button w3-padding-left w3-padding-right" type="submit" style="padding:0 5px" name="submit-search">Search</button>
		</form>
	</div>
    
	<div class="w3-white category-lest w3-center w3-padding-0 w3-left" style="margin-top:10px;padding-top:0">
		<h4 class="w3-blue w3-padding-small w3-margin-0" style="width:100%">Category</h4>
		<?php 
		$ddd = mysqli_query($conn,"SELECT * from category");
		while ($dd = mysqli_fetch_array($ddd)) {
			$v = $dd['cat_id'];
			echo '<h6 style="text-align:left;;margin:10px; text-transform: uppercase;font-style: italic;">'.$dd['cat_name'].'</h6>';
			$ee = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '$v'") or die(mysqli_error($conn));
			while ($eee = mysqli_fetch_array($ee)) { ?>
				<a href="menu.php?tyid=<?php echo $eee['type_id'] ?>" style="font-style: italic"><?php echo $eee['type_name'] ?></a>
		<?php
			}
		}
		?>
	</div>
	
	<div class="w3-right food_container">
		<div class="row w3-center" id="rowsss"  style="margin:10px;">
			<?php 

			if (isset($_POST['submit-search'])) {
				$name = $_POST['search_menu'];

				$sql = mysqli_query($conn, "SELECT * FROM food_menu where food_name like '%$name%'") or die(mysqli_error($conn));
				if (mysqli_num_rows($sql) > 0) {
					$height = true;
					while ($rrrr = mysqli_fetch_array($sql)) { ?>

			<div class="col-md-3 w3-center w3-margin-bottom">
				<div class="w3-border vvvvv" style="padding:10px">
					<div class="image">
					<img src="food_images/<?php echo $rrrr['photo'] ?>">
				</div>
				<div class="food_name">
					<strong><?php echo $rrrr['food_name'] ?></strong>
				</div>
				<div class="food_price">
					<strong class="w3-text-green"><?php echo number_format($rrrr['price'],2) ?></strong>
				</div>
				<div class="food_button">
					<form method="post" action="menu.php?action=add&id=<?php echo $rrrr['food_id'] ?>">
						<input type="hidden" name="food_pic" value="<?php echo $rrrr['photo'] ?>">
						<input type="hidden" name="food_name" value="<?php echo $rrrr['food_name'] ?>">
						<input type="hidden" name="food_price" value="<?php echo $rrrr['price'] ?>">
						<input type="hidden" name="food_qty" value="1">
						<button class="w3-btn w3-green" name="submit_add" type="submit">Add to Cart</button>
					</form>
				</div>
				</div>
			</div>

				<?php
					}
				} else {
					$height = true;
					echo "There is no result found in '$name'.";
				}
			}
			elseif (isset($_GET['tyid'])) {
				$height = true;
				$id = $_GET['tyid'];
				$ggg = mysqli_query($conn,"SELECT * FROM food_menu where type_id = '$id'") or die(mysqli_error($conn));
				while ($jjjj = mysqli_fetch_array($ggg)) { ?>
				<div class="col-md-3 w3-center w3-margin-bottom">
				<div class="w3-border" style="padding:10px">
					<div class="image">
					<img src="food_images/<?php echo $jjjj['photo'] ?>">
				</div>
				<div class="food_name">
					<strong><?php echo $jjjj['food_name'] ?></strong>
				</div>
				<div class="food_price">
					<strong class="w3-text-green"><?php echo number_format($jjjj['price'],2) ?></strong>
				</div>
				<div class="food_button">
					<form method="post" action="menu.php?action=add&id=<?php echo $jjjj['food_id'] ?>">
						<input type="hidden" name="food_pic" value="<?php echo $jjjj['photo'] ?>">
						<input type="hidden" name="food_name" value="<?php echo $jjjj['food_name'] ?>">
						<input type="hidden" name="food_price" value="<?php echo $jjjj['price'] ?>">
						<input type="hidden" name="food_qty" value="1">
						<button class="w3-btn w3-green" name="submit_add" type="submit">Add to Cart</button>
					</form>
				</div>
				</div>
			</div>
			<?php	
				}
			}
			 else {

				$ff = mysqli_query($conn,"SELECT * from food_menu") or die(mysqli_error($conn));
				while ($fff = mysqli_fetch_array($ff)) { ?>
				
			<div class="col-md-3 w3-center w3-margin-bottom">
				<div class="w3-border" style="padding:10px">
					<div class="image">
					<img src="food_images/<?php echo $fff['photo'] ?>">
				</div>
				<div class="food_name">
					<strong><?php echo $fff['food_name'] ?></strong>
				</div>
				<div class="food_price">
					<strong class="w3-text-green"><?php echo number_format($fff['price'],2) ?></strong>
				</div>
				<div class="food_button">
					<form method="post" action="menu.php?action=add&id=<?php echo $fff['food_id'] ?>">
						<input type="hidden" name="food_pic" value="<?php echo $fff['photo'] ?>">
						<input type="hidden" name="food_name" value="<?php echo $fff['food_name'] ?>">
						<input type="hidden" name="food_price" value="<?php echo $fff['price'] ?>">
						<input type="hidden" name="food_qty" value="1">
						<button class="w3-btn w3-green" name="submit_add" type="submit">Add to Cart</button>
					</form>
				</div>
				</div>
			</div>

				<?php
				}
			}
			 ?>
		</div>
			
	</div>	
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	var sad = "<?php echo $height ?>";
	if (sad == true) {
		$("#rowsss").css("height", "600px");
	}
</script>
