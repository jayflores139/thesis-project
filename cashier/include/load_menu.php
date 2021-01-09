<?php
include '../../includes/connect.php';

if ($_POST['cater_id']) {
	
	$cater_id = $_POST['cater_id'];

	echo "<div class='w3-center w3-padding-small ssss w3-border'>";

	echo "<div style='width:40%;margin:0 auto'>";
	$q = mysqli_query($conn,"SELECT * FROM category ");
    while ($qq = mysqli_fetch_array($q)) {
      echo "<h4 class='w3-text-green'>".$qq['cat_name']."</h4>";

      $w = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$qq['cat_id']."' ");
      while ($ww = mysqli_fetch_array($w)) {
        echo "<h5 class='w3-text-blue'>".$ww['type_name']."</h5>";

        $e = mysqli_query($conn,"SELECT food_menu.food_name FROM food_menu inner join catering_details WHERE catering_details.cater_id='$cater_id' and catering_details.food_id=food_menu.food_id and type_id = '".$ww['type_id']."' and catid = '".$qq['cat_id']."' ") or die(mysqli_error($conn));
        while ($ee = mysqli_fetch_array($e)) { ?>
          
          <label class="w3-margin-left">
            <?php echo $ee['food_name'] ?>
          </label> <br>
        <?php
        }
      }
    }
    echo "</div></div>";
}
?>
