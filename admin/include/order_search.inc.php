<?php
include '../../includes/connect.php';

if (isset($_POST['submit_dine'])) {

  $inputDate = $_POST['inputDate'];
  $status = $_POST['status'];

  $inputDATE = date("Y-m-d", strtotime($inputDate));

  echo '
    <tr class="w3-border w3-text-blue">
      <td class="w3-padding-medium">Date Ordered</td>
      <td>Total Item</td>
      <td>Total Amount</td>
      <td>Dine-in Date
      </td>
      <td>Status</td>
      <td align="center" style="padding-right:5px;">Action</td>
    </tr>
  ' ;

  if (!empty($inputDate) && !empty($status)) {

    $sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_date='$inputDATE' and order_type='Dinein' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  } elseif (!empty($inputDate) && empty($status)) {
    $sql = mysqli_query($conn,"SELECT * FROM food_order where order_date='$inputDATE' and order_type='Dinein' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  }
} elseif (isset($_POST['submit_deli'])) {

  $inputDate = $_POST['inputDate'];
  $status = $_POST['status'];

  $inputDATE = date("Y-m-d", strtotime($inputDate));

  echo '
    <tr class="w3-border w3-text-blue">
      <td class="w3-padding-medium">Date Ordered</td>
      <td>Total Item</td>
      <td>Total Amount</td>
      <td>Delivery Date
      </td>
      <td>Status</td>
      <td align="center" style="padding-right:5px;">Action</td>
    </tr>
  ' ;

  if (!empty($inputDate) && !empty($status)) {

    $sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_date='$inputDATE' and order_type='Delivery' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  } elseif (!empty($inputDate) && empty($status)) {
    $sql = mysqli_query($conn,"SELECT * FROM food_order where order_date='$inputDATE' and order_type='Delivery' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  }
} elseif (isset($_POST['submit_pick'])) {

  $inputDate = $_POST['inputDate'];
  $status = $_POST['status'];

  $inputDATE = date("Y-m-d", strtotime($inputDate));

  echo '
    <tr class="w3-border w3-text-blue">
      <td class="w3-padding-medium">Date Ordered</td>
      <td>Total Item</td>
      <td>Total Amount</td>
      <td>Pick up Date
      </td>
      <td>Status</td>
      <td align="center" style="padding-right:5px;">Action</td>
    </tr>
  ' ;

  if (!empty($inputDate) && !empty($status)) {

    $sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_date='$inputDATE' and order_type='Pickup' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  } elseif (!empty($inputDate) && empty($status)) {
    $sql = mysqli_query($conn,"SELECT * FROM food_order where order_date='$inputDATE' and order_type='Pickup' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  }
} elseif (isset($_POST['submit_take'])) {

  $inputDate = $_POST['inputDate'];
  $status = $_POST['status'];

  $inputDATE = date("Y-m-d", strtotime($inputDate));

  echo '
    <tr class="w3-border w3-text-blue">
      <td class="w3-padding-medium">Date Ordered</td>
      <td>Total Item</td>
      <td>Total Amount</td>
      <td>Take out Date
      </td>
      <td>Status</td>
      <td align="center" style="padding-right:5px;">Action</td>
    </tr>
  ' ;

  if (!empty($inputDate) && !empty($status)) {

    $sql = mysqli_query($conn,"SELECT * FROM food_order where status = '$status' and order_date='$inputDATE' and order_type='Takeout' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  } elseif (!empty($inputDate) && empty($status)) {
    $sql = mysqli_query($conn,"SELECT * FROM food_order where order_date='$inputDATE' and order_type='Takeout' ORDER BY order_date");
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
              <?php
              $now = date("Y-m-d");
              if ($row['status'] == "Approve" || $row['status'] == "Cancel") {
                  echo '
                    <input type="hidden" id="order_id'.$row['order_id'].'" value="'.$row['order_id'].'">

                    <button id="'.$row['order_id'].'" class="delete w3-light-grey w3-left w3-border-0 w3-hover-grey" style="width:40px;height:40px;">
                      <i class="fas fa-trash-alt"></i>
                    </button>

                  ';
              }
              ?>
            </div>
          </td>
        </tr>
  <?php
      }
    } else {
      echo '
        <tr class="w3-border">
          <td class="w3-padding-medium w3-center" colspan="6">No orders found.</td>
        </tr>
      ';
    }
  }
}
?>

<script>

  $(document).ready(function(){
    $(".delete").click(function(){
      var id_order = $(this).attr("id");
      var hid_inpur = $("#order_id"+id_order).val();

      if (confirm("Are you sure?") == true) {
        $.ajax({
          url: "include/order_delete.inc.php",
          method: "POST",
          data: {
            hid_inpur: hid_inpur
          },
          success:function(data){
            if (data == "Deleted") {
              window.location.reload();
            }
          }
        });
      }

    });
  });

</script>
