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
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed catering-page">
      <div class="search-con">
        <h2>Catering Services</h2>
        <a href="newservices.php">
          <button type="button" class="addServic w3-round w3-border w3-border-blue w3-text-blue w3-hover-blue"><i class="fas fa-plus"></i> Add New Services</button>
        </a>
        <a href="make-reservation.php">
          <button class="w3-btn w3-blue w3-round make-resevations">Make reservation</button>
        </a>
      </div>
      <div class="table-responsive w3-white" style="margin-top: 30px">
      <table class="w3-striped w3-border w3-white w3-centered">
        <tr class="w3-text-black">
          <th >Package Name</th>
          <th>Price per head</th>
          <th>Menus</th>
          <th>Action</th>
        </tr>
        <?php $sql = mysqli_query($conn,"SELECT * FROM catering") or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($sql)) { ?>
          <tr>
          <td class="w3-padding" align="left"><?php echo $row['event_name'] ?></td>
          <td class="w3-padding" align="left"><?php echo $row['price'] ?></td>
          <td class="w3-padding">
            <a href="services_view_menu.php?view=<?php echo $row['cater_id']; ?>">
              <button class="btn btn-default"><i class="fas fa-search"></i> View</button>
            </a>
          </td>
          <td class="w3-padding">
            <a href="services_edit.php?edit=<?php echo $row['cater_id']; ?>">
              <button class="btn btn-default"><i class="fas fa-pencil-alt"></i> Edit</button>
            </a>
              <input type="hidden" id="deleteinfo<?php echo $row['cater_id']; ?>" value="<?php echo $row['cater_id']; ?>">
              <button class="delete btn btn-default" id="<?php echo $row['cater_id']; ?>"><i class="fas fa-trash-alt" style="margin-right:3px"></i> Delete</button>
          </td>
        </tr>
      <?php  } ?>
      </table>
    </div>
      <?php
      if (isset($_GET['update'])) {
        echo '<script>alert("Update Successfully!")</script>';
      }
      if (isset($_GET['new'])) {
        echo '<script>alert("New Catering services added successfully!")</script>';
        echo '<script>window.location="services.php"</script>';
      }
      ?>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $(document).ready(function(){

        $(".delete").click(function(){
          var del = $(this).attr("id");
          var del_info = $("#deleteinfo"+del).val();

          if (confirm("Are you sure?") == true) {
            $.ajax({
              url: "include/services-delete.inc.php",
              method: "POST",
              data: {
                del:del,
                del_info:del_info
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
  </body>
</html>
