<?php 
include "../../includes/connect.php";

if (isset($_POST['category'])) {
    $cat_id = $_POST['category'];
    $sqlq = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '$cat_id' ");
     while ($rowq = mysqli_fetch_array($sqlq)) { 
        echo '<option value="'.$rowq['type_id'].'">'.$rowq['type_name'].'</option>'; 
      }
}
