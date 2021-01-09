<?php
include '../../includes/connect.php';
if (isset($_POST['value1'])) {
	$status = $_POST['value1'];

	echo '

	<tr class="w3-border w3-text-blue">
	    <td class="w3-padding-medium">Date Ordered</td>
	    <td>Total Item</td>
	    <td>Total Amount</td>
	    <td> Dine-in Date </td>
	    <td>Status</td>
	    <td align="center" style="padding-right:5px;">Action</td>
	</tr>

	';

$sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_type = 'dinein' ORDER BY order_date");
  if (mysqli_num_rows($sql) > 0) {

    while ($row = mysqli_fetch_array($sql)) { ?>

      <tr class="w3-border w3-text-black">
        <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($row['curr_order_date'])); ?></td>
        <?php
        $w = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '".$row['order_id']."'");
        $tal = 0;
        while ($ww = mysqli_fetch_array($w)) {
          $tal = $tal + $ww['food_qty'];
        }
        ?>
        <td><?php echo $tal ?> item/s</td>
        <td>P <?php echo number_format($row['order_amount'],2) ?></td>
        <td><?php echo date("M d, Y", strtotime($row['order_date'])); ?></td>
        <td><?php echo $row['status'] ?></td>
        <td>
          <div class="w3-right" style="margin:3px;">
            <a href="order_view.php?id=<?php echo $row['order_id'] ?>&typeo=dinein">
              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                <i class="fas fa-eye"></i>
              </button>
            </a>
          </div>
        </td>
      </tr>
<?php
    }
  } else {
    echo '
      <tr>
        <td colspan="6" align="center" class="w3-padding">No '.$status.' Dine-in Orders!</td>
      </tr>
    ';
  }
}




if (isset($_POST['value2'])) {
	$status = $_POST['value2'];

	echo '

	<tr class="w3-border w3-text-blue">
	    <td class="w3-padding-medium">Date Ordered</td>
	    <td>Total Item</td>
	    <td>Total Amount</td>
	    <td> Delivery Date </td>
	    <td>Status</td>
	    <td align="center" style="padding-right:5px;">Action</td>
	</tr>

	';

$sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_type = 'delivery' ORDER BY order_date");
  if (mysqli_num_rows($sql) > 0) {

    while ($row = mysqli_fetch_array($sql)) { ?>

      <tr class="w3-border w3-text-black">
        <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($row['curr_order_date'])); ?></td>
        <?php
        $w = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '".$row['order_id']."'");
        $tal = 0;
        while ($ww = mysqli_fetch_array($w)) {
          $tal = $tal + $ww['food_qty'];
        }
        ?>
        <td><?php echo $tal ?> item/s</td>
        <td>P <?php echo number_format($row['order_amount'],2) ?></td>
        <td><?php echo date("M d, Y", strtotime($row['order_date'])); ?></td>
        <td><?php echo $row['status'] ?></td>
        <td>
          <div class="w3-right" style="margin:3px;">
            <a href="order_view.php?id=<?php echo $row['order_id'] ?>&typeo=delivery">
              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                <i class="fas fa-eye"></i>
              </button>
            </a>
          </div>
        </td>
      </tr>
<?php
    }
  } else {
    echo '
      <tr>
        <td colspan="6" align="center" class="w3-padding">No '.$status.' Delivery Orders!</td>
      </tr>
    ';
  }
}




if (isset($_POST['value3'])) {
	$status = $_POST['value3'];

	echo '

	<tr class="w3-border w3-text-blue">
	    <td class="w3-padding-medium">Date Ordered</td>
	    <td>Total Item</td>
	    <td>Total Amount</td>
	    <td> Pick up Date </td>
	    <td>Status</td>
	    <td align="center" style="padding-right:5px;">Action</td>
	</tr>

	';

$sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_type = 'pickup' ORDER BY order_date");
  if (mysqli_num_rows($sql) > 0) {

    while ($row = mysqli_fetch_array($sql)) { ?>

      <tr class="w3-border w3-text-black">
        <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($row['curr_order_date'])); ?></td>
        <?php
        $w = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '".$row['order_id']."'");
        $tal = 0;
        while ($ww = mysqli_fetch_array($w)) {
          $tal = $tal + $ww['food_qty'];
        }
        ?>
        <td><?php echo $tal ?> item/s</td>
        <td>P <?php echo number_format($row['order_amount'],2) ?></td>
        <td><?php echo date("M d, Y", strtotime($row['order_date'])); ?></td>
        <td><?php echo $row['status'] ?></td>
        <td>
          <div class="w3-right" style="margin:3px;">
            <a href="order_view.php?id=<?php echo $row['order_id'] ?>&typeo=pickup">
              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width: 40px">
                <i class="fas fa-eye"></i>
              </button>
            </a>
          </div>
        </td>
      </tr>
<?php
    }
  } else {
    echo '
      <tr>
        <td colspan="6" align="center" class="w3-padding">No '.$status.' Pick up Orders!</td>
      </tr>
    ';
  }
}





if (isset($_POST['value4'])) {
	$status = $_POST['value4'];

	echo '

	<tr class="w3-border w3-text-blue">
	    <td class="w3-padding-medium">Date Ordered</td>
	    <td>Total Item</td>
	    <td>Total Amount</td>
	    <td> Take out Date </td>
	    <td>Status</td>
	    <td align="center" style="padding-right:5px;">Action</td>
	</tr>

	';

$sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_type = 'takeout' ORDER BY order_date");
  if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_array($sql)) { ?>

      <tr class="w3-border w3-text-black">
        <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($row['curr_order_date'])); ?></td>
        <?php
        $w = mysqli_query($conn,"SELECT * FROM food_order_details where order_id = '".$row['order_id']."'");
        $tal = 0;
        while ($ww = mysqli_fetch_array($w)) {
          $tal = $tal + $ww['food_qty'];
        }
        ?>
        <td><?php echo $tal ?> item/s</td>
        <td>P <?php echo number_format($row['order_amount'],2) ?></td>
        <td><?php echo date("M d, Y", strtotime($row['order_date'])); ?></td>
        <td><?php echo $row['status'] ?></td>
        <td>
          <div class="w3-right" style="margin:3px;">
            <a href="order_view.php?id=<?php echo $row['order_id'] ?>&typeo=takeout">
              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                <i class="fas fa-eye"></i>
              </button>
            </a>
          </div>
        </td>
      </tr>
<?php
    }
  } else {
    echo '
      <tr>
        <td colspan="6" align="center" class="w3-padding">No '.$status.' Take out Orders!</td>
      </tr>
    ';
  }
}

?>
