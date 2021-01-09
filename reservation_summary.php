<?php

session_start();
include "includes/connect.php";

if (!isset($_SESSION['lat_rid'])) {
	header("Location:index.php");
} else {
	$lat_r = $_SESSION['lat_rid'];
}

if (!isset($_SESSION['id_user'])) {
	header("Location:login.php");
}
$k = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
$kk = mysqli_fetch_array($k);

$p = mysqli_query($conn,"SELECT * FROM downpayment");
$pp = mysqli_fetch_array($p);
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

<div class="container w3-light-grey w3-center hhhhhh" style="height:auto;padding-bottom:50px">
	<h3 class="w3-text-grey w3-center w3-padding-top w3-margin-top">Reservation Summary</h3>
	<?php  
      	$query = mysqli_query($conn,"SELECT * FROM reservation where rid = '$lat_r'") or die(mysqli_error($conn));

      	if (mysqli_num_rows($query) > 0) { 
      		while ($q = mysqli_fetch_array($query)) { ?>

      <fieldset style="margin-top:10px;margin:5px" class="w3-border-0">
      	<button class="w3-btn w3-blue print_btn w3-round"><i class="fas fa-print"></i> Print</button>
      	<button class="w3-btn w3-green w3-round" id="Finish"><i class="fas fa-sign-out-alt"></i> Finish</button>
      </fieldset>

<div id="printArea">
	<div class="alert alert-danger" style="margin-top:10px;text-align:left;">
		<b>PLEASE READ</b><br><br>

		Note: If you choose pera padala as your mode of payment use this NAME - <span style="text-decoration:underline;"><?php echo $kk['Name'] ?></span> and CONTACT NUMBER - <span style="text-decoration:underline;"><?php echo $kk['contact'] ?></span>. <br> You must pay at least <?php echo $pp['d_price'] * 100 ?>% of the actual price as an advance payment 4 days before the booking date, if you failed to pay the said advance payment, reservation will be CANCEL.
	</div>

	 <fieldset style="margin-top:10px;margin:5px" class="w3-border row w3-border-blue">
          <legend style="width:auto; padding:1px 5px;margin:0;font-size:18px" class="w3-text-blue">Booking Details</legend>
          <div  class="col-md-6" style="padding:5px">
          	<table>
          	<tr class="w3-border">
              <th class="w3-padding" width="30%">Name</th>
              <td><?php echo $q['cu_first'].' '.$q['cu_last'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Address</th>
              <td><?php echo $q['cu_add'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Contact number</th>
              <td><?php echo $q['cu_phone'] ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Boooking Date</th>
              <td><?php echo date("M d, Y", strtotime($q['r_date_from'])) ?> <span style="line-height:35px">--</span> <?php echo date("M d, Y", strtotime($q['r_date_from'])) ?></td>
            </tr>
            <tr class="w3-border">
              <th class="w3-padding">Status</th>
              <td><?php echo $q['r_status'] ?></td>
            </tr>
          </table>
          </div>

          <div class="col-md-6" style="padding:5px">
          	<table class=" w3-border">
        <?php  
        $cater = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$q['cater_id']."'") or die(mysqli_error($conn));
        if (mysqli_num_rows($cater) > 0) {
        	while ($caters = mysqli_fetch_array($cater)) { ?>
        	<tr>
	          <th class="w3-padding">Catering Services</th>
	          <td><?php echo $caters['event_name'] ?></td>
	          </tr>
	          <tr class="w3-border">
	            <th class="w3-padding">Price per head</th>
	            <td>P <?php echo number_format($caters['p_head'],2) ?></td>
	          </tr>
	          <tr class="w3-border">
	            <th class="w3-padding">Customize menu?</th>
	            <?php  
	            $check = mysqli_query($conn,"SELECT * FROM custom_r where r_id = '".$q['rid']."'") or die(mysqli_error($conn));
	            if (mysqli_num_rows($check) > 0) { ?>
	            <td> <a href="#print_also">
	            	<button id="dialog-link" class="ui-button ui-widget w3-green w3-border-0" style="padding:1px 3px;">Yes</button>
	            </a> </td>
	            <?php
	            } else { ?>
	            <td> <span class="w3-blue" style="padding:1px 3px;">No</span> </td>
	            <?php
	            }
	            ?>
	          </tr>
	          <tr class="w3-border">
	            <th class="w3-padding">No. of person</th>
	            <td><?php echo $q['total_visitor'] ?></td>
	          </tr>
	           <tr class="w3-border">
	            <th class="w3-padding">Mode of payment</th>
	            <td><?php echo $q['mode_of_payment']; ?></td>
	          </tr>
	          <tr class="w3-border">           
	            <td class="w3-padding" colspan="2"><?php echo $q['total_visitor'].' <span>&times;</span> P '.number_format($caters['p_head'],2) ?> =  P <?php echo number_format($q['total_visitor'] * $caters['p_head'],2 ) ?></td>
	          </tr>
        <?php
        	}
        }
        ?>
        </table>
          </div>
        </fieldset>

<?php //////////////////////////////////////////////////////////////////////////////para dili libug ?>
        <fieldset style="margin:5px;" class="w3-border w3-border-blue">
            <legend style="width:auto; padding:1px 5px;margin:0;font-size:18px" class="w3-text-blue">Payment Details</legend>
            <div class="col-md-12 w3-center" style="margin:0 auto">
	            <table>
	              <tr class="w3-border">
	              	<th class="w3-padding" style="text-align:right;">Payment Date</th>
	              	<td align="left"><?php
	              	if ( date("M d, Y", strtotime($q['r_date_from'].'-4 days')) == date("M d, Y")) {
	              		echo "Today, ".date("M d, Y", strtotime($q['r_date_from'].'-4 days'));
	              	} else {
	              		echo date("M d, Y", strtotime($q['r_date_from'].'-4 days'));              	 
	              	}
	              	?></td>
	              </tr>
	              <tr class="w3-border">
	                <th class="w3-padding" style="text-align:right;">Total Payment</th>
	                <td align="left">P <?php echo number_format($q['payable'],2) ?></td>
	              </tr>
	              <tr class="w3-border">
	                <th class="w3-padding" style="text-align:right;">Balance</th>
	                <td align="left">P <?php echo number_format($q['balance'],2) ?></td>
	              </tr>
	              <tr class="w3-border">
	                <th class="w3-padding" style="text-align:right;">Down Payment</th>
	                <td align="left">P <?php echo number_format($q['downpayment'],2) ?></td>
	              </tr>
	            </table>
            </div>

          </fieldset>

<!-- ================CUSTOM MENU ===================-->
		<div class="print_also w3-border w3-border-blue w3-center" id="print_also" style="margin:5px auto;">
			<h3 class="w3-margin-bottom">Menu</h3>
			<?php  
			$e = mysqli_query($conn,"SELECT * FROM category") or die(mysqli_error($conn));
			while ($ee = mysqli_fetch_array($e)) {
				echo "<b class='w3-light-grey' style='font-size:20px'>".$ee['cat_name']."</b><br>";

				$r = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$ee['cat_id']."'") or die(mysqli_error($conn));
				while ($rr = mysqli_fetch_array($r)) {
					echo "<b class='w3-text-blue' style='font-size:17px'>".$rr['type_name']."</b><br>";

					$t = mysqli_query($conn,"SELECT * FROM food_menu natural join custom_r where type_id = '".$rr['type_id']."' and r_id = '$lat_r'") or die(mysqli_error($conn));
					
					if (mysqli_num_rows($t) > 0) {
						while ($tt = mysqli_fetch_array($t)) {
						echo "<li>".$tt['food_name']."</li>";
						}
					} else {
						$t = mysqli_query($conn,"SELECT * FROM food_menu natural join catering_details where type_id = '".$rr['type_id']."' and cater_id = '".$q['cater_id']."'") or die(mysqli_error($conn));
						while ($tt = mysqli_fetch_array($t)) {
							echo "<li>".$tt['food_name']."</li>";
						}
					}
				}
			}
			?>
		</div>        
<!-- ================CUSTOM MENU ===================-->
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
		$("#Finish").click(function(){
			window.location.href="my_reservation.php";
		});


		$('.print_btn').click(function(){
			$("#printArea").print();
		});

	});

/*
	$( "#dialog" ).dialog({
	autoOpen: false,
	width: 500,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
});


// Link to open the dialog
$( "#dialog-link" ).click(function( event ) {
	$( "#dialog" ).dialog( "open" );
	event.preventDefault();
});
*/

</script>
