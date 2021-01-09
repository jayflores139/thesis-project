<?php
  session_start();
  include '../../includes/connect.php';

  function clean($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  if (isset($_POST['submit'])) {
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    $sql = mysqli_query($conn,"SELECT * FROM tbl_admin where username = '$username' and position = 'cashier' ") or die(mysqli_error($conn));

    if (mysqli_num_rows($sql) > 0) {
      while ($row = mysqli_fetch_array($sql)) {
       
        $password_verify = password_verify($password, $row['passsword']);

        if ($password_verify === true) {
          $_SESSION['user_id'] = $row['id'];

          echo "Log in successfully!";
        } else {
          echo "Password is incorrect!";
        }
      }
    }
    else {
      echo "Username or Password is incorrect!";
    }
  }
?>
