<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}
  include '../includes/connect.php';
  $k = mysqli_query($conn,"SELECT * FROM tbl_admin where position = 'administrator' ");
  $kk = mysqli_fetch_array($k);

  $p = mysqli_query($conn,"SELECT * FROM downpayment");
  $pp = mysqli_fetch_array($p);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
  </head>
  <body style="background:#fcfcfc;">
    <?php include 'include/header.php'; ?>

    <div class="right-fixed green" style="background:#fcfcfc;margin-bottom:80px">
      <div class="order_page" style="background:#fcfcfc; margin-top:5px;margin-bottom:15px;">

        <form class="make_reservation_for w3-center" autocomplete="off" action="make-reservation2.inc.php" method="post" style="width:100%;margin:0 auto">
          <h3 class="w3-text-blue">Reservation</h3>

            <div style="width: 50%;margin:0 auto">
               <label  class="w3-left" style="font-weight: lighter;">Occasion</label>
              <select class="w3-select w3-border w3-margin-bottom w3-border-blue w3-round w3-padding" id="select_occasion" name="cater_id" required>
                <option value="">Select occasions</option>
                <?php $sql = mysqli_query($conn,"SELECT * from catering") or die(mysqli_error($conn));
                while ($row = mysqli_fetch_array($sql)) { ?>
                <option value="<?php echo $row['cater_id'] ?>"><?php echo $row['event_name'] ?></option>
              <?php  } ?>
              </select>
            </div>

            <div style="width: 50%;margin:0 auto">
              <label class="w3-left" style="font-weight: lighter;">Total Visitor <span class="w3-text-red">*</span></label>
              <input type="number" class="w3-input w3-margin-bottom w3-border w3-border-blue w3-round w3-padding" name="visitor" placeholder="Total Visitor" required>
            </div>

            <div style="width: 50%;margin:0 auto">
               <label class="w3-left" style="font-weight: lighter;">Mode of Payment <span class="w3-text-red">*</span></label>
                <select class="w3-input w3-border w3-margin-bottom w3-border-blue w3-round w3-padding" id="select_occasion" name="mode" required>
                  <option>Cash</option>
                  <option>Pera padala</option>
                </select>
            </div>     
          
          <div class="w3-blue-grey sad w3-round-small w3-center w3-padding-large" style="margin:0 20px 20px 20px; display:none">
            <button type="button" class="w3-blue w3-ripple w3-round-small w3-btn" id="customize_menu">Customize menu</button>
            <div class="w3-white select_data_con"></div>

          </div>

          <div class="alert alert-danger" style="margin:10px auto;text-align:left; width:50%">
              <b>PLEASE READ</b><br><br>

              Note: If you choose pera padala as your mode of payment use this NAME - <span style="text-decoration:underline;"><?php echo $kk['Name'] ?></span> and CONTACT NUMBER - <span style="text-decoration:underline;"><?php echo $kk['contact'] ?></span>. <br><br> You must pay at least <?php echo $pp['d_price'] * 100 ?>% of the actual price as an advance payment 4 days before the booking date, if you failed to pay the said advance payment, reservation will be CANCEL.
            </div>

          <button type="submit" class="w3-btn w3-blue w3-round-small" style="padding:8px 30px;" name="submit" id="submit-reservation">Submit</button>
        </form>

      </div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
      $(document).ready(function(){
        $("#datepay").datepicker();

        //code for getting data catering info
        $("#select_occasion").change(function(){
          $(".sad").show();
          var selects = $(this).val();
          if (selects == "") {
            $(".sad").hide();
            alert("Please select occasion.");
          }
          else {
            $.ajax({
              url:"include/load/make-reservation.inc.php",
              data:{selects:selects},
              method:"post",
              success:function(da){
                $(".select_data_con").html(da);
              }
            });
          }
        });

        //code for customize Menu
        $("#customize_menu").click(function(){
            $(".containerrs").load("include/load/load_menu.php");
        });

});
    </script>
  </body>
</html>
