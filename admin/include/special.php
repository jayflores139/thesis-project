<?php 
include "../../includes/connect.php";

if (isset($_POST['submitEdit'])) {
    
    $food_type = $_POST['food_type'];
    $type_id_edit = $_POST['type_id_edit'];
    
    $sql = mysqli_query($conn,"UPDATE food_type SET type_name = '$food_type' where type_id = '$type_id_edit'");
    
    if ($sql == true) {
        echo "Updated";
    }
    
}
