<?php
session_start();
  include '../includes/connect.php';
  if (!isset($_GET['view'])) {
    header("Location:services.php");
  }
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
$r = false;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed catering-page-view-menu">
      <div class="search-con">
        <h2>Catering Services</h2>
        <a href="newservices.php">
          <button type="button" class="addServic w3-border w3-border-blue w3-white w3-text-blue w3-round"><i class="fas fa-plus"></i> Add New Services</button>
        </a>
      </div>
      <?php
      $sql__ = mysqli_query($conn,"SELECT * FROM catering WHERE cater_id = '".$_GET['view']."'");
      while ($row__ = mysqli_fetch_array($sql__)) { ?>
        <h3 class="title-package"><?php echo $row__['event_name'] ?> - P <?php echo number_format($row__['price'],2) ?></h3>
      <?php } ?>

      <div class="row">
        <?php
        $sql_ = mysqli_query($conn,"SELECT * FROM category");
        while ($row_ = mysqli_fetch_array($sql_)) { ?>

              <div class="col-md-6 column-column">
                <div class="con-food">
                  <h4><?php echo $row_['cat_name'] ?></h4>
          <?php $sql___ = mysqli_query($conn,"SELECT * FROM food_type WHERE cat_id='".$row_['cat_id']."'");
          while ($row___ = mysqli_fetch_array($sql___)) { ?>
            <h5><?php echo $row___['type_name'] ?></h5>
            <div class="collll">
              <?php
              $sql = mysqli_query($conn,"SELECT * FROM catering_details WHERE cater_id='".$_GET['view']."'");
                if (mysqli_num_rows($sql) > 0) {
                    while ($row = mysqli_fetch_array($sql)) {
                        $id = $row['food_id']; 
                        $sql3 = mysqli_query($conn,"SELECT * FROM food_menu WHERE food_id='$id' && type_id='".$row___['type_id']."'");

                          while ($row3 = mysqli_fetch_array($sql3)) { ?>
                          <div class="collll-con">
                            <img src="../food_images/<?php echo $row3['photo'] ?>" alt="">
                              <h6><?php echo $row3['food_name']; ?></h6>
                          </div>
  <?php
                    }
                }
            }
              ?>
            </div>
<?php
          }
          ?>
                
                </div>
              </div>
<?php
        }
?>
    </div>    </div>


    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
    </scrip
                }
</html>
