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
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>

    </script>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed">
      <div class="search-con">
        <h2>Users</h2>
        <form>
          <input type="text" autocomplete="off" name="name" id="name" class="w3-border w3-border-blue w3-round" placeholder="Search..." class="w3-round" style="width:300px;margin-right:5px">
        </form>
      </div>

      <div class="order_page table-responsive">
        <table class="w3-white w3-left w3-bordered w3 w3-table table-custom">
          <tr class="w3-light-grey">
            <th>Full name</th>
            <th>Gender</th>
            <th>Address</th>
            <th width="13%">Contact #</th>
            <th width="13%">Date registered</th>
            <th>Username</th>
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

                <?php
            }
                ?>
                </tr>
        </table>
      </div>
      </div>
    </div>
        </tr>
  </body>
</html>

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