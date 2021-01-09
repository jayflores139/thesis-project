<?php
  include '../includes/connect.php';
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

$b = mysqli_query($conn,"SELECT * FROM dis_senior");
$bb = mysqli_fetch_array($b);

$today = date('Y-m-d');

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
  .w3-left button{
    margin-right:3px;
  }
  .w3-right button{
    margin-left:3px;
  }

    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page w3-margin-bottom">

        <?php  
        if (isset($_GET['type'])) {
          if ($_GET['type'] == "delivery") { ?>
            <div>
              <div class="tabs" style="margin-top:-10px;">
                <div class="w3-left">
              <?php
              echo "Delivery Order <br>";

                  $v = mysqli_query($conn,"SELECT count(order_id) as a FROM food_order where order_type = 'delivery' ");
                  while ($vv = mysqli_fetch_array($v)) { ?>
                   <button class="w3-left btn btn-default all"> <span><?php echo $vv['a'] ?></span> All</button>
                   <?php
                  }

                  $q = mysqli_query($conn,"SELECT count(order_id) as pending FROM food_order where order_type = 'delivery' and status='pending' ");
                  while ($qq = mysqli_fetch_array($q)) { ?>
                   <button class="w3-left btn btn-default pending" id="pending"> <span><?php echo $qq['pending'] ?></span> Pending</button>
                   <?php
                  }
                    $w = mysqli_query($conn,"SELECT count(order_id) as approve FROM food_order where order_type = 'delivery' and status='approve' ");
                  while ($ww = mysqli_fetch_array($w)) { ?>
                   <button class="w3-left btn btn-default approve" id="approve"> <span><?php echo $ww['approve'] ?></span> Confirmed</button>
                   <?php
                  }
                   $e = mysqli_query($conn,"SELECT count(order_id) as cancel FROM food_order where order_type = 'delivery' and status='cancel' ");
                  while ($ee = mysqli_fetch_array($e)) { ?>
                   <button class="w3-left btn btn-default cancel" id="cancel"> <span><?php echo $ee['cancel'] ?></span> Cancelled</button>
                   <?php
                  }

                    ?>

                      <form class="form_search w3-left">
                        <input type="text" class="form-control w3-left search_input" required placeholder="Delivery date" style="width:200px;margin-left:10px;margin-right:2px">
                        <button class="w3-left btn btn-default submit">Search</button>
                        <?php $today = date('Y-m-d') ?>
                        <button type="button" class="btn btn-default w3-light-grey today_delivery" id="<?php echo $today ?>">Today's delivery</button>
                      </form>
                    </div>

                    <div class="w3-right">
                      <a href="addFoodToCart.php"><button class="btn btn-default w3-left"><i class="fas fa-plus"></i> Add Order</button></a>
                      <button class="btn btn-default w3-left" onclick="window.open('print.php?type=delivery&p=pending')"><i class="fas fa-print"></i> Print</button>
                    </div> <br><br>
                  <?php
                  
              ?>
              
        </div>

        <div class="w3-margin-top table-responsive order_content" id="printFields">
          <table class="w3-border w3-striped w3-medium">

            <tr class="w3-text-black">
              <td class="w3-padding w3-border"></td>
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Delivery Date / Time</td>
              <td class="w3-padding">Delivery Address</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'delivery' order by order_date ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) { 
                  echo '<td class="w3-padding w3-border"></td>';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                      
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                     
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <?php  
                    $d = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '".$qq['order_id']."' ");
                    $dd = mysqli_fetch_array($d);

                    $v = mysqli_query($conn,"SELECT * FROM barangay_delivery WHERE bd_id = '".$dd['bd_id']."' ");
                    $vv = mysqli_fetch_array($v); ?>
                    <td class="w3-padding"><?php echo $dd['house_street'].', '.$vv['barangay']; ?></td>

                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="7" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
        </div>
        </div>
        <?php
          } elseif ($_GET['type'] == "dinein") { ?>
          <div>
              <div class="tabs" style="margin-top:-10px;">
              <?php
                  
                    echo "Dine-in Order <br>"; ?>
                    <div class="w3-left">
                      <?php  

                      $q = mysqli_query($conn,"SELECT count(order_id) as a FROM food_order where order_type = 'dinein' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default all"> <span><?php echo $qq['a'] ?></span> All</button>
                      <?php
                      }
                      $q = mysqli_query($conn,"SELECT count(order_id) as pending FROM food_order where order_type = 'dinein' and status='pending' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default pendingdinein" id="pending"> <span><?php echo $qq['pending'] ?></span> Pending</button>
                      <?php
                      } 
                      $q = mysqli_query($conn,"SELECT count(order_id) as approve FROM food_order where order_type = 'dinein' and status='approve' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default approvedinein" id="approve"> <span><?php echo $qq['approve'] ?></span> Approved</button>
                      <?php
                      }
                      $q = mysqli_query($conn,"SELECT count(order_id) as cancel FROM food_order where order_type = 'dinein' and status='cancel' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default canceldinein" id="cancel"> <span><?php echo $qq['cancel'] ?></span> Cancelled</button>
                      <?php
                      }
                      ?>
                      <form class="form_searchdinein w3-left">
                        <input type="text" class="form-control w3-left search_inputdinein" required placeholder="Dine-in date" style="width:200px;margin-left:10px;margin-right:2px">
                        <button class="w3-left btn btn-default submitdinein">Search</button>
                        <?php $today = date('Y-m-d') ?>
                        <button type="button" class="btn btn-default w3-light-grey today_dinein" id="<?php echo $today ?>">Today's dine-in</button>
                      </form>
                    </div>

                    <div class="w3-right">
                      <a href="addFoodToCart.php"><button class="btn btn-default w3-left"><i class="fas fa-plus"></i> Add Order</button></a>
                      <button class="btn btn-default w3-left" onclick="window.open('print.php?type=dinein&p=pending')"><i class="fas fa-print"></i> Print</button>
                    </div> <br><br>
                  <?php
                  
              ?>
              
        </div>

        <div class="w3-margin-top table-responsive order_contentdinein" id="printFields">
          <table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Dine Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' order by order_date ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) {
                  echo '<tr class="reMove'.$qq['order_id'].'">';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
        </div>
        </div>
         <?php
          } elseif ($_GET['type'] == "pickup") { ?>
          <div>
              <div class="tabs" style="margin-top:-10px;">
              <?php
                  
                    echo "Pick up Order <br>"; ?>
                    <div class="w3-left">
                      <?php  

                      $q = mysqli_query($conn,"SELECT count(order_id) as a FROM food_order where order_type = 'pickup' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default all"> <span><?php echo $qq['a'] ?></span> All</button>
                      <?php
                      }
                      $q = mysqli_query($conn,"SELECT count(order_id) as pending FROM food_order where order_type = 'pickup' and status='pending' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default pendingpickup" id="pending"> <span><?php echo $qq['pending'] ?></span> Pending</button>
                      <?php
                      } 
                      $q = mysqli_query($conn,"SELECT count(order_id) as approve FROM food_order where order_type = 'pickup' and status='approve' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default approvepickup" id="approve"> <span><?php echo $qq['approve'] ?></span> Approved</button>
                      <?php
                      }
                      $q = mysqli_query($conn,"SELECT count(order_id) as cancel FROM food_order where order_type = 'pickup' and status='cancel' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default cancelpickup" id="cancel"> <span><?php echo $qq['cancel'] ?></span> Cancelled</button>
                      <?php
                      }
                      ?>
                      <form class="form_searchpickup w3-left">
                        <input type="text" class="form-control w3-left search_inputpickup" id="pickupDate" required placeholder="Search" style="width:200px;margin-left:10px;margin-right:2px">
                        <button class="w3-left btn btn-default submitpickup">Search</button>
                      </form>
                      <button class="btn btn-default w3-light-grey todays_Pickup" id="<?php echo $today ?>">Today's pick up</button>
                    </div>

                    <div class="w3-right">
                      <a href="addFoodToCart.php"><button class="btn btn-default w3-left"><i class="fas fa-plus"></i> Add Order</button></a>
                      <button class="btn btn-default w3-left" onclick="window.open('print.php?type=pickup&p=pending')"><i class="fas fa-print"></i> Print</button>
                    </div> <br><br>
                  <?php
                  
              ?>
              
        </div>

        <div class="w3-margin-top table-responsive order_contentpickup" id="printFields">
          <table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Pick up Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'pickup' ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) { 
                   echo '<tr class="reMove'.$qq['order_id'].'">';
                  ?>

                  <?php
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {

                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
        </div>
        </div>
         <?php
          } elseif ($_GET['type'] == "takeout") { ?>
          <div>
              <div class="tabs" style="margin-top:-10px;">
              <?php
                  
                    echo "Take out Order <br>"; ?>
                    <div class="w3-left">
                       <?php  

                      $q = mysqli_query($conn,"SELECT count(order_id) as a FROM food_order where order_type = 'takeout' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default all"> <span><?php echo $qq['a'] ?></span> All</button>
                      <?php
                      }
                      $q = mysqli_query($conn,"SELECT count(order_id) as pending FROM food_order where order_type = 'takeout' and status='pending' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default pendingtakeout" id="pending"> <span><?php echo $qq['pending'] ?></span> Pending</button>
                      <?php
                      } 
                      $q = mysqli_query($conn,"SELECT count(order_id) as approve FROM food_order where order_type = 'takeout' and status='approve' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default approvetakeout" id="approve"> <span><?php echo $qq['approve'] ?></span> Approved</button>
                      <?php
                      }
                      $q = mysqli_query($conn,"SELECT count(order_id) as cancel FROM food_order where order_type = 'takeout' and status='cancel' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default canceltakeout" id="cancel"> <span><?php echo $qq['cancel'] ?></span> Cancelled</button>
                      <?php
                      }
                      ?>

                      <form class="form_searchtakeout w3-left">
                        <input type="text" class="form-control w3-left search_inputtakeout" required placeholder="Search" style="width:200px;margin-left:10px;margin-right:2px">
                        <button class="w3-left btn btn-default submittakeout">Search</button>
                      </form>
                      <button class="w3-left btn btn-default w3-light-grey todaysTakeout" id="<?php echo $today ?>">Today's takeout</button>
                    </div>

                    <div class="w3-right">
                      <a href="addFoodToCart.php"><button class="btn btn-default w3-left"><i class="fas fa-plus"></i> Add Order</button></a>
                      <button class="btn btn-default w3-left" onclick="window.open('print.php?type=takeout&p=pending')"><i class="fas fa-print"></i> Print</button>
                    </div> <br><br>
                  <?php
                  
              ?>
              
        </div>

        <div class="w3-margin-top table-responsive order_content_takeout" id="printFields">
          <table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Take out Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'takeout' ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) { ?>

                  <tr style="color:#474242" class="reMove<?php echo $qq['order_id'] ?>">
                    <?php
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
        </div>
        </div>
         <?php
          } elseif ($_GET['type'] == "walk in") { ?>
          <div>
              <div class="tabs" style="margin-top:-10px;">
              <?php
                  
                    echo "Walk in Order <br>"; ?>
                    <div class="w3-left">
                      <?php  

                      $q = mysqli_query($conn,"SELECT count(order_id) as a FROM food_order where order_type = 'walk in' ");
                      while ($qq = mysqli_fetch_array($q)) { ?>
                      <button class="w3-left btn btn-default all"> <span><?php echo $qq['a'] ?></span> All</button>
                      <?php
                      }
                      ?>
                      <form class="form_searchwalk w3-left">
                        <input type="text" class="form-control w3-left search_inputwalk" autocomplete="off" required placeholder="Search date" style="width:200px;margin-right:2px">
                        <button class="w3-left btn btn-default submitwalk">Search</button>
                      </form>
                    </div>

                    <div class="w3-right">
                      <a href="addFoodToCart.php"><button class="btn btn-default w3-left"><i class="fas fa-plus"></i> Add Order</button></a>
                      <button class="btn btn-default w3-left" onclick="window.open('print.php?type=walk in&p=all')"><i class="fas fa-print"></i> Print</button>
                    </div> <br><br>
                  <?php
                  
              ?>
              
        </div>

        <div class="w3-margin-top table-responsive order_content" id="printFields">
          <table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Date</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'walk in' ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) { ?>

                  <tr style="color:#474242" class="reMove<?php echo $qq['order_id'] ?>">         
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['curr_order_date'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
        </div>
        </div>
         <?php
          }
        }
        if (isset($_GET['i'])) { 
          $order_id = $_GET['i'];
          $_SESSION['order_id'] = $order_id;
          ?>
          <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Order Detail</a></li>
            <li><a href="#tabs-2">Client Detail</a></li>
          </ul>
          <div id="tabs-1">
            <fieldset class="w3-margin-bottom">
              <legend class="w3-black w3-round" style="width:auto;padding:0 25px;margin:0;font-size:16px">Order Details</legend>
              <table class="w3-center">
                <?php  
                  $q = mysqli_query($conn,"SELECT * FROM food_order where order_id = '".$_GET['i']."' ");
                  while ($qq = mysqli_fetch_array($q)) { ?>
              <tr>
                <td class="w3-padding-small">Date Ordered: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo date("M d, Y", strtotime($qq['curr_order_date'])) ?>"></td>

                <?php  
              $w = mysqli_query($conn,"SELECT food_order_details.food_qty, food_menu.price, food_menu.food_name, food_menu.photo from food_order_details inner join food_menu where food_order_details.food_id=food_menu.food_id and food_order_details.order_id='".$_GET['i']."' ");
              $t = 0;
              while ($ww = mysqli_fetch_array($w)) {
                $t += $ww['price'] * $ww['food_qty'];
              } 
              $e = mysqli_query($conn,"SELECT barangay_delivery.deliv_charge FROM barangay_delivery inner join delivery_detail where barangay_delivery.bd_id=delivery_detail.bd_id and delivery_detail.order_id='".$qq['order_id']."' ");
                  $ee = mysqli_fetch_array($e);
              ?>
                <td class="w3-padding-small">Sub total: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo number_format($t + $ee['deliv_charge'],2) ?>"></td>
              </tr>
              <tr>
                <?php
                if ($qq['order_type'] == "delivery") { ?>

                <td class="w3-padding-small">Delivery date / time: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?>"></td>
                  <?php
                  } elseif ($qq['order_type'] == "dinein") { ?>

                <td class="w3-padding-small">Dine-in date / time: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?>"></td>
                  <?php
                  } elseif ($qq['order_type'] == "pickup") { ?>

                <td class="w3-padding-small">Pick up date / time: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?>"></td>
                  <?php
                  } elseif ($qq['order_type'] == "takeout") { ?>

                <td class="w3-padding-small">Take out date / time: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo date("M d, Y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?>"></td>
                  <?php
                  }
                  if ($qq['customer_type'] == "senior") { ?>
                  <td class="w3-padding-small">Discount: </td>
                  <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo $bb['discount'] * 100 ?>%"></td>
                   <?php    
                     } elseif ($qq['customer_type'] == "junior") { ?>
                  <td class="w3-padding-small">Discount: </td>
                  <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="0%"></td>
                    <?php
                     }
                ?>

              </tr>
              <?php   
                if ($qq['order_type'] == "delivery") {
                  $d = mysqli_query($conn,"SELECT * FROM delivery_detail WHERE order_id = '$order_id ' ");
                  $dd = mysqli_fetch_array($d);

                  $v = mysqli_query($conn,"SELECT * FROM barangay_delivery WHERE bd_id = '".$dd['bd_id']."' ");
                  $vv = mysqli_fetch_array($v); ?>
                  <tr>            
                    <td class="w3-padding-small">Delivery Charge: </td>
                    <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo $ee['deliv_charge'] ?>"></td>
                  </tr>
                  <tr>
                    <td class="w3-padding-small">Delivery address</td>
                    <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo $dd['house_street'].', '.$vv['barangay'] ?>"></td>
                  </tr>
                <?php
                }
              ?>
              <tr>
                <td class="w3-padding-small">Status</td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo $qq['status'] ?>"></td>
                <td class="w3-padding-small">Total: </td>
                <td class="w3-padding-small"><input type="text" disabled class="w3-input w3-border" value="<?php echo number_format($qq['order_amount'],2) ?>"></td>
              </tr>
              <tr>
                <td class="w3-padding-small">
                </td>
                <td class="w3-padding-small">
                  <?php  
                  if ($qq['status'] == "pending") { ?>
                  <a href="place_order.php?t=t&p=<?php echo $qq['order_amount'] ?>&id=<?php echo $_GET['i'] ?>">
                    <button class="btn btn-info">Add payment</button>
                  </a>         
                  <button class="btn btn-danger cancel_order" id="<?php echo $_GET['i'] ?>">Cancel order</button>
                  <?php
                  }
                  ?>         
                </td>
              </tr>
            </table>
            </fieldset>
            <fieldset class="w3-center">
              <legend class="w3-black w3-round" style="text-align:left;width:auto;padding:0 25px;margin:0;font-size:16px">Order Item</legend>
              <input type="hidden" id="order_id<?php echo $_SESSION['order_id'] ?>" value="<?php echo $_SESSION['order_id'] ?>" >
              <button class="btn btn-default save_first_order" id="<?php echo $_SESSION['order_id'] ?>"">Edit Food Order <i class="fas fa-pencil-alt"></i></button><br><br>
              <table class="w3-center">
              <tr class="w3-text-grey">
                <td class="w3-padding-small">Image</td>
                <td class="w3-padding-small">Food Name</td>
                <td class="w3-padding-small">Price</td>
                <td class="w3-padding-small">Qty</td>
                <td class="w3-padding-small">Total</td>
              </tr>
              <?php  
              $w = mysqli_query($conn,"SELECT food_order_details.food_qty, food_menu.price, food_menu.food_name, food_menu.photo from food_order_details inner join food_menu where food_order_details.food_id=food_menu.food_id and food_order_details.order_id='".$_GET['i']."' ");
              while ($ww = mysqli_fetch_array($w)) { ?>
                <tr>
                <td class="w3-padding-small"><img src="../food_images/<?php echo $ww['photo'] ?>" style="margin:10px;height: 60px;width:60px"></td>
                <td class="w3-padding-small"><?php echo $ww['food_name'] ?></td>
                <td class="w3-padding-small">P <?php echo number_format($ww['price'],2) ?></td>
                <td class="w3-padding-small"><?php echo $ww['food_qty'] ?></td>
                <td class="w3-padding-small">P <?php echo number_format($ww['food_qty'] * $ww['price'],2) ?></td>
              </tr>
              <?php
              }
              ?>
            </table>
            </fieldset>
                  <?php
                  }
                ?>
          </div>
          <div id="tabs-2">
            <div class="col-md-6" style="float: none">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '$order_id' ");
                  if (mysqli_num_rows($w) > 0) {  
                    while ($ww = mysqli_fetch_array($w)) { ?>
                     <table>
                        <tr>
                          <td class="w3-padding-small">Name</td>
                          <td class="w3-padding-small">
                            <div class="w3-input w3-border w3-light-grey"><?php echo $ww['p_to_pick'] ?></div>
                          </td>
                        </tr>
                        <tr>
                          <td class="w3-padding-small">Contact #</td>
                          <td class="w3-padding-small">
                            <div class="w3-input w3-border w3-light-grey"><?php echo $ww['contact'] ?></div>
                          </td>
                        </tr>
                      </table>

                  <?php
                    }
                  } else {
                    $thesis2019 = mysqli_query($conn,"SELECT * FROM food_order where order_id = '$order_id' ");
                    $tt = mysqli_fetch_array($thesis2019);

                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$tt['user_id']."' ");
                    $users = mysqli_fetch_array($user); ?>
                    <table>
                      <tr>
                        <td class="w3-padding-small">Name</td>
                        <td class="w3-padding-small">
                          <div class="w3-input w3-border w3-light-grey"><?php echo $users['firstname'].' '.$users['lastname'] ?></div>
                        </td>
                      </tr>

                      <tr>
                        <td class="w3-padding-small">Contact #</td>
                        <td class="w3-padding-small">
                          <div class="w3-input w3-border w3-light-grey"><?php echo $users['contact'] ?></div>
                        </td>
                      </tr>

                      <tr>
                        <td class="w3-padding-small">Email</td>
                        <td class="w3-padding-small">
                          <div class="w3-input w3-border w3-light-grey"><?php echo $users['email'] ?></div>
                        </td>
                      </tr>

                      <tr>
                        <td class="w3-padding-small">Address</td>
                        <td class="w3-padding-small">
                          <div class="w3-input w3-border w3-light-grey"><?php echo $users['address'] ?></div>
                        </td>
                      </tr>
                    </table>
                 <?php   
                  }
              ?>
            </div>
          </div>
          
        </div>
         <?php  
         } 
        ?>


        <!--//!-->
        <!--//!-->

        </div>
      </div>
    </div>



    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $(".search_inputwalk").datepicker();
      $( "#tabs" ).tabs();
      $(".search_input").datepicker();
      $("#pickupDate").datepicker();
      $(".search_inputdinein, .search_inputtakeout").datepicker();

      $(document).ready(function(){

        $(".save_first_order").click(function(){
          var save_first_order = $(this).attr("id");
          var order_id = $("#order_id"+save_first_order).val();
          
          $.ajax({
            url: "include/old_order_save.php",
            method: "POST",
            data: {
              save_first_order: save_first_order,
              order_id: order_id
            },
            success: function(data){
              if (data == "InsertedWithSelect") {
                window.location="new_order.php?i="+order_id;
              }
            }
          });
        });

        $(".cancel_order").click(function(){

          var order_id = $(this).attr("id");
          if (confirm("Are you sure you want to cancel this order?") == true) {
            $.ajax({
              url: "include/cancel_order.php",
              method: "POST",
              data: {
                order_id: order_id
              },
              success: function(d) {
                if (d == "Cancel") {
                  location.reload();
                }
              }
            });
          }
        });

        $(".today_delivery").click(function(){
          var today_delivery = $(this).attr("id");

          $.ajax({
            url: "include/search_order.php",
            method: "POST",
            data: {
              today_delivery: today_delivery
            },
            success:function(data){
              $(".order_content").html(data);
            }
          }); 
        });
        $(".todays_Pickup").click(function(){
          var todays_Pickup = $(this).attr("id");
          $.ajax({
            url: "include/search_orderPick.php",
            method: "POST",
            data: {
              todays_Pickup: todays_Pickup
            },
            success: function(data) {
              $(".order_contentpickup").html(data);
            }
          });
        });
        $(".today_dinein").click(function(){
          var today_dinein = $(this).attr("id");
          $.ajax({
            url: "include/search_orderDine.php",
            method: "POST",
            data: {
              today_dinein: today_dinein
            },
            success: function(data) {
              $(".order_contentdinein").html(data);
            }
          });
        });
        $(".todaysTakeout").click(function(){
          var todaysTakeout = $(this).attr("id");
          $.ajax({
            url: "include/search_orderTake.php",
            method: "POST",
            data: {
              todaysTakeout: todaysTakeout
            },
            success: function(data) {
              $(".order_content_takeout").html(data);
            }
          });
        });

      });

    </script>
    <script type="text/javascript" src="css/deliveryJS.js"></script>
    <script type="text/javascript" src="css/dineInJS.js"></script>
    <script type="text/javascript" src="css/pickUpJS.js"></script>
    <script type="text/javascript" src="css/takeoutJS.js"></script>
    <script type="text/javascript" src="css/walkinJS.js"></script>

  </body>
</html>