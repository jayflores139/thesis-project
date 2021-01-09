<?php
include '../../includes/connect.php';
    $q = mysqli_query($conn,"SELECT * FROM category ");

    echo "<div class='w3-border'>";
    echo "<div style='width:40%;margin:0 auto'>";
    while ($qq = mysqli_fetch_array($q)) {
      echo "<h4 class='w3-text-green'>".$qq['cat_name']."</h4>";

      $w = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$qq['cat_id']."' ");
      while ($ww = mysqli_fetch_array($w)) {
        echo "<h5 class='w3-text-blue'>".$ww['type_name']."</h5>";

        $e = mysqli_query($conn,"SELECT * FROM food_menu WHERE type_id = '".$ww['type_id']."' and catid = '".$qq['cat_id']."' ");
        while ($ee = mysqli_fetch_array($e)) { ?>
          
          <label class="w3-margin-left">
            <input type="checkbox" name="food_id[]" value="<?php echo $ee['food_id'] ?>">
            <?php echo $ee['food_name'] ?>
          </label> <br>
        <?php
        }
      }
    }
  echo "</div>";
  echo "</div>";
 ?>
