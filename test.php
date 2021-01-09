

<!DOCTYPE html>
<html>
<head>
	<title>Tugkaran Home Page</title>
	<?php include 'includes/links.php'; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylesheet/style0.css">
	<link rel="stylesheet" type="text/css" href="includes/icon/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="admin/css/w3.css">
	<style type="text/css">
		.logo_con label.logo {
			display: block;
			width:79px;
			height:auto;
			padding:1px;
			margin-bottom:1px;
			border-radius: 0;
			margin:0 auto;
		}
		.logo_con label img {
			margin-bottom: 2px;
		}
		.logo_con{
			float: left;
			margin-right: 5px;
		}
	</style>
</head>
<body>
<?php include 'includes/header.php'; 
		$height = false;
?>

<div class="container w3-light-grey" style="height:470px;">
	<fieldset style="width:40%;margin:50px auto" class="qwwwwwwwwwwwww">

		<h3 class="w3-text-grey w3-margin-bottom">Mode of Payment</h3>

		<div class="logo_con w3-center w3-padding-small">
			<label class="btn btn-default logo">
				<img src="images/foog.png" style="width:75px;height:60px"><br>
				<input id="palawan" type="radio" name="radio">
			</label>
			<p class="w3-text-grey w3-small">Palawan Pawnshop</p>
		</div>

		<div class="logo_con w3-center w3-padding-small">
			<label class="btn btn-default logo">
				<img src="images/foog.png" style="width:75px;height:60px"><br>
				<input type="radio" name="radio">
			</label>
			<p class="w3-text-grey w3-small">Cebuana Lhuiller</p>
		</div>

		<div class="logo_con w3-center w3-padding-small">
			<label class="btn btn-default logo">
				<img src="images/bg.png" style="width:75px;height:60px"><br>
				<input type="radio" name="radio">
			</label>
			<p class="w3-text-grey w3-small">Cash Payment</p>
		</div>

	</fieldset>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
<script>
	var sad = "<?php echo $height ?>";
	if (sad == true) {
		$("#rowsss").css("height", "400px");
	}

	$(document).ready(function(){

	});
</script>
	