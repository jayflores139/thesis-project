<?php
  include '../includes/connect.php';
  session_start();

    if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
$today = date("Y-m-d");

  if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $role = $_POST['role'];
    
    if ($pass != $pass2) {
      echo '<script>alert("Password does not match!");history.back()</script>';
    } else {
      $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
      $q = mysqli_query($conn,"INSERT INTO tbl_admin (Name, contact, passsword, position, date_created, username) values ('$name', '$contact', '$pass_hash', '$role', '$today', '$uname') ");

      if ($q == true) {
        echo '<script>alert("User successfully added!")</script>';
      }
    }

  }

if (isset($_POST['submitedit'])) {

  $id_edit = $_POST['id_edit'];
  $nameedit = $_POST['nameedit'];
  $contactedit = $_POST['contactedit'];
  $roleedit = $_POST['roleedit'];
  $unameedit = $_POST['unameedit'];
  $passedit = $_POST['passedit'];
  $pass2edit = $_POST['pass2edit'];

  if (empty($passedit)) {
    mysqli_query($conn,"UPDATE tbl_admin set Name = '$nameedit', contact = '$contactedit', position = '$roleedit', username = '$unameedit' where id = '$id_edit' ");
    echo '<script>alert("Update successfully.");location="accounts.php";</script>';
  } else {
    if ($passedit != $pass2edit) {
      echo '<script>alert("Password does not match!");history.back()</script>';
    } else {
      $pass_hash = password_hash($passedit, PASSWORD_DEFAULT);
      mysqli_query($conn,"UPDATE tbl_admin set Name = '$nameedit', contact = '$contactedit', position = '$roleedit', username = '$unameedit', passsword = '$pass_hash' where id = '$id_edit' ");
      echo '<script>alert("Update successfully");location="accounts.php";</script>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style type="text/css">
      textarea{
        width:100%;
        height:400px;
      }
      label{
        width:100%;
        text-align: left;
        font-weight: normal;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <div class="order_page">
        
          <div class="w3-white" style="height:auto;padding:20px 30px 100px 30px">

            <div >
              <div class="col-md-9 w3-margin-bottom" style="float: none">
                <form class="form_submit w3-center" method="POST" action="">

                  <?php  
                    if (isset($_GET['q'])) {
                      $id = $_GET['q'];
                      $h = mysqli_query($conn,"SELECT * FROM tbl_admin WHERE id = '$id' ");
                      $hh = mysqli_fetch_array($h);
                      ?>
                        <h3>Edit User</h3>
                  <table>
                    <tr>
                      <td class="w3-padding-small">
                          <label>Name
                            <input type="hidden" name="id_edit" value="<?php echo $id ?>">
                            <input type="text" name="nameedit" value="<?php echo $hh['Name'] ?>" required class="w3-input w3-border">
                          </label>
                      </td>

                      <td class="w3-padding-small">
                          <label>Contact #
                            <input type="text" name="contactedit" value="<?php echo $hh['contact'] ?>" required class="w3-input w3-border">
                          </label>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">
                          <label>Role
                            <select name="roleedit" class="w3-input w3-border">
                              <option value="administrator">Admin</option>
                              <option value="cashier">Cashier</option>
                            </select>
                          </label>
                      </td>

                      <td class="w3-padding-small">
                          <label> Username
                            <input type="text" name="unameedit" value="<?php echo $hh['username'] ?>" required class="w3-input w3-border">
                          </label>
                      </td>

                      
                    </tr>

                    <tr>
                      <td class="w3-padding-small">
                          <label> Password
                            <input type="password" name="passedit" class="w3-input w3-border">
                          </label>
                      </td>

                      <td class="w3-padding-small">
                          <label> Confirm Password
                            <input type="password" name="pass2edit" class="w3-input w3-border">
                          </label>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">
                        <button class="w3-btn w3-green" name="submitedit">Update</button>
                      </td>
                    </tr>
                  </table>
                      <?php
                    } else { ?>
                    <h3>Add User</h3>
                  <table>
                    <tr>
                      <td class="w3-padding-small">
                          <label>Name
                            <input type="text" name="name" required class="w3-input w3-border">
                          </label>
                      </td>

                      <td class="w3-padding-small">
                          <label>Contact #
                            <input type="text" name="contact" required class="w3-input w3-border">
                          </label>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">
                          <label>Role
                            <select name="role" class="w3-input w3-border">
                              <option value="administrator">Admin</option>
                              <option value="cashier">Cashier</option>
                            </select>
                          </label>
                      </td>

                      <td class="w3-padding-small">
                          <label> Username
                            <input type="text" name="uname" required class="w3-input w3-border">
                          </label>
                      </td>

                      
                    </tr>

                    <tr>
                      <td class="w3-padding-small">
                          <label> Password
                            <input type="password" name="pass" required class="w3-input w3-border">
                          </label>
                      </td>

                      <td class="w3-padding-small">
                          <label> Confirm Password
                            <input type="password" name="pass2" required class="w3-input w3-border">
                          </label>
                      </td>
                    </tr>

                    <tr>
                      <td class="w3-padding-small">
                        <button class="w3-btn w3-green" name="submit">Submit</button>
                      </td>
                    </tr>
                  </table>
                    <?php
                    }
                  ?>
                  

                </form>
              </div>

              <div class="w3-border-top">
                <table class="w3-striped w3-margin-top">
                  <tr class="w3-text-grey">
                    <td class="w3-padding">Date created</td>
                    <td class="w3-padding">Name</td>
                    <td class="w3-padding">Contact #</td>
                    <td class="w3-padding">Username</td>
                    
                    <td class="w3-padding">Role</td>
                    <td class="w3-padding"></td>
                  </tr>
                  <?php  
                  $q = mysqli_query($conn,"SELECT * FROM tbl_admin");
                  if (mysqli_num_rows($q) > 0) {
                    while ($qq = mysqli_fetch_array($q)) { ?>
                    <tr id="deleteRow<?php echo $qq['id'] ?>">
                      <td class="w3-padding"><?php echo $qq['date_created'] ?></td>
                      <td class="w3-padding"><?php echo $qq['Name'] ?></td>
                      <td class="w3-padding"><?php echo $qq['contact'] ?></td>
                      <td class="w3-padding"><?php echo $qq['username'] ?></td>
                      
                      <td class="w3-padding"><?php echo $qq['position'] ?></td>
                      <td class="w3-padding">
                        <a href="?q=<?php echo $qq['id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-pencil-alt"></i> Edit</button>
                        </a>
                          <button class="btn btn-default deletess" id="<?php echo $qq['id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </td>
                  </tr>
                  <?php
                    }
                  }
                  ?>
                  
                </table>
              </div>
            </div>

            <?php  
                      /*
                        $q = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
                        while ($qq = mysqli_fetch_array($q)) { ?>

                          <div class="col-md-12">
                          <form method="post" action="include/account.admin.inc.php" enctype="multipart/form-data">
                          <h3 class="w3-text-grey w3-center">Administrator Accounts</h3>

                          <div class="row">  
                            <div class="col-md-4 w3-padding">
                              <div class="w3-padding w3-center w3-border">
                                
                                <img src="images/<?php echo $qq['picture'] ?>" width="150" height="150" class="w3-margin">

                                <label class="w3-small" style="font-weight:normal;">Change Picture</label>
                                <input type="file" name="picture_acc" class="w3-input w3-border">

                              </div>
                            </div>

                            <div class="col-md-8 w3-padding">
                              <div class="w3-light-grey w3-padding">
                                
                                <label class="w3-small" style="font-weight:normal;">Name</label>
                                <input type="text" name="name" required class="w3-input w3-border w3-margin-bottom" value="<?php echo $qq['Name'] ?>">

                                <label class="w3-small" style="font-weight:normal;">Contact number</label>
                                <input type="text" name="contact" required class="w3-input w3-border w3-margin-bottom" value="<?php echo $qq['contact'] ?>">

                                <label class="w3-small" style="font-weight:normal;">Username</label>
                                <input type="text" name="uname" required class="w3-input w3-border w3-margin-bottom" value="<?php echo $qq['username'] ?>">

                                <a href="change_password.php?acc=admin" class="btn btn-default">Change Password</a><br><br>

                                <button class="btn btn-info" name="submit" type="submit">Update</button>
                              </div>
                            </div>

                          </div>
                          </form>
                        </div>

                        <?php
                        }
                         ?>


                         <?php 
                        $q = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'cashier' ");
                        while ($qq = mysqli_fetch_array($q)) { ?>

                          <div class="col-md-12 w3-margin-top w3-margin-bottom" id="CASHIER">
                          <form method="post" action="include/account.cashier.inc.php" enctype="multipart/form-data">
                          <h3 class="w3-text-grey w3-center">Cashier Accounts</h3>

                          <div class="row">  
                            <div class="col-md-4 w3-padding">
                              <div class="w3-padding w3-center w3-border">
                                
                                <img src="images/<?php echo $qq['picture'] ?>" width="150" height="150" class="w3-margin">

                                <label class="w3-small" style="font-weight:normal;">Change Picture</label>
                                <input type="file" name="picture_acc" class="w3-input w3-border">

                              </div>
                            </div>

                            <div class="col-md-8 w3-padding">
                              <div class="w3-light-grey w3-padding">
                                
                                <label class="w3-small" style="font-weight:normal;">Name</label>
                                <input type="text" name="name" required class="w3-input w3-border w3-margin-bottom" value="<?php echo $qq['Name'] ?>">

                                <label class="w3-small" style="font-weight:normal;">Contact number</label>
                                <input type="text" name="contact" required class="w3-input w3-border w3-margin-bottom" value="<?php echo $qq['contact'] ?>">

                                <label class="w3-small" style="font-weight:normal;">Username</label>
                                <input type="text" name="uname" required class="w3-input w3-border w3-margin-bottom" value="<?php echo $qq['username'] ?>">

                                <a href="change_password.php?acc=cashier" class="btn btn-default">Change Password</a><br><br>

                                <button class="btn btn-info" name="submit" type="submit">Update</button>
                              </div>
                            </div>

                          </div>
                          </form>
                        </div>

                        <?php
                        }
                         ?>
                                */
            ?>

          </div>
        </div>
      </div>
    </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>

      $(document).ready(function(){

        $(".deletess").click(function(){
          var delete_id = $(this).attr("id");

          if (confirm("Are you sure?") == true) {
            $.ajax({
              url:"include/delete_admin_user.php",
              method:"POST",
              data: {
                delete_id: delete_id
              },
              success: function (d) {
                if (d == "del") {
                  $("#deleteRow"+delete_id).remove();
                }
              }
            });
          }
        });

      });

    </script>
  </body>
</html>
