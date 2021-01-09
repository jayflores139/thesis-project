
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
        <form>
          <input type="text" name="name" id="name" class="w3-border w3-border-blue" placeholder="Search..." autocomplete="off" class="w3-round" style="width:300px;margin-right:5px">
        </form>
      </div>

      <div class="order_page table-responsive">

        <?php  
        if (isset($_GET['view'])) { ?>
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
            <table>
                
              <tr>
                <td class="w3-padding-small">Total item</td>
                <td class="w3-padding-small"><a href="#">asddsdasd</a></td>
              </tr>

            </table>
          </div>
        </div>

        <div class="col-md-6">
          <div class="table-responsive">
            <h3>Reservation</h3>
            <table>

               <tr>
                <td class="w3-padding-small">Catering name</td>
                <td class="w3-padding-small"><a href="#">asddsdasd</a></td>
              </tr>

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
              $q = mysqli_query($conn,"SELECT * FROM reservation where rid = '".$_GET['rid']."' ");
              $qq = mysqli_fetch_array($q);
              ?>
               <tr>
                <td class="w3-padding-small">Name</td>
                <td class="w3-padding-small">
                  <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['cu_first'].' '.$qq['cu_last'] ?>">
                </td>
              </tr>

              <tr>
                <td class="w3-padding-small">Contact Number</td>
                <td class="w3-padding-small">
                  <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['cu_phone'] ?>">
                </td>
              </tr>

              <tr>
                <td class="w3-padding-small">Email Address</td>
                <td class="w3-padding-small">
                  <input type="text" class="w3-input w3-border" disabled value="<?php echo $qq['cu_mail'] ?>">
                </td>
              </tr>

              <tr>
                <td class="w3-padding-small">Address</td>
                <td class="w3-padding-small">
                  <textarea class="w3-input w3-border" disabled><?php echo $qq['cu_add'] ?></textarea>
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