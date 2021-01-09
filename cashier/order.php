<?php
  include '../includes/connect.php';
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style>

  .button-group select, .button-group input, .button-group button{
    float:left;
    margin-right:5px;
    padding:6px 8px;
    height:40px;

  }
  .button-group{
    height:40px;
  }
  .button-group input{
    margin-left:10px;
  }
  p.btn{
    cursor: default;
  }

    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page w3-margin-bottom">
        <div class="tabs" style="margin-top:-10px;">
          <h3 class="w3-padding w3-text-grey">
            <?php
                if (isset($_GET['type']) && $_GET['type'] == "dinein") {//die-in
                  echo "Dine-in Order ";

                  $f = mysqli_query($conn,"SELECT COUNT(status) as pendingCount, status from food_order where order_type='dinein' and status='pending' ");
                  $ff = mysqli_fetch_array($f);
                  echo "<p class='w3-medium btn btn-default'>".$ff['pendingCount']." Pending</p><span class='w3-medium w3-padding-small'>|</span>";

                  $d = mysqli_query($conn,"SELECT COUNT(status) as pendingCount, status from food_order where order_type='dinein' and status='approve' ");
                  $dd = mysqli_fetch_array($d);
                  echo "<p class='w3-medium btn btn-default'>".$dd['pendingCount']." Approve</p><span class='w3-medium w3-padding-small'>|</span>";

                  $h = mysqli_query($conn,"SELECT COUNT(status) as pendingCount, status from food_order where order_type='dinein' and status='cancel' ");
                  $hh = mysqli_fetch_array($h);
                  echo "<p class='w3-medium btn btn-default'>".$hh['pendingCount']." Cancel</p><span class='w3-medium w3-padding-small'>|</span>";

                  $all = mysqli_query($conn,"SELECT COUNT(status) as pendingCount, status from food_order where order_type='dinein'");
                  $aall = mysqli_fetch_array($all);
                  echo "<p class='w3-medium btn btn-default'>".$aall['pendingCount']." All";

                } elseif (isset($_GET['type']) && $_GET['type'] == "delivery") { //delivery
                  echo "Delivery Order ";

                  $f = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='delivery' and status='pending' ");
                  $ff = mysqli_fetch_array($f);
                  echo "<p class='w3-medium btn btn-default'>".$ff['pendingCount']." Pending</p><span class='w3-medium w3-padding-small'>|</span>";

                  $d = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='delivery' and status='approve' ");
                  $dd = mysqli_fetch_array($d);
                  echo "<p class='w3-medium btn btn-default'>".$dd['pendingCount']." Approve</p><span class='w3-medium w3-padding-small'>|</span>";

                  $h = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='delivery' and status='cancel' ");
                  $hh = mysqli_fetch_array($h);
                  echo "<p class='w3-medium btn btn-default'>".$hh['pendingCount']." Cancel</p><span class='w3-medium w3-padding-small'>|</span>";

                  $all = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='delivery'");
                  $aall = mysqli_fetch_array($all);
                  echo "<p class='w3-medium btn btn-default'>".$aall['pendingCount']." All";



                } elseif (isset($_GET['type']) && $_GET['type'] == "pickup") {//pick up
                  echo "Pick up Order ";

                  $f = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='pickup' and status='pending' ");
                  $ff = mysqli_fetch_array($f);
                  echo "<p class='w3-medium btn btn-default'>".$ff['pendingCount']." Pending</p><span class='w3-medium w3-padding-small'>|</span>";

                  $d = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='pickup' and status='approve' ");
                  $dd = mysqli_fetch_array($d);
                  echo "<p class='w3-medium btn btn-default'>".$dd['pendingCount']." Approve</p><span class='w3-medium w3-padding-small'>|</span>";

                  $h = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='pickup' and status='cancel' ");
                  $hh = mysqli_fetch_array($h);
                  echo "<p class='w3-medium btn btn-default'>".$hh['pendingCount']." Cancel</p><span class='w3-medium w3-padding-small'>|</span>";

                  $all = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='pickup'");
                  $aall = mysqli_fetch_array($all);
                  echo "<p class='w3-medium btn btn-default'>".$aall['pendingCount']." All";

                } elseif(isset($_GET['type']) && $_GET['type'] == "takeout") {// take out
                  echo "Take out Order ";

                  $f = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='takeout' and status='pending' ");
                  $ff = mysqli_fetch_array($f);
                  echo "<p class='w3-medium btn btn-default'>".$ff['pendingCount']." Pending</p><span class='w3-medium w3-padding-small'>|</span>";

                  $d = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='takeout' and status='approve' ");
                  $dd = mysqli_fetch_array($d);
                  echo "<p class='w3-medium btn btn-default'>".$dd['pendingCount']." Approve</p><span class='w3-medium w3-padding-small'>|</span>";

                  $h = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='takeout' and status='cancel' ");
                  $hh = mysqli_fetch_array($h);
                  echo "<p class='w3-medium btn btn-default'>".$hh['pendingCount']." Cancel</p><span class='w3-medium w3-padding-small'>|</span>";

                  $all = mysqli_query($conn,"SELECT COUNT(status) as pendingCount from food_order where order_type='takeout'");
                  $aall = mysqli_fetch_array($all);
                  echo "<p class='w3-medium btn btn-default'>".$aall['pendingCount']." All";
                }
            ?>
          </h3>

          <div class="button-group">
            <?php
                if (isset($_GET['type']) && $_GET['type'] == "dinein") {
                  echo '
                    <select class="w3-select w3-border change_dinein w3-left w3-border-blue w3-text-black w3-round" style="width:200px;">
                      <option value="">--Select status--</option>
                      <option value="approve">Approved</option>
                      <option value="cancel">Cancelled</option>
                      <option value="pending">Pending</option>
                    </select>

                    <input type="text" id="datesasaass" class="w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="Dine-in date" style="margin-left:25px">
                    <button type="submit" id="submit_dine" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Search</button>
                  ';
                } elseif (isset($_GET['type']) && $_GET['type'] == "delivery") {
                  echo '
                    <select class="w3-select w3-border change_delivery w3-left w3-border-blue w3-text-black w3-round" style="width:200px;">
                      <option value="">--Select status--</option>
                      <option value="approve">Approved</option>
                      <option value="cancel">Cancelled</option>
                      <option value="pending">Pending</option>
                    </select>

                    <input type="text" id="datesasaass" class="w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="Delivery date" style="margin-left:25px">
                  <button type="submit" id="submit_deli" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Search</button>
                  ';
                } elseif (isset($_GET['type']) && $_GET['type'] == "pickup") {
                  echo '
                    <select class="w3-select w3-border change_pickup w3-left w3-border-blue w3-text-black w3-round" style="width:200px;">
                      <option value="">--Select status--</option>
                      <option value="approve">Approved</option>
                      <option value="cancel">Cancelled</option>
                      <option value="pending">Pending</option>
                    </select>

                    <input type="text" id="datesasaass" class="w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="Pick up date" style="margin-left:25px">
                    <button type="submit" id="submit_pick" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Search</button>
                  ';
                } elseif(isset($_GET['type']) && $_GET['type'] == "takeout") {
                  echo '
                    <select class="w3-select w3-border change_takeout w3-left w3-border-blue w3-text-black w3-round" style="width:200px;">
                      <option value="">--Select status--</option>
                      <option value="approve">Approved</option>
                      <option value="cancel">Cancelled</option>
                      <option value="pending">Pending</option>
                    </select>

                    <input type="text" id="datesasaass" class="w3-left w3-border-blue w3-border w3-text-grey w3-round" placeholder="Take out date" style="margin-left:25px">
                    <button type="submit" id="submit_take" class="w3-left w3-btn w3-border w3-blue w3-round w3-border-blue">Search</button>
                  ';
                }
            ?>
            <a href="addFoodToCart.php"><button class="w3-btn w3-text-blue w3-border w3-border-blue w3-hover-blue w3-transparent w3-right"><i class="fas fa-plus"></i> Add Order</button></a>
            <button class="w3-btn w3-blue w3-right"><i class="fas fa-print"></i> Print</button>
            
          </div>

          <div class="w3-margin-top">
            <table class="w3-border w3-text-grey" id="table__ble">
              <tr class="w3-border w3-text-blue">
                <td class="w3-padding-medium">Date Ordered</td>
                <td>Total Item</td>
                <td>Total Amount</td>
                <td>
                <?php
                if (isset($_GET['type']) && $_GET['type'] == "dinein") {
                  echo "Dine-in";
                } elseif (isset($_GET['type']) && $_GET['type'] == "delivery") {
                  echo "Delivery";
                } elseif (isset($_GET['type']) && $_GET['type'] == "pickup") {
                  echo "Pick up";
                } elseif(isset($_GET['type']) && $_GET['type'] == "takeout") {
                  echo "Take out";
                }
                ?> Date
                </td>
                <td>Status</td>
                <td align="center" style="padding-right:5px;">Action</td>
              </tr>
                <?php
                if (isset($_GET['type']) && $_GET['type'] == "dinein") {

                 $sql = mysqli_query($conn,"SELECT * FROM food_order where order_type = '".$_GET['type']."' ORDER BY order_date and status");
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
                            <a href="order_view.php?id=<?php echo $row['order_id'] ?>">
                              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                                <i class="fas fa-eye"></i>
                              </button>
                            </a>
                            <?php
                            $now = date("Y-m-d");
                            if ($row['status'] == "approve" || $row['status'] == "cancel") {
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
                      <tr>
                        <td colspan="6" align="center" class="w3-padding">Nothing Dine-in orders!</td>
                      </tr>
                    ';
                  }
                } elseif (isset($_GET['type']) && $_GET['type'] == "delivery") {

                 $sql = mysqli_query($conn,"SELECT * FROM food_order where order_type = '".$_GET['type']."' ORDER BY order_date and status ");
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
                            <a href="order_view.php?id=<?php echo $row['order_id'] ?>">
                              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                                <i class="fas fa-eye"></i>
                              </button>
                            </a>
                            <?php
                            $now = date("Y-m-d");
                            if ($row['status'] == "approve" || $row['status'] == "cancel") {
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
                      <tr>
                        <td colspan="6" align="center" class="w3-padding">Nothing Delivery orders!</td>
                      </tr>
                    ';
                  }
                } elseif (isset($_GET['type']) && $_GET['type'] == "pickup") {

                 $sql = mysqli_query($conn,"SELECT * FROM food_order where order_type = '".$_GET['type']."' ORDER BY order_date and status");
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
                            <a href="order_view.php?id=<?php echo $row['order_id'] ?>">
                              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                                <i class="fas fa-eye"></i>
                              </button>
                            </a>
                            <?php
                            $now = date("Y-m-d");
                            if ($row['status'] == "approve" || $row['status'] == "cancel") {
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
                      <tr>
                        <td colspan="6" align="center" class="w3-padding">Nothing Pick up orders!</td>
                      </tr>
                    ';
                  }
                } elseif (isset($_GET['type']) && $_GET['type'] == "takeout") {

                 $sql = mysqli_query($conn,"SELECT * FROM food_order where order_type = '".$_GET['type']."' ORDER BY order_date and status");
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
                            <a href="order_view.php?id=<?php echo $row['order_id'] ?>">
                              <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:40px;margin-right:3px;width:40px">
                                <i class="fas fa-eye"></i>
                              </button>
                            </a>
                            <?php
                            $now = date("Y-m-d");
                            if ($row['status'] == "approve" || $row['status'] == "cancel") {
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
                      <tr>
                        <td colspan="6" align="center" class="w3-padding">Nothing Take out orders!</td>
                      </tr>
                    ';
                  }
                }
                ?>
          </table>
          </div>
        </div>
      </div>
    </div>



    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>


      $(document).ready(function(){
        $("#datesasaass").datepicker();
        $(".change_dinein").change(function(){
          var value1 = $(this).val();
          if (value1 == "") {
            alert("Please select to search.");
            location.reload();
          } else {
            $.ajax({
            url: "include/order.change.inc.php",
            method: "POST",
            data: {value1: value1},
            success: function(data) {
              $("#table__ble").html(data);
              }
            });
          }
        });

         $(".change_delivery").change(function(){
          var value2 = $(this).val();
            $.ajax({
              url: "include/order.change.inc.php",
              method: "POST",
              data: {value2: value2},
              success: function(data) {
                $("#table__ble").html(data);
              }
            });
        });

        $(".change_pickup").change(function(){
          var value3 = $(this).val();
          if (value3 == "") {
            alert("Please select to search.");
            location.reload();
          } else {
            $.ajax({
            url: "include/order.change.inc.php",
            method: "POST",
            data: {value3: value3},
            success: function(data) {
              $("#table__ble").html(data);
              }
            });
          }
        });

       $(".change_takeout").change(function(){
        var value4 = $(this).val();
        if (value4 == "") {
          alert("Please select to search.");
          location.reload();
        } else {
          $.ajax({
          url: "include/order.change.inc.php",
          method: "POST",
          data: {value4: value4},
          success: function(data) {
            $("#table__ble").html(data);
            }
          });
        }
      });

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
            success: function(data){

              if (data == "Deleted") {
                location.reload();
              }
            }

          });

        }

      });

      // Order search with 2 input fields!!
      $("#submit_dine").click(function(){
        var submit_dine = $(this).val();
        var inputDate = $("#datesasaass").val();
        var status = $(".change_dinein").val();
        if (inputDate == "" && status == "") {
          alert("Nothing to search.");
          location.reload();
        } else {
          $.ajax({
            url: "include/order_search.inc.php",
            method: "POST",
            data: {
              submit_dine: submit_dine,
              inputDate: inputDate,
              status: status
            },
            success: function(data){
              $("#table__ble").html(data);
            }
          });
        }
      });


      $("#submit_deli").click(function(){
        var submit_deli = $(this).val();
        var inputDate = $("#datesasaass").val();
        var status = $(".change_delivery").val();
        if (inputDate == "" && status == "") {
          alert("Nothing to search.");
          location.reload();
        } else {
          $.ajax({
            url: "include/order_search.inc.php",
            method: "POST",
            data: {
              submit_deli: submit_deli,
              inputDate: inputDate,
              status: status
            },
            success: function(data){
              $("#table__ble").html(data);
            }
          });
        }
      });

       $("#submit_pick").click(function(){
        var submit_pick = $(this).val();
        var inputDate = $("#datesasaass").val();
        var status = $(".change_pickup").val();
        if (inputDate == "" && status == "") {
          alert("Nothing to search.");
          location.reload();
        } else {
          $.ajax({
            url: "include/order_search.inc.php",
            method: "POST",
            data: {
              submit_pick: submit_pick,
              inputDate: inputDate,
              status: status
            },
            success: function(data){
              $("#table__ble").html(data);
            }
          });
        }
      });

      $("#submit_take").click(function(){
        var submit_take = $(this).val();
        var inputDate = $("#datesasaass").val();
        var status = $(".change_takeout").val();
        if (inputDate == "" && status == "") {
          alert("Nothing to search.");
          location.reload();
        } else {
          $.ajax({
            url: "include/order_search.inc.php",
            method: "POST",
            data: {
              submit_take: submit_take,
              inputDate: inputDate,
              status: status
            },
            success: function(data){
              $("#table__ble").html(data);
            }
          });
        }
      });
      });
    </script>
  </body>
</html>