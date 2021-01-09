<?php
$total = 0;
  include '../includes/connect.php';
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
$rid = $_GET['pay'];

$d = mysqli_query($conn,"SELECT add_ons.food_qty, add_ons.food_id, food_menu.food_name, food_menu.price from add_ons inner join food_menu where add_ons.r_id='$rid' and add_ons.food_id=food_menu.food_id ");
  $o=0;
    while ($dd = mysqli_fetch_array($d)) {
      $o += $dd['food_qty'] * $dd['price'];
    }

    if (isset($_POST['submit_payment'])) {
        $amount_hidden = $_POST['amount_hidden'];
        $cash_money = $_POST['cash_money'];
        
        if ($cash_money < $amount_hidden) {
            echo '<script>alert("Cash must be greater or equal to '.$amount_hidden.' .");history.back()</script>';
        } else {
            $gg = mysqli_query($conn,"SELECT * FROM reservation where r_status = 'approve' and balance = '0'and adOn_mis = 'unpaid' and rid = '$rid' ");
            if (mysqli_num_rows($gg) > 0) {
                $q = mysqli_query($conn,"UPDATE reservation set adOn_mis = 'paid', r_status = 'finish' where rid = '$rid' ");
                if($q == true) {
                    echo '<script>alert("Payment added successfully!");location="reservation_view.php?rid='.$rid.'"</script>';
                }
            } else {
                $ggg = mysqli_query($conn,"SELECT * FROM reservation where r_status = 'approve' and adOn_mis = 'unpaid' and rid = '$rid' ");
                if (mysqli_num_rows($ggg) > 0) {
                    $q = mysqli_query($conn,"UPDATE reservation set adOn_mis = 'paid' where rid = '$rid' ");
                    if($q == true) {
                        echo '<script>alert("Payment added successfully!");location="reservation_view.php?rid='.$rid.'"</script>';
                    }
                } else {
                    $ggg = mysqli_query($conn,"SELECT * FROM reservation where r_status = 'pending' and adOn_mis = 'unpaid' and rid = '$rid' ");
                    if (mysqli_num_rows($ggg) > 0) {
                        $q = mysqli_query($conn,"UPDATE reservation set adOn_mis = 'paid' where rid = '$rid' ");
                        if($q == true) {
                            echo '<script>alert("Payment added successfully!");location="reservation_view.php?rid='.$rid.'"</script>';
                        }
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style media="screen">
    body{
      background:#f3f3f3;
    }
      label{
        font-weight:normal;
      }
      fieldset{
        border:0;
      }
      fieldset.C{
        border:1px solid #2196F3;
        margin-bottom:10px;
        background: #fff;
      }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed green">
      <div class="order_page" style="margin-top:5px;margin-bottom:15px;">
        <div class="tabs w3-border-top" style="padding:30px;margin:5px auto;width:400px">
        
        <form action="" method="POST" style="text-align:left">
          <h3 class="w3-center">Payment Form</h3>

          <input type="hidden" name="rid" id="rid" value="<?php echo $rid ?>">
          <label>Add-ons Amount</label>

            <input type="text" disabled class="w3-input w3-border amount" style="text-align:right" step="any" id="<?php echo $o ?>" name="amount" value="<?php echo number_format($o,2) ?>"><br>
            <input type="hidden" value = "<?php echo $o ?>" name = "amount_hidden">
            <label>Cash</label>
          <input type="number" class="w3-input w3-border" step="any" style="text-align:right" name="cash_money" id="cash_money" required> <br>

          <label>Change</label>
          <div class="w3-input w3-border" style="height:40px;text-align:right" id="change"></div>
          <input type="hidden" class="w3-input w3-border change_default" name="change" id="change"> <br>

          <button class="w3-btn w3-green w3-right w3-margin-bottom" name="submit_payment">Submit</button>
        </form>

      </div>
      </div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
           
           $("#cash_money").keyup(function(){
               var amount = $(".amount").attr("id");
               var rid = $("#rid").val(); 
               
               var cash = $(this).val();
               
               $.ajax({
                  url: "include/total_calculate.php",
                  method: "POST",
                  data: {
                      cash: cash,
                      amount: amount
                  },
                  success: function(data) {
                      $("#change").text(data);
                  }
               });
           });
        });
    </script>
  </body>
</html>
