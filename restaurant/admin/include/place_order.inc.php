<?php  

include '../../includes/connect.php';
session_start();

$pick_handler = false;
$dine_handler = false;
$delivery = false;
$takeout_handler = false;
$VAT = 0;
$VATexem = 1.12;

$today = date("Y-m-d");
#####################################################################################################################
if (isset($_POST['submitDELIVERYsenior'])) {

  $DELIVERY_date = $_POST['DELIVERY_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $delivery_personName = $_POST['delivery_personName'];
  $delivery_personContact = $_POST['delivery_personContact'];
  $BARANGAY = $_POST['BARANGAY'];
  $HOUSESTREET = $_POST['HOUSESTREET'];

  $seniorDiscount = $_POST['seniorDiscount'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($DELIVERY_date));

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid delivery date!";
  } else {

    if (!empty($delivery_personName) || !empty($delivery_personContact)) {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'delivery', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$delivery_personName', '$delivery_personContact', '$last_id', 'delivery') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }
          $dd = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '$BARANGAY'") or die(mysqli_error($conn));
          $ddd = mysqli_fetch_array($dd);

            $total2 = $totalS / $VATexem;
            $orderAmountWithDiscount = ($total2 - ($total2 * $seniorDiscount)) + $ddd['deliv_charge'];

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'senior', order_amount = '$orderAmountWithDiscount' where order_id = '$last_id'");
            mysqli_query($conn,"INSERT INTO delivery_detail (bd_id, house_street, order_id) values ('$BARANGAY', '$HOUSESTREET', '$last_id')");
            if ($last_querys) {
              $delivery = true;
            }
        }
    } else {
      $data['required'] = "Customer's name and contact number is required!";
    }

  }
  if ($delivery == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}

if (isset($_POST['submitDELIVERYjunior'])) {

  $DELIVERY_date = $_POST['DELIVERY_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $delivery_personName = $_POST['delivery_personName'];
  $delivery_personContact = $_POST['delivery_personContact'];
  $BARANGAY = $_POST['BARANGAY'];
  $HOUSESTREET = $_POST['HOUSESTREET'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($DELIVERY_date));

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid delivery date!";
  } else {

    if (!empty($delivery_personName) || !empty($delivery_personContact)) {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'delivery', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$delivery_personName', '$delivery_personContact', '$last_id', 'delivery') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }
          $dd = mysqli_query($conn,"SELECT * FROM barangay_delivery where bd_id = '$BARANGAY'") or die(mysqli_error($conn));
          $ddd = mysqli_fetch_array($dd);

            $orderAmount = $totalS + ($totalS * $VAT) + $ddd['deliv_charge'];

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'junior', order_amount = '$orderAmount' where order_id = '$last_id'");
            mysqli_query($conn,"INSERT INTO delivery_detail (bd_id, house_street, order_id) values ('$BARANGAY', '$HOUSESTREET', '$last_id')");
            if ($last_querys) {
              $delivery = true;
            }
        }
    } else {
      $data['required'] = "Customer's name and contact number is required!";
    }

  }
  if ($delivery == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}
#############################################################################################################################################
if (isset($_POST['submitDINEINjunior'])) {

  $DINEIN_date = $_POST['DINEIN_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $person_NAME = $_POST['person_NAME'];
  $contact_person = $_POST['contact_person'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($DINEIN_date));

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid dine-in date!";
  } else {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'dinein', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$person_NAME', '$contact_person', '$last_id', 'dinein') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }

            $orderAmount = $totalS + ($totalS * $VAT);

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'junior', order_amount = '$orderAmount' where order_id = '$last_id'");
            if ($last_querys) {
              $dine_handler = true;
            }
        }

  }
  if ($dine_handler == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}

if (isset($_POST['submitDINEINsenior'])) {

  $DINEIN_date = $_POST['DINEIN_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $person_NAME = $_POST['person_NAME'];
  $contact_person = $_POST['contact_person'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($DINEIN_date));

  $seniorDiscount = $_POST['seniorDiscount'];

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid dine-in date!";
  } else {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'dinein', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$person_NAME', '$contact_person', '$last_id', 'dinein') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }
            $total2 = $totalS / 1.12;
            $orderAmount = $total2 - ($total2 * $seniorDiscount);

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'senior', order_amount = '$orderAmount' where order_id = '$last_id'");
            if ($last_querys) {
              $dine_handler = true;
            }
        }

  }
  if ($dine_handler == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}

