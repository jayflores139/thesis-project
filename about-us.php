<?php
session_start();
include "includes/connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
	<style type="text/css">
		.buutoon{
			width:200px;
			margin-bottom:10px;
			margin-left:15px
		}
	</style>
</head>
<body class="w3-light-grey">
<?php include 'includes/header.php'; 
		$height = false;
?>

<div class="container w3-light-grey containersssss w3-padding-xxlarge">
	
	<h3 class="w3-text-grey">About us</h3>
	<div class="w3-white row" style="height:auto;padding:20px 30px 100px 30px">
		
		<?php  
		$q = mysqli_query($conn,"SELECT * FROM about");
		while ($qq = mysqli_fetch_array($q)) {
		 	if ($qq['remark'] == 'history') { ?>
		 	
		 	<div class="w3-padding-large col-md-4">
				<div class="w3-padding w3-white" style="height:auto;">
					<h4>History</h4>
					<p>
						<?php echo $qq['content'] ?>
					</p>
				</div>
			</div>

		<?php
		 	}
		 	if ($qq['remark'] == 'mission') { ?>
		 	
		 	<div class="w3-padding-large col-md-4">
				<div class="w3-padding w3-white" style="height:auto;">
					<h4>Mission</h4>
					<p>
						<?php echo $qq['content'] ?>
					</p>
				</div>
			</div>

		<?php
		 	}
		 	if ($qq['remark'] == 'vision') { ?>
		 	
		 	<div class="w3-padding-large col-md-4">
				<div class="w3-padding w3-white" style="height:auto;">
					<h4>Vision</h4>
					<p>
						<?php echo $qq['content'] ?>
					</p>
				</div>
			</div>

		<?php
		 	}
		 } 
		?>

	</div>

</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	$(document).ready(function(){
		
	});
</script>

