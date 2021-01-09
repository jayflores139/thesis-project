<?php
include '../../../includes/connect.php';
$sql2 = mysqli_query($conn,"SELECT * from category");
while ($row2 = mysqli_fetch_array($sql2)) {
  $row2['cat_id'];
  echo '<h6 class="w3-center select_cac w3-text-blue">'.$row2['cat_name'].'</h6>';

  $sql3 = mysqli_query($conn,"SELECT * from food_type WHERE cat_id = '".$row2['cat_id']."'");
  while ($row3 = mysqli_fetch_array($sql3)) {
    $row3['type_id'];
    echo '<b><p class="w3-center w3-text-green type_name">'.$row3['type_name'].'</p></b>';

    $sql4 = mysqli_query($conn,"SELECT * from food_menu WHERE type_id='".$row3['type_id']."' && catid='".$row2['cat_id']."'");
    while ($row4 = mysqli_fetch_array($sql4)) {
      echo '<p class="w3-center"><input type="checkbox" id="food_id" name="food_id[]" value="'.$row4['food_id'].'">'.$row4['food_name'].'</p>';

    }
  }
}

 ?>