#####################################################################################################################################################
if (isset($_POST['submitPICKUPjunior'])) {

  $PICKUP_date = $_POST['PICKUP_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $person_NAME = $_POST['person_NAME'];
  $contact_person = $_POST['contact_person'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($PICKUP_date));

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid pick up date!";
  } else {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'pickup', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$person_NAME', '$contact_person', '$last_id', 'pickup') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }

            $orderAmount = $totalS + ($totalS * $VAT);

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'junior', order_amount = '$orderAmount' where order_id = '$last_id'");
            if ($last_querys) {
              $pick_handler = true;
            }
        }

  }
  if ($pick_handler == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}

if (isset($_POST['submitPICKUPsenior'])) {

  $PICKUP_date = $_POST['PICKUP_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $person_NAME = $_POST['person_NAME'];
  $contact_person = $_POST['contact_person'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($PICKUP_date));

  $seniorDiscount = $_POST['seniorDiscount'];

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid pick up date!";
  } else {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'pickup', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$person_NAME', '$contact_person', '$last_id', 'pickup') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }
          $total2 = $totalS / $VATexem;
            $orderAmount = $total2 - ($total2 * $seniorDiscount);

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'senior', order_amount = '$orderAmount' where order_id = '$last_id'");
            if ($last_querys) {
              $pick_handler = true;
            }
        }

  }
  if ($pick_handler == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}

################################################################################################################
if (isset($_POST['submitTAKEOUTjunior'])) {

  $TAKE_date = $_POST['TAKE_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $person_NAME = $_POST['person_NAME'];
  $contact_person = $_POST['contact_person'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($TAKE_date));

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid take out date!";
  } else {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'takeout', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$person_NAME', '$contact_person', '$last_id', 'takeout') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }

            $orderAmount = $totalS + ($totalS * $VAT);

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'junior', order_amount = '$orderAmount' where order_id = '$last_id'");
            if ($last_querys) {
              $pick_handler = true;
            }
        }

  }
  if ($pick_handler == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }

  echo json_encode($data);
}

if (isset($_POST['submitTAKEOUTsenior'])) {

  $TAKE_date = $_POST['TAKE_date'];

  $HOUR = $_POST['HOUR'];
  $MINUTE = $_POST['MINUTE'];
  $AMPM = $_POST['AMPM'];

  $MODEofPAYMENT = $_POST['MODEofPAYMENT'];

  //customer pick
  $person_NAME = $_POST['person_NAME'];
  $contact_person = $_POST['contact_person'];

  $time = date_create("$HOUR:$MINUTE $AMPM");
  $transaction_time = date_format($time, "h:i A");
  $transaction_date = date("Y-m-d", strtotime($TAKE_date));

  $seniorDiscount = $_POST['seniorDiscount'];

  if ($transaction_date < $today) {
    $data['invalid'] = "Invalid take out date!";
  } else {
        
        $query = mysqli_query($conn,"INSERT INTO food_order (user_id, curr_order_date, order_time, order_date, payment_mode, order_type, status) values ('0', '$today', '$transaction_time', '$transaction_date', '$MODEofPAYMENT', 'takeout', 'pending')") or die(mysqli_error($conn));

        if ($query == true) {
          $last_id = mysqli_insert_id($conn);
          $_SESSION['last_id_order'] = $last_id;

          $data['order_id'] = $last_id;

          mysqli_query($conn,"INSERT INTO pick_up_details (p_to_pick, contact, order_id, type) VALUES ('$person_NAME', '$contact_person', '$last_id', 'takeout') ") or die(mysqli_error($conn));
        }
        if (!empty($_SESSION['shopping_cart'])) {
          $totalS = 0;
          foreach ($_SESSION['shopping_cart'] as $key => $value) {
            mysqli_query($conn,"INSERT INTO food_order_details (order_id, food_id, food_qty) values ('$last_id', '".$value['id']."', '".$value['quantity']."')");

            $totalS = $totalS + ($value['quantity'] * $value['price']);
          }
            $total2 = $totalS / $VATexem;
            $orderAmount = $total2 - ($total2 * $seniorDiscount);

            $last_querys = mysqli_query($conn,"UPDATE food_order set customer_type = 'senior', order_amount = '$orderAmount' where order_id = '$last_id'");
            if ($last_querys) {
              $pick_handler = true;
            }
        }

  }
  if ($pick_handler == true) {
    $data['success'] = "Your order was successfully done!\nThank you.";
    unset($_SESSION['shopping_cart']);
  }
  echo json_encode($data);
}

if (isset($_POST['cash_money'])) {
  $amount = $_POST['amount'];

  if (empty($_POST['cash_money'])) {
    echo "";
  } else {
    echo number_format($_POST['cash_money'] - $amount, 2);
  }
}

?>