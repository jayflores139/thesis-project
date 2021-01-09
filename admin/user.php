
 <?php
session_start();
  include '../includes/connect.php';
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>

    </script>
    <style>
        .action{
            opacity:0.8;
        }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed">
      <div class="search-con">
        <h2>Users</h2>
        <?php 
        if (!isset($_GET['view'])) { ?>
            <form>
              <input type="text" name="name" id="name" class="w3-border w3-border-blue" placeholder="Search..." autocomplete="off" class="w3-round" style="width:300px;margin-right:5px">
            </form>
        <?php
        } else { ?>
        <button class="btn btn-default w3-right" onclick="history.back()">back</button>
        <?php
        }
         ?>
      </div>

      <div class="order_page table-responsive">

        <?php  
        if (isset($_GET['view'])) {
            $id = $_GET['view'];    
            $z = mysqli_query($conn,"SELECT * FROM food_order where user_id = '$id' ");
            ?>
          <div id="tabs">
    <ul>
      <li><a href="#tabs-1">Order / Reservation history</a></li>
      <li><a href="#tabs-2">User Details</a></li>
    </ul>
    <div id="tabs-1">
      <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
            <h3>Order History</h3>
            <table class="w3-striped w3-border">
                <tr>
                    <td class="w3-padding-small">Total item</td>
                    <td class="w3-padding-small">Date Ordered</td>
                 </tr>
              <?php 
              if(mysqli_num_rows($z) > 0) {
                 while ($zz = mysqli_fetch_array($z)){
                    $order_id = $zz['order_id'];
                    $x = mysqli_query($conn,"SELECT sum(food_qty) as t from food_order_details where order_id = '$order_id' ");
                    $xx = mysqli_fetch_array($x); ?>
                    <tr class="w3-border">
                        <td class="w3-padding-small"><a class="w3-text-blue" href="d.php?i=<?php echo $order_id ?>"><?php echo $xx['t'] ?> items</a> </td>
                        <td class="w3-padding-small"><a class="w3-text-blue" href="d.php?i=<?php echo $order_id ?>"><?php echo date("m/d/y", strtotime($zz['curr_order_date'])) ?></a></td>
                  </tr>
                <?php
                } 
              } else { ?>
                    <tr class="w3-text-grey">
                        <td class="w3-padding-small" colspan="2">No order history</td>
                  </tr>
             <?php     
              }
            
              ?>  

            </table>
          </div>
        </div>

        <div class="col-md-6 w3-border-left">
          <div class="table-responsive">
            <h3>Reservation History</h3>
            <table class="w3-striped w3-border">
                <tr>
                    <td class="w3-padding-small">Package Name</td>
                    <td class="w3-padding-small">Date Reserved</td>
                 </tr>
                <?php 
                     
                 $m = mysqli_query($conn,"SELECT * FROM reservation where cu_id='$id'");
                if (mysqli_num_rows($m) > 0) {
                    while ($mm = mysqli_fetch_array($m)) {
                        $cater_id = $mm['cater_id'];
                        $h = mysqli_query($conn,"SELECT * FROM catering WHERE cater_id = '$cater_id' ") or die(mysqli_error($conn));
                        $hh = mysqli_fetch_array($h);
                        ?>
                        <tr>
                            <td class="w3-padding-small"><a class="w3-text-blue" href="reservation_view.php?rid=<?php echo $mm['rid'] ?>"><?php echo  $hh['event_name'] ?></a></td>
                            <td class="w3-padding-small"><a class="w3-text-blue" href="reservation_view.php?rid=<?php echo $mm['rid'] ?>"><?php echo date("m/d/y", strtotime($mm['date_reserved'])) ?></a></td>
                         </tr>
                <?php
                    }
                } else { ?>
                    <tr class=" w3-text-grey">
                        <td class="w3-padding-small" colspan="2">No reservation history</td>
                  </tr>
             <?php     
              }
                ?>

            </table>
          </div>
        </div>

      </div>

    </div>
    <div id="tabs-2">
      <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
            <table>
              <?php  
              $q = mysqli_query($conn,"SELECT * FROM users where id = '$id' ");
              $qq = mysqli_fetch_array($q);
              ?>
               <tr>
                <td class="w3-padding-small">Name</td>
                <td class="w3-padding-small">
                  <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['firstname'].' '.$qq['lastname'] ?>">
                </td>
              </tr>

              <tr>
                <td class="w3-padding-small">Contact Number</td>
                <td class="w3-padding-small">
                  <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['contact'] ?>">
                </td>
              </tr>

              <tr>
                <td class="w3-padding-small">Email Address</td>
                <td class="w3-padding-small">
                  <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['email'] ?>">
                </td>
              </tr>

              <tr>
                <td class="w3-padding-small">Address</td>
                <td class="w3-padding-small">
                  <textarea class="w3-input w3-border" disabled><?php echo $qq['address'] ?></textarea>
                </td>
              </tr>

            </table>
          </div>
        </div>
      </div>
      
    </div>

      </div>
      <?php
        } else { ?>
          <table class="w3-white w3-left w3-bordered w3-table table-custom">
            <tr class="w3-text-blue" style="font-weight: normal;">
              <th>Full name</th>
              <th>Gender</th>
              <th>Address</th>
              <th width="13%">Contact #</th>
              <th width="13%">Date registered</th>
              <th>Username</th>
              <th width="14%">Action</th>
            </tr>
            <?php
              $sql = mysqli_query($conn,"SELECT * FROM users");
              while ($row = mysqli_fetch_array($sql)) { ?>

                <tr class="t-body">
                  <td><?php echo $row['firstname']; ?> <?php echo $row['lastname'] ?></td>
                  <td><?php echo $row['gender']; ?></td>
                  <td><?php echo $row['address']; ?></td>
                  <td><?php echo $row['contact']; ?></td>
                  <td><?php echo date("M d, Y", strtotime($row['dateadded'])); ?></td>
                  <td><?php echo $row['username']; ?></td>
                  <td width="18%">
                    <a href="?view=<?php echo $row['id'] ?>">
                      <button class="action btn btn-default w3-left" style="margin-right: 2px"><i class="fas fa-search"></i> view</button>
                    </a>
                      <input type="hidden" id="deleteinfo<?php echo $row['id'] ?>" value="<?php echo $row['id'] ?>">
                      <button class="action delete btn btn-default w3-left" id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt"></i> delete</button>
                  </td>

                  <?php
              }
                  ?>
                  </tr>
            </table>
        <?php
        }
        ?>
      </div>
      </div>
    </div>
        </tr>
  </body>
</html>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
<script>
    $("#tabs").tabs();
    $(document).ready(function(){

    $("#name").keyup(function(){
      var name = $("#name").val();

      $.ajax({
        url: "include/user_search.inc.php",
        method: "POST",
        data: {
          name: name
        },
        success:function(data){
          $('table').html(data);
        }
      });
    });

    $(".delete").click(function(){
      var del = $(this).attr("id");
      var del_id = $("#deleteinfo"+del).val();

      if (confirm("Are you sure?") == true) {
        $.ajax({
          url: "include/user_search.inc.php",
          method: "POST",
          data: {
            del: del,
            del_id: del_id
          },
          success: function(data){
            if (data == "Deleted") {
              window.location.reload();
            }
          }
        });
      }
    });

  });
</script>