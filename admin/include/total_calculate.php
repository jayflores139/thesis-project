<?php 
if (isset($_POST['cash'])) {
    $cash = $_POST['cash'];
    $amount = $_POST['amount'];
    
    if ($cash < $amount) {
        echo "";
    } else {
        echo number_format($cash - $amount,2);
    }
}
?>