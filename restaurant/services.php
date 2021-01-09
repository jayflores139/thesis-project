<?php

session_start();
include "includes/connect.php";
$rr =false;
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
<?php include 'includes/header.php'; ?>

<div class="container hhhhhh">
	<div class="w3-center">
		<h3 class="w3-padding-large">Catering Services</h3>
		<a href="make-reservation.php"><button class="w3-border w3-border-green w3-text-green w3-padding w3-transparent w3-hover-green w3-margin-bottom w3-btn">Reservation</button></a>	
	</div>

	<div class="row w3-margin-bottom">
			
			<?php

		$sql = mysqli_query($conn,"SELECT * FROM  catering") or die(mysqli_error($conn));
		while ($row = mysqli_fetch_array($sql)) {
			$cater_id = $row['cater_id'];
			?>
			<div>
			  <div class="col-md-4 w3-margin-bottom">	
					<div style="width:100%;" class="w3-green w3-padding">
						<h3 class="w3-center"><?php echo $row['event_name'] ?></h3>
						<p class="w3-center">P <?php echo number_format($row['price'],2) ?> per head</p>
						<p class="w3-center">Good for <?php echo $row['PMin'].' - '.$row['PMax'] ?> persons</p><br>
					</div>	

					<div class="w3-white w3-padding">
    				<div class=" w3-padding" style="width:100%;margin:0 auto">
    					<?php
    					  $d = mysqli_query($conn,"SELECT * FROM category") or die(mysqli_error($conn));
						while ($dd = mysqli_fetch_array($d)) {
							$catid = $dd['cat_id']; ?>
							<h2 class="w3-text-green"><?php echo $dd['cat_name'] ?></h2>
						<?php
						$f = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '$catid'") or die(mysqli_error($conn));
							while ($ff = mysqli_fetch_array($f)) {
								$tyid = $ff['type_id']; ?>
								<strong style="margin-right:50px" class="w3-text-blue"><?php echo $ff['type_name'] ?></strong><br>
								<?php
								$c = mysqli_query($conn,"SELECT * FROM food_menu natural join catering_details where type_id = '$tyid' and cater_id = '$cater_id'") or die(mysqli_error($conn));
								if (mysqli_num_rows($c) >0) {
								    while ($cc = mysqli_fetch_array($c)) { ?>
    									<p class="w3-margin-left"> - <?php echo $cc['food_name'] ?></p>
    								<?php
    								}
								} else {
								    echo "<span class='w3-text-grey'>[ No menu added ]</span><br>";
								}
							}
						}
    					?>	
    				</div>
				</div>
			</div>  
			</div>
				
			<?php
		}
		?>

	</div>

</div>

</body>
</html>
<script>
	$(document).ready(function(){
		var acc = document.getElementsByClassName('accordion');
	for (var i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
				panel.style.border = "0";
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
				panel.style.border = "1px solid #ccc";
			}
		});
	}


		$(".event_name").click(function(){
			var ids = $(this).attr("id");
			alert(ids);
		});

	});
	$("#tabs").tabs();

</script>
