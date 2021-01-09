<?php
$total = 0;
  include '../includes/connect.php';
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
  header("Location:login.php");
}

  $handler = false;

  if (isset($_GET['action']) && $_GET['action'] == "remove") {
    foreach ($_SESSION['shopping_cart'] as $key => $value) {
      if ($value['id'] == $_GET['id']) {
        unset($_SESSION['shopping_cart'][$key]);
      }
    }
  }

  if (isset($_POST['update_cart'])) {
      $ids = $_GET['id'];
      $fff = $_POST['update_box'];
      foreach ($_SESSION['shopping_cart'] as $key => $value) {
        if ($value['id'] == $ids) {
          if ($fff == 0) {
            $_SESSION['shopping_cart'][$key]['quantity'] = 1;
          } else {
            if ($_SESSION['shopping_cart'][$key]['id'] == $ids) {
              $_SESSION['shopping_cart'][$key]['quantity'] = $fff;
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
    <title>Place Order</title>
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
        <div class="tabs" style="padding:30px">
          <fieldset>
            <h3 class="w3-text-black w3-padding">Place Order</h3>
              <fieldset class="C table-responsive">
                <legend style="margin:0;width:auto;font-size:14px;" class="w3-text-blue w3-padding-small">Verify the Order</legend>

                <table class="w3-bordered w3-round-small w3-white cart-con-table">
                  <tr>
                    <th >Image</th>
                    <th width="20%">Food Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub total</th>
                    <th>Action</th>
                  </tr>

                  <?php if (!empty($_SESSION['shopping_cart'])) {
                    foreach ($_SESSION['shopping_cart'] as $key => $value) { ?>
                      <tr>
                        <td><img src="../food_images/<?php echo $value['picture'] ?>" alt="<?php echo $value['picture'] ?>"></td>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['price'] ?></td>
                        <td><form action="place_order.php?action=update&id=<?php echo $value['id'] ?>" method="post">
                          <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                          <input type="text" value="<?php echo $value['quantity'] ?>" size="1" name="update_box" class="w3-center">
                        </td>
                        <td>P <?php echo number_format($value['quantity'] * $value['price'],2) ?></td>
                        <td>
                          <button type="submit" name="update_cart" class="w3-hover-grey w3-light-grey w3-border-0"
                              style="height:40px;width:40px">
                             <i class="fas fa-sync-alt"></i></button>
                           </form>

                          <a href="place_order.php?action=remove&id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure you want to delete this?')">
                             <button class="w3-hover-grey w3-light-grey w3-border-0"
                              style="height:40px;width:40px"><i class="fas fa-trash-alt"></i>
                            </button></a></td>
                      </tr>
                  <?php
                  $v = $value['quantity'] * $value['price'];
                  $total = $total + $v;
                }
                ?>
                <tr>
                  <th colspan="4" style="text-align:right">Grand Total: </th>
                  <td> <span style="padding:5px 10px;border:2px solid blue">P <?php echo number_format($total, 2) ?></span></td>
                </tr>
                <?php
              } else {
                echo '<script>location="foodCart.php"</script>';
              }
              ?>
                </table>
              </fieldset>

              <fieldset class="w3-border-blue w3-margin w3-border">
    <legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Order Type</legend>
    <div class="w3-padding" style="color:#555"> 
      <label>
        <input type="radio" checked name="radio" value="delivery" class="order_type" id="DELIVERY">
        Delivery
      </label><br>

      <label>
        <input type="radio" name="radio" value="dinein" class="order_type" id="DINEIN">
        Dine-in
      </label><br>

      <label>
        <input type="radio" name="radio" value="pickup" class="order_type" id="PICKUP">
        Pick up
      </label><br>

      <label>
        <input type="radio" name="radio" value="takeout" class="order_type" id="TAKEOUT">
        Take out
      </label><br><br>

      <div>
        <label>
          <span class="typeKITA">Delivery</span> Date
          <?php  
          $today = date("m/d/Y");
          ?>
          <input type="text" id="tran_date" class="w3-input w3-border w3-border-grey w3-round-small" value="<?php echo $today; ?>">
        </label><br><br>

        <label>
          <span class="typeKITAtime">Delivery</span> Time

          <div>
            <select class="w3-border w3-border-grey w3-round-small w3-left HOUR" style="padding:8px;margin-right:5px">
              <?php 
              for ($i=1; $i <= 12; $i++) { ?>

              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php
              }
              ?>
            </select>

            <select class="w3-border w3-border-grey w3-round-small w3-left MINUTE" style="padding:8px;margin-right:5px">
              <option value="00">00</option>
              <?php 
              for ($i=15; $i <= 60; $i++) {
                if ($i % 15 == 0) { ?>
                  <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php
                }
              }
              ?>
            </select>

            <select class="w3-border w3-border-grey w3-round-small w3-left AMPM" style="padding:8px;margin-right:5px">
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
        </label>

      </div>
    </div>
      
  </fieldset>

  <fieldset class="w3-border-blue w3-border w3-margin delivery_details_only" style="display:block">
    <legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Delivery Details</legend>

    <div class="w3-padding" style="color:#555">
      <p class="w3-text-red">Note: The delivery is in Aurora, Zamboanga del Sur only.</p><br>

      <label>Customer's Name <br>
        <input type="text" class="w3-input w3-border w3-border-grey w3-round-small delivery_personName" style="width:400px" placeholder="Type name">
      </label><br><br>

      <label>Contact <br>
        <input type="tel" class="w3-input w3-border w3-border-grey w3-round-small delivery_personContact" style="width:400px" placeholder="Type contact number">
      </label><br><br>

      <label>Barangay <br>
        <select class="w3-border w3-border-grey w3-round-small BARANGAY w3-select" style="padding:8px;color:#555;width:400px">
          <option value="">--select--</option>
          <?php 
            $q = mysqli_query($conn,"SELECT * FROM barangay_delivery");
            while ($qq = mysqli_fetch_array($q)) { ?>
          <option value="<?php echo $qq['bd_id'] ?>"><?php echo $qq['barangay'] ?></option>
          <?php   
            }
          ?>
        </select><br>
        <span style="font-weight:normal;" class="text-danger charge"></span>
      </label><br><br>

      <label>
        House Number / Street
        <input type="text" class="w3-input w3-border w3-border-grey w3-round-small HOUSESTREET" style="width:400px">
      </label>
    </div>
      
  </fieldset>

  <fieldset class="w3-border-blue w3-border w3-margin pickup_details_only" style="display:none">
    <legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0"><span class="type_details">Pick up</span> Details</legend>

    <div class="w3-padding" style="color:#555">
      <label>Customer's Name<br>
        <input type="text" class="w3-input w3-border w3-border-grey w3-round-small person_NAME" placeholder="Name" style="width:400px">
      </label><br><br>
      <label>
        Contact Number
        <input type="text" class="w3-input w3-border w3-border-grey w3-round-small contact_person" style="width:400px">
      </label>
    </div>

  </fieldset>

  <!--Senior citizen-->
  <fieldset class="w3-border-blue w3-border w3-margin sasasaa">
    <legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">For senior citizen</legend>

    <div class="w3-padding" style="color:#555">
      <label>
        <?php  
        $q = mysqli_query($conn,"SELECT * FROM dis_senior");
        $qq = mysqli_fetch_array($q);
        ?>
        Discount of <?php echo $qq['discount'] * 100 ?>%<br>
        <input type="checkbox" class="w3-check senior" value="<?php echo $qq['discount'] ?>">
        If senior citizen please check this checkbox.
      </label><br>
    </div>
      
  </fieldset>

  <fieldset class="w3-border-blue w3-border w3-margin sasasaa">
    <legend class="w3-text-blue" style="padding:0 10px;font-size:16px;width: auto;margin:0">Mode of Payment</legend>

    <div class="w3-padding" style="color:#555">
      <label>Mode of payment <br>
        <select class="w3-border w3-border-grey w3-round-small MODEofPAYMENT w3-select" style="padding:8px;color:#555;width:400px">
          <option value="">--select--</option>
          <option value="Cash">Cash</option>
        </select>
      </label><br>
    </div>
      
  </fieldset>

  <fieldset class="w3-border-0 w3-margin sasasaa">

    <div class="w3-padding" style="color:#555">
      <button class="w3-btn w3-round-small w3-green submitDELIVERY" style="display:block;">Submit</button>
      <button class="w3-btn w3-round-small w3-green submitDINEIN" style="display:none;">Submit</button>
      <button class="w3-btn w3-round-small w3-green submitTAKEOUT" style="display:none;">Submit</button>
      <button class="w3-btn w3-round-small w3-green submitPICKUP" style="display:none;">Submit</button>
    </div>
      
  </fieldset>
        </div>
      </div>
    </div>

    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>
        var totalSeniorDiscount = "<?php echo $total - ($total*$qq['discount']) ?>";
        var totalJunior = "<?php echo $total ?>";
    $(document).ready(function(){

      $("#tran_date").datepicker();

  $(".order_type").click(function(){
    var order_type = $(this).val();
    if (order_type == "delivery") {

      $(".delivery_details_only").show();
      $(".pickup_details_only").hide();

      $(".typeKITA").text('Delivery');
      $(".typeKITAtime").text('Delivery');

      $(".submitDELIVERY").show();
      $(".submitTAKEOUT").hide();
      $(".submitPICKUP").hide();
      $(".submitDINEIN").hide();
    } 
    else if (order_type == "dinein") {

      $(".delivery_details_only").hide();
      $(".pickup_details_only").show();

      $(".submitDINEIN").show();
      $(".submitTAKEOUT").hide();
      $(".submitPICKUP").hide();
      $(".submitDELIVERY").hide();

      $(".typeKITA").text('Dine-in');
      $(".typeKITAtime").text('Dine-in');

      $(".type_details").text('Dine-in');
    } 
    else if (order_type == "takeout") {

      $(".delivery_details_only").hide();
      $(".pickup_details_only").show();

      $(".submitTAKEOUT").show();
      $(".submitDINEIN").hide();
      $(".submitPICKUP").hide();
      $(".submitDELIVERY").hide();

      $(".typeKITA").text('Take out');
      $(".typeKITAtime").text('Take out');

      $(".type_details").text('Take out');
    } 
    else if (order_type == "pickup") {

      $(".delivery_details_only").hide();
      $(".pickup_details_only").show();

      $(".submitPICKUP").show();
      $(".submitTAKEOUT").hide();
      $(".submitDINEIN").hide();
      $(".submitDELIVERY").hide();

      $(".typeKITA").text('Pick up');
      $(".typeKITAtime").text('Pick up');
       $(".type_details").text('Pick up');
    }
  });

  $(".BARANGAY").change(function(){
    var bd_id = $(this).val();

    $.ajax({
      url: "../includes/deliv_charge.inc.php",
      method:"POST",
      data: {
        bd_id: bd_id
      },
      success: function(data){
        $(".charge").text('Delivery Charge of '+data);
      }
    });
  });


  $('.submitDELIVERY').click(function(){

    var DELIVERY = $("#DELIVERY").val();
    var DELIVERY_date = $("#tran_date").val();
    var HOUR = $(".HOUR").val();
    var MINUTE = $(".MINUTE").val();
    var AMPM = $(".AMPM").val();
    var BARANGAY = $(".BARANGAY").val();
    var HOUSESTREET = $(".HOUSESTREET").val();
    var delivery_personName = $(".delivery_personName").val();
    var delivery_personContact = $(".delivery_personContact").val();
    var MODEofPAYMENT = $(".MODEofPAYMENT").val();
    var seniorDiscount = $(".senior").val();

    var submitDELIVERYsenior = "submitdiscount"; 
    var submitDELIVERYjunior = "submitjunior"; 

    if (DELIVERY_date == "" || MODEofPAYMENT == "" || BARANGAY == "" || HOUSESTREET == "" || delivery_personName == "" || delivery_personContact == "") {
      alert("Pease fill in completely!");
    } else {
      if($(".senior").is(":checked")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              DELIVERY_date: DELIVERY_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitDELIVERYsenior: submitDELIVERYsenior,
              BARANGAY: BARANGAY,
              HOUSESTREET: HOUSESTREET,
              AMPM: AMPM,
              delivery_personName: delivery_personName,
              delivery_personContact: delivery_personContact,
              seniorDiscount: seniorDiscount
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
                if (data.required) {
                  alert(data.required);
                }
              }
            }
          });
      }
      else if($(".senior").is(":not(:checked)")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              DELIVERY_date: DELIVERY_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitDELIVERYjunior: submitDELIVERYjunior,
              BARANGAY: BARANGAY,
              HOUSESTREET: HOUSESTREET,
              AMPM: AMPM,
              delivery_personName: delivery_personName,
              delivery_personContact: delivery_personContact
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
                if (data.required) {
                  alert(data.required);
                }
              }
            }
          });
      }
    }
  }); 

  $('.submitDINEIN').click(function(){

    var DINEIN_date = $("#tran_date").val();
    var HOUR = $(".HOUR").val();
    var MINUTE = $(".MINUTE").val();
    var AMPM = $(".AMPM").val();

    var person_NAME = $(".person_NAME").val();
    var contact_person = $(".contact_person").val();
    var MODEofPAYMENT = $(".MODEofPAYMENT").val();
    var seniorDiscount = $(".senior").val();

    var submitDINEINsenior = "submitdiscountDINEIN"; 
    var submitDINEINjunior = "submitjuniorDINEIN"; 

    if (DINEIN_date == "" || MODEofPAYMENT == "") {
      alert("Pease fill in completely!");
    } else {
      if($(".senior").is(":checked")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              DINEIN_date: DINEIN_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitDINEINsenior: submitDINEINsenior,
              AMPM: AMPM,
              person_NAME: person_NAME,
              contact_person: contact_person,
              seniorDiscount: seniorDiscount
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
              }
            }
          });
      }
      else if($(".senior").is(":not(:checked)")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              DINEIN_date: DINEIN_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitDINEINjunior: submitDINEINjunior,
              AMPM: AMPM,
              person_NAME: person_NAME,
              contact_person: contact_person
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
              }
            }
          });
      }
    }
  }); 

  $('.submitPICKUP').click(function(){

    var PICKUP_date = $("#tran_date").val();
    var HOUR = $(".HOUR").val();
    var MINUTE = $(".MINUTE").val();
    var AMPM = $(".AMPM").val();

    var person_NAME = $(".person_NAME").val();
    var contact_person = $(".contact_person").val();
    var MODEofPAYMENT = $(".MODEofPAYMENT").val();
    var seniorDiscount = $(".senior").val();

    var submitPICKUPsenior = "submitdiscountPICKUP"; 
    var submitPICKUPjunior = "submitjuniorPICKUP"; 

    if (PICKUP_date == "" || MODEofPAYMENT == "") {
      alert("Pease fill in completely!");
    } else {
      if($(".senior").is(":checked")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              PICKUP_date: PICKUP_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitPICKUPsenior: submitPICKUPsenior,
              AMPM: AMPM,
              person_NAME: person_NAME,
              contact_person: contact_person,
              seniorDiscount: seniorDiscount
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
              }
            }
          });
      }
      else if($(".senior").is(":not(:checked)")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              PICKUP_date: PICKUP_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitPICKUPjunior: submitPICKUPjunior,
              AMPM: AMPM,
              person_NAME: person_NAME,
              contact_person: contact_person
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
              }
            }
          });
      }
    }
  });
  

  $('.submitTAKEOUT').click(function(){

    var TAKE_date = $("#tran_date").val();
    var HOUR = $(".HOUR").val();
    var MINUTE = $(".MINUTE").val();
    var AMPM = $(".AMPM").val();

    var person_NAME = $(".person_NAME").val();
    var contact_person = $(".contact_person").val();
    var MODEofPAYMENT = $(".MODEofPAYMENT").val();
    var seniorDiscount = $(".senior").val();

    var submitTAKEOUTsenior = "submitdiscountTAKEOUT"; 
    var submitTAKEOUTjunior = "submitjuniorTAKEOUT"; 

    if (TAKE_date == "" || MODEofPAYMENT == "") {
      alert("Pease fill in completely!");
    } else {
      if($(".senior").is(":checked")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              TAKE_date: TAKE_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitTAKEOUTsenior: submitTAKEOUTsenior,
              AMPM: AMPM,
              person_NAME: person_NAME,
              contact_person: contact_person,
              seniorDiscount: seniorDiscount
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
              }
            }
          });
      }
      else if($(".senior").is(":not(:checked)")){
          $.ajax({
            url: "include/place_order.inc.php",
            method: "POST",
            dataType: "JSON",
            data: {
              TAKE_date: TAKE_date,
              HOUR: HOUR,
              MINUTE: MINUTE,
              MODEofPAYMENT: MODEofPAYMENT,
              submitTAKEOUTjunior: submitTAKEOUTjunior,
              AMPM: AMPM,
              person_NAME: person_NAME,
              contact_person: contact_person
            },
            success: function (data) {
              if (data.success == "Your order was successfully done!\nThank you.") {
                alert(data.success);
                location = "order_view.php?id="+data.order_id;
              } else {
                if (data.invalid) {
                  alert(data.invalid);
                }
              }
            }
          });
      }
    }
  });



    });

    </script>
  </body>
</html>
