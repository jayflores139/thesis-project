<?php
include "../includes/connect.php";
session_start();

$errorEmpty = false;
$errorFirst = false;
$errorLast = false;
$errorNumStr = false;
$errorEmail = false;
$errorPass = false;
$errorUname = false;

if (isset($_POST['signup_submit'])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $cnum = $_POST['cnum'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $uname = $_POST['uname'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  $date = date("Y-m-d");

  if (empty($fname) || empty($lname) || empty($cnum) || empty($address) || empty($email) || empty($gender) || empty($uname) || empty($pass1) || empty($pass2)) {
    echo "Please fill in all fields!";
    $errorEmpty = true;
  }
  else{
    if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
      echo "Only Letters and whitespace allow!";
      $errorFirst = true;
    }
    else {
      if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
        echo "Only Letters and whitespace allow!";
        $errorLast = true;
      }
      else{
        if (strlen($cnum) > 12 || strlen($cnum) < 12 ) {
            echo "Please write the contact number as 9 characters!";
            $errorNumStr = true;
          }
          else {
            $sql = mysqli_query($conn,"SELECT * FROM users WHERE username = '$uname'");
            if (mysqli_num_rows($sql)>0) {
              echo "Username already exist!";
              $errorUname = true;
            }
            else {
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Please write a valid E-mail address!";
                $errorEmail = true;
              }
              else {
                if ($pass1 != $pass2) {
                  echo "Passwords does not match!";
                  $errorPass = true;
                }
                else {
                  $sql = mysqli_query($conn,"INSERT INTO users (firstname, lastname, gender, address, contact, dateadded, username, password)
                  VALUES ('$fname', '$lname', '$gender', '$address', '$cnum', '$date', '$uname', '$pass1')") or die("Error:".mysqli_error($conn));
                  if ($sql) {
                    $sql1 = mysqli_query($conn,"SELECT * FROM users WHERE username='$uname'");
                    while ($row = mysqli_fetch_array($sql1)) {
                      $_SESSION['userId'] = $row['id'];
                    }
                    echo  '<script>alert("Sign up Successfully")</script>';
                    echo  '<script>window.location="menu.php"</script>';
                  }
                }
              }
            }
          }
        }
      }
    }
    mysqli_close($conn);
  }
/*
*/
?>
<script>
  var allEmpty = "<?php echo $errorEmpty; ?>";
  var fnameLW = "<?php echo $errorFirst; ?>";
  var lnameLW = "<?php echo $errorLast?>";
  var errorNumStr = "<?php echo $errorNumStr; ?>";
  var errorEmail = "<?php echo $errorEmail; ?>";
  var errorPass = "<?php echo $errorPass; ?>";
  var errorUname = "<?php echo $errorUname; ?>";

  if (allEmpty == true) {
    $("#fname, #lname, #cnum, #address, #email, #gender, #uname, #pass1, #pass2").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
  }
  else {
    $("#fname, #lname, #cnum, #address, #email, #gender, #uname, #pass1, #pass2").css({"backgroundColor":"#fff","border":"1px solid #ccc"});

    if (fnameLW == true) {
      $("#fname").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
    }
    else{
      $("#fname").css({"backgroundColor":"#fff","border":"1px solid #ccc"});
    }

    if (lnameLW == true) {
      $("#lname").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
    }
    else{
      $("#lname").css({"backgroundColor":"#fff","border":"1px solid #ccc"});
    }

    if (errorNumStr == true) {
      $("#cnum").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
    }
    else{
      $("#cnum").css({"backgroundColor":"#fff","border":"1px solid #ccc"});
    }

    if (errorEmail == true) {
      $("#email").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
    }
    else{
      $("#email").css({"backgroundColor":"#fff","border":"1px solid #ccc"});
    }

    if (errorUname == true) {
      $("#uname").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
    }
    else {
      $("#uname").css({"backgroundColor":"#fff","border":"1px solid #ccc"});
    }

    if (errorPass == true) {
      $("#pass1, #pass2").css({"backgroundColor":"rgb(251, 244, 244)","border":"1px solid #f3a1a1"});
    }
    else{
      $("#pass1, #pass2").css({"backgroundColor":"#fff","border":"1px solid #ccc"});
    }
  }



</script>
