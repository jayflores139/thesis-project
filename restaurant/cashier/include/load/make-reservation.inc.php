<?php
include '../../../includes/connect.php';

//code for select events
if (isset($_POST['selects'])) {
  echo '<div class="w3-padding-medium w3-margin-top blah">';
  $sql = mysqli_query($conn,"SELECT * from catering where cater_id='".$_POST['selects']."'");
  while ($row = mysqli_fetch_array($sql)) {
    echo '<h4 class="w3-center event-ttitle">'.$row['event_name'].'</h4>';
    echo '<h5 class="w3-text-blue w3-center">P '.$row['p_head'].' per head</h5><br><br>';
    echo '<div class="containerrs">';
    $sql2 = mysqli_query($conn,"SELECT * from category");
    while ($row2 = mysqli_fetch_array($sql2)) {
      $row2['cat_id'];
      echo '<h6 class="w3-center select_cac w3-text-blue">'.$row2['cat_name'].'</h6>';

      $sql3 = mysqli_query($conn,"SELECT * from food_type WHERE cat_id = '".$row2['cat_id']."'");
      while ($row3 = mysqli_fetch_array($sql3)) {
        $row3['type_id'];
        echo '<b><p class="w3-center w3-text-green type_name">'.$row3['type_name'].'</p></b>';

        $sql4 = mysqli_query($conn,"SELECT * from food_menu natural join catering_details
          WHERE type_id='".$row3['type_id']."' && cater_id='".$_POST['selects']."'");
          
          if (mysqli_num_rows($sql4) > 0){
            while ($row4 = mysqli_fetch_array($sql4)) {
              echo '<p class="w3-center">'.$row4['food_name'].'</p>';
    
            }
          } else {
              echo "<span class='w3-text-grey'>[ No menu added ]</span><br>";
          }
      }
    }
  }
  echo '</div>';
  echo '</div>';
}
#
 ?>
