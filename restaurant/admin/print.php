<?php  
	include '../includes/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Print Records</title>
	<style type="text/css">
		.enter {
			width:100%;
			align-items: center;
		}
		table{
			border-collapse: collapse;
			width: 100%;
			text-align: center;
		}
		table, tr, td {
			border: 1px solid #ccc;
		}
		td{
			padding:10px;
		}
		a{
			padding:3px 5px;
			text-decoration: none;
			color: blue;
		}
	</style>
</head>
<body>
	<?php  
	if (isset($_GET['type']) && $_GET['type'] == "delivery" && isset($_GET['p'])) { ?>
		<div class="enter">
		<div style="width:50%;margin:0 auto">
			<a href="?type=delivery&p=pending"> Pending Orders</a> | 
			<a href="?type=delivery&p=approve"> Confirmed Orders</a> | 
			<a href="?type=delivery&p=cancel"> Cancelled Orders</a> | 
			<a href="?type=delivery&p=all"> All Delivery Orders</a>
			<br><br>
		</div> <br><br>

		<div style="text-align: center"><button onclick="window.print()" style="padding:5px 10px;width:150px">Print</button></div> <br>
		<table>

            <tr class="w3-text-black">
              <td style="padding:10px"></td>
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Contact #</td>
              <td class="w3-padding">Delivery Date / Time</td>
              <td class="w3-padding">Delivery Address / Delivery charge</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
            </tr>

            <?php 
            if (isset($_GET['type']) && $_GET['type'] == "delivery" && $_GET['p'] == "pending") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'pending' and order_type = 'delivery' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding"><?php echo $zz['house_street'].', '.$xx['barangay'].' / P '.number_format($xx['deliv_charge'],2) ?></td>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "delivery" && $_GET['p'] == "approve") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'approve' and order_type = 'delivery' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding"><?php echo $zz['house_street'].', '.$xx['barangay'].' / P '.number_format($xx['deliv_charge'],2) ?></td>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "delivery" && $_GET['p'] == "cancel") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'cancel' and order_type = 'delivery' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding"><?php echo $zz['house_street'].', '.$xx['barangay'].' / P '.number_format($xx['deliv_charge'],2) ?></td>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif ((isset($_GET['type']) && $_GET['type'] == "delivery" && $_GET['p'] == "all")) {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'delivery' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding"><?php echo $zz['house_street'].', '.$xx['barangay'].' / P '.number_format($xx['deliv_charge'],2) ?></td>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            }
            ?>
        </table>
	</div>
	<?php
	} elseif (isset($_GET['type']) && $_GET['type'] == "dinein" && isset($_GET['p'])) { ?>
		<div class="enter">
		<div style="width:50%;margin:0 auto">
			<a href="?type=dinein&p=pending"> Pending Orders</a> | 
			<a href="?type=dinein&p=approve"> Confirmed Orders</a> | 
			<a href="?type=dinein&p=cancel"> Cancelled Orders</a> | 
			<a href="?type=dinein&p=all"> All Delivery Orders</a>
			<br><br>
		</div> <br><br>

		<div style="text-align: center"><button onclick="window.print()" style="padding:5px 10px;width:150px">Print</button></div> <br>
		<table>

            <tr class="w3-text-black">
              <td style="padding:10px"></td>
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Contact #</td>
              <td class="w3-padding">Dine-in Date / Time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
            </tr>

            <?php 
            if (isset($_GET['type']) && $_GET['type'] == "dinein" && $_GET['p'] == "pending") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'pending' and order_type = 'dinein' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "dinein" && $_GET['p'] == "approve") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'approve' and order_type = 'dinein' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "dinein" && $_GET['p'] == "cancel") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'cancel' and order_type = 'dinein' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif ((isset($_GET['type']) && $_GET['type'] == "dinein" && $_GET['p'] == "all")) {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            }
            ?>
        </table>
	</div>
	<?php
	} elseif (isset($_GET['type']) && $_GET['type'] == "pickup" && isset($_GET['p'])) { ?>
		<div class="enter">
		<div style="width:50%;margin:0 auto">
			<a href="?type=pickup&p=pending"> Pending Orders</a> | 
			<a href="?type=pickup&p=approve"> Confirmed Orders</a> | 
			<a href="?type=pickup&p=cancel"> Cancelled Orders</a> | 
			<a href="?type=pickup&p=all"> All Delivery Orders</a>
			<br><br>
		</div> <br><br>

		<div style="text-align: center"><button onclick="window.print()" style="padding:5px 10px;width:150px">Print</button></div> <br>
		<table>

            <tr class="w3-text-black">
              <td style="padding:10px"></td>
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Contact #</td>
              <td class="w3-padding">Pick up Date / Time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
            </tr>

            <?php 
            if (isset($_GET['type']) && $_GET['type'] == "pickup" && $_GET['p'] == "pending") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'pending' and order_type = 'pickup' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "pickup" && $_GET['p'] == "approve") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'approve' and order_type = 'pickup' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "pickup" && $_GET['p'] == "cancel") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'cancel' and order_type = 'pickup' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif ((isset($_GET['type']) && $_GET['type'] == "pickup" && $_GET['p'] == "all")) {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'pickup' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            }
            ?>
        </table>
	</div>
	<?php
	} elseif (isset($_GET['type']) && $_GET['type'] == "takeout" && isset($_GET['p'])) { ?>
		<div class="enter">
		<div style="width:50%;margin:0 auto">
			<a href="?type=takeout&p=pending"> Pending Orders</a> | 
			<a href="?type=takeout&p=approve"> Confirmed Orders</a> | 
			<a href="?type=takeout&p=cancel"> Cancelled Orders</a> | 
			<a href="?type=takeout&p=all"> All Delivery Orders</a>
			<br><br>
		</div> <br><br>

		<div style="text-align: center"><button onclick="window.print()" style="padding:5px 10px;width:150px">Print</button></div> <br>
		<table>

            <tr class="w3-text-black">
              <td style="padding:10px"></td>
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Contact #</td>
              <td class="w3-padding">Take out Date / Time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
            </tr>

            <?php 
            if (isset($_GET['type']) && $_GET['type'] == "takeout" && $_GET['p'] == "pending") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'pending' and order_type = 'takeout' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "takeout" && $_GET['p'] == "approve") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'approve' and order_type = 'takeout' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif (isset($_GET['type']) && $_GET['type'] == "takeout" && $_GET['p'] == "cancel") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where status = 'cancel' and order_type = 'takeout' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } elseif ((isset($_GET['type']) && $_GET['type'] == "takeout" && $_GET['p'] == "all")) {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'takeout' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              <?php  
		              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
		              if (mysqli_num_rows($w) > 0) {
		              	$ww = mysqli_fetch_array($w); ?>
		              	<td class="w3-padding"><?php echo $ww['p_to_pick'] ?></td>
		              	<td class="w3-padding"><?php echo $ww['contact'] ?></td>
		              <?php
		              } else {
		              	$e = mysqli_query($conn,"SELECT * FROM users where id = '$user_id' ");
		              	while ($ee = mysqli_fetch_array($e)) { ?>
		              	<td class="w3-padding"><?php echo $ee['firstname'].' '.$ee['lastname'] ?></td>
		              	<td class="w3-padding"><?php echo $ee['contact'] ?></td>
		              <?php
		              	}
		              }
		              ?>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            }
            ?>
        </table>
	</div>
	<?php
} elseif (isset($_GET['type']) && $_GET['type'] == "walk in" && isset($_GET['p'])) { ?>
		<div class="enter">
		<br><br>

		<div style="text-align: center"><button onclick="window.print()" style="padding:5px 10px;width:150px">Print</button></div> <br>
		<table>

            <tr class="w3-text-black">
              <td style="padding:10px"></td>
              <td class="w3-padding">Date</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
            </tr>

            <?php 
            if (isset($_GET['type']) && $_GET['type'] == "walk in" && $_GET['p'] == "all") {
            	$q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'walk in' order by order_date ");
	            if (mysqli_num_rows($q) > 0) {
	            	while ($qq = mysqli_fetch_array($q)) {
	            	$order_id = $qq['order_id'];
	            	$user_id = $qq['user_id']; ?>
	            	<tr class="w3-text-black">
		              <td style="padding:10px"></td>
		              
		              <td class="w3-padding"><?php echo date("M d, Y", strtotime($qq['curr_order_date'])) ?></td>
		              <?php  
		              $z = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id' ");
		              $zz = mysqli_fetch_array($z);

		              $x = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id ='".$zz['bd_id']."' ");
		              $xx = mysqli_fetch_array($x);
		              ?>
		              <td class="w3-padding">P <?php echo $qq['order_amount'] ?></td>
		              <td class="w3-padding"><?php echo $qq['status'] ?></td>
		            </tr>
	            	<?php
	            	}
	            }	
            } 
            ?>
        </table>
	</div>
	<?php
}
	?>
	
	//
</body>
</html>