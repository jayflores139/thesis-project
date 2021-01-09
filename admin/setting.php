<?php
  include '../includes/connect.php';
  session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
    <meta charset="utf-8">
    <?php include 'include/link.php'; ?>
    <style>
        .action:hover{
            opacity:0.8;
        }
    </style>
  </head>
  <body>
    <?php include 'include/header.php'; ?>

    <div class="right-fixed w3-white">
      <h2 style="color:#333">Settings</h2>

      <fieldset class="w3-margin-top">
        <legend style="width:auto;font-size:12px">
          <ul class="w3-navbar nav-top">
            <li class="w3-padding-0"><a href="setting.php?p=downpayment" style="margin:2px" class="btn btn-default <?php if ($_GET['p'] == 'downpayment') { echo 'w3-light-grey'; } ?>">Reservation</a></li>
            <li class="w3-padding-0"><a href="setting.php?p=category" style="margin:2px" class="btn btn-default <?php if ($_GET['p'] == 'category') { echo 'w3-light-grey'; } ?>">Food Category</a></li>
            <li class="w3-padding-0"><a href="setting.php?p=type" style="margin:2px" class="btn btn-default <?php if ($_GET['p'] == 'type') { echo 'w3-light-grey'; } ?>">Food Type</a></li>
            <li class="w3-padding-0"><a href="setting.php?p=barangay" style="margin:2px" class="btn btn-default <?php if ($_GET['p'] == 'barangay') { echo 'w3-light-grey'; } ?>">Barangay Delivery</a></li>
            <li class="w3-padding-0"><a href="setting.php?p=senior" style="margin:2px" class="btn btn-default <?php if ($_GET['p'] == 'senior') { echo 'w3-light-grey'; } ?>">Senior Citizen Discount</a></li>
          </ul>
        </legend>

        <?php  
        if (isset($_GET['p'])) {
          if ($_GET['p'] == 'downpayment') { ?>
            
            <div class="w3-margin-left">

              <?php  
              $q = mysqli_query($conn,"SELECT * FROM downpayment");
              $qq = mysqli_fetch_array($q);
              ?>
              <label style="font-size:12px;font-weight:normal;" >Downpayment in percent (%)
              <input type="number" class="w3-input w3-border"  id="downpayment" value="<?php echo $qq['d_price'] * 100 ?>">
              </label>
              <input type="button" id="submit_downpayment" class="w3-btn w3-blue" value="Edit"> <br>
            </div>

         <?php   
          } elseif ($_GET['p'] == 'type') { ?>
            
            <div class="w3-margin-left">     

                <table style="width:80%" class="w3-margin-bottom">
                  <tr>
                    <td>
                      <label style="font-size:12px;font-weight:normal;" >Food Type</label>
                      <input type="text" id="food_type" style="width:98%" placeholder="Food Type" class="w3-input w3-border">
                    </td>
                    <td>
                      <label style="font-size:12px;font-weight:normal;" >Category</label>
                      <?php  
                      $w = mysqli_query($conn,"SELECT * FROM category"); ?>
                      <select class="w3-input w3-border w3-padding" id="type_cat" style="width:98%">
                        <option value="">--Select Category--</option>
                        <?php
                         while ($ww = mysqli_fetch_array($w)) { 
                          echo '<option value="'.$ww['cat_id'].'">'.$ww['cat_name'].'</option>';
                        }
                      ?>
                      </select>
                    </td>
                    <td>
                      <input type="button" id="submit_add_type" style="margin-top:25px" class="w3-btn w3-blue w3-padding" value="Add">

                      <input type="hidden" id="type_id_hidden">
                      <input type="button" id="submit_edit_type" style="display: none;margin-top:25px" class="w3-btn w3-blue w3-padding" value="Edit">
                    </td>
                  </tr>
                </table>

              <table class="w3-striped">
                <tr class="w3-text-blue">
                  <td class="w3-padding">Food Type</td>
                  <td class="w3-padding">Category</td>
                  <td class="w3-padding">Action</td>
                </tr>
                <?php  
                $w = mysqli_query($conn,"SELECT * FROM category");
                while ($ww = mysqli_fetch_array($w)) {
                  
                  $e = mysqli_query($conn,"SELECT * FROM food_type where cat_id = '".$ww['cat_id']."' ");

                  while ($ee = mysqli_fetch_array($e)) { ?>
                   <tr id="removeRowType<?php echo $ee['type_id'] ?>">
                    <td class="w3-padding"><?php echo $ee['type_name'] ?></td>
                    <td class="w3-padding"><?php echo $ww['cat_name'] ?></td>
                    <td class="w3-padding">
                      <button id="<?php echo $ee['type_id'] ?>" class="action edit_food_type w3-flat-silver btn btn-default"><i class="fas fa-pencil-alt"></i> Edit</button>
                      <button id="<?php echo $ee['type_id'] ?>" class="action delete_food_type w3-flat-silver btn btn-default"><i class="fas fa-trash-alt"></i> Delete</button>
                    </td>
                  </tr>
                  <?php 
                  }
                }
                ?>
              </table>
            </div>

         <?php   
          } elseif ($_GET['p'] == 'category') { ?>
            
                <div class="w3-margin-left">  

                    <input type="text" id="food_categor" style="width:40%;float:left" placeholder="Food Category" class="w3-input w3-border">
                    <input type="hidden" id="cat_id">

                    <label style="font-size:12px;font-weight:normal;" class="w3-text-white">Category</label>
                    <input type="submit" id="submit_add_cat" style="float:left;margin-left:10px" class="w3-btn w3-blue w3-padding w3-margin-bottom" value="Add">
                    <input type="submit" id="submit_edit_cat" style="float:left;margin-left:10px;display: none" class="w3-btn w3-blue w3-padding w3-margin-bottom" value="Edit">

                  <table class="w3-striped w3-center w3-border-top">
                    <tr class="w3-text-blue">
                      <td class="w3-padding">Category</td>
                      <td class="w3-padding">Action</td>
                    </tr>
                    <?php  
                    $w = mysqli_query($conn,"SELECT * FROM category");
                    while ($ww = mysqli_fetch_array($w)) { ?>
                       <tr id="removeRowCat<?php echo $ww['cat_id'] ?>">
                        <td class="w3-padding"><?php echo $ww['cat_name'] ?></td>
                        <td class="w3-padding">
                          <button id="<?php echo $ww['cat_id'] ?>" class="action edit_category btn btn-default"><i class="fas fa-pencil-alt"></i> Edit</button>
                          <button id="<?php echo $ww['cat_id'] ?>" class="action delete_category btn btn-default"><i class="fas fa-trash-alt"></i> Delete</button>
                        </td>
                      </tr>
                      <?php 
                    }
                    ?>
                  </table>
                </div>

         <?php   
          } elseif ($_GET['p'] == 'barangay') { ?>
            
                <div class="w3-margin-left">     

                    <table style="width:80%" class="w3-margin-bottom">
                      <tr>
                        <td>
                          <label style="font-size:12px;font-weight:normal;" >Barangay</label>
                          <input type="text" id="barangay_input" style="width:97%" placeholder="Barangay" class="w3-input w3-border">
                        </td>
                        <td>
                          <label style="font-size:12px;font-weight:normal;" >Delivery Charge</label>
                          <input type="number" id="charge_input" style="width:50%" placeholder="Delivery Charge" class="w3-input w3-border">
                            <input type="hidden" id="bd_id">
                        </td>
                        <td>
                          <label style="font-size:12px;font-weight:normal;" class="w3-text-white">Category</label>
                          <button class="w3-padding w3-input w3-blue w3-btn" id="submit_barangay_add">Add</button>
                          <button class="w3-padding w3-input w3-blue w3-btn" id="submit_barangay_edit" style="display: none">Edit</button>
                        </td>
                      </tr>
                    </table>

                  <table class="w3-striped w3-center w3-border-top">
                    <tr class="w3-text-blue">
                      <td class="w3-padding">Barangay</td>
                      <td class="w3-padding">Delivery Charge</td>
                      <td class="w3-padding">Action</td>
                    </tr>
                    <?php  
                    $w = mysqli_query($conn,"SELECT * FROM barangay_delivery");
                    while ($ww = mysqli_fetch_array($w)) { ?>
                       <tr id="removeRow<?php echo $ww['bd_id'] ?>">
                        <td class="w3-padding"><?php echo $ww['barangay'] ?></td>
                        <td class="w3-padding">P <?php echo number_format($ww['deliv_charge'],2) ?></td>
                        <td class="w3-padding" >
                          <button id="<?php echo $ww['bd_id'] ?>" class="action edit btn btn-default"><i class="fas fa-pencil-alt"></i> Edit</button>
                          <button id="<?php echo $ww['bd_id'] ?>" class="action delete_barangay btn btn-default"><i class="fas fa-trash-alt"></i> Delete</button>
                        </td>
                      </tr>
                      <?php 
                    }
                    ?>
                  </table>
                </div>

         <?php   
          } elseif ($_GET['p'] == 'senior') { ?>
            
              <div class="w3-margin-left">
                <form id="senior-form">
                  <?php  
                  $q = mysqli_query($conn,"SELECT * FROM dis_senior");
                  $qq = mysqli_fetch_array($q);
                  ?>
                  <label style="font-size:12px;font-weight:normal;" >Senior Citizen Discount in percent (%)</label>
                  <input type="number" class="w3-input w3-border" style="width:24%" id="discount" value="<?php echo $qq['discount'] * 100 ?>"><br>
                  <input type="submit" id="submit" class="w3-btn w3-blue" value="Edit">
                </form>  
              </div>

         <?php   
          }
        } else {
            echo '<script>location="index.php"</script>';
          }
        ?>

      </fieldset>

    </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script>

      $(document).ready(function(){

        $("#senior-form").submit(function(event) {
          event.preventDefault();
          var discount = $("#discount").val();
          var submit = $("#submit").val();

            $.ajax({
              url: "include/setting-senior.php",
              method: "POST",
              data: {
                discount: discount,
                submit: submit
              },
              success: function(data) {
                if (data == "Updated") {
                  location.reload();
                }
              }
            });

        });

////////////Barangay settings
        $(".edit").on("click", function(){
          var id = $(this).attr("id");

          $("#bd_id").val(id);

           $.ajax({
              url: "include/setting-barangay.php",
              method: "POST",
              dataType: "JSON",
              data: {
                id: id
              },
              success: function(data) {
               $("#barangay_input").val(data.barangay);
               $("#charge_input").val(data.charge);
               $("#submit_barangay").text("Edit");
               $("#submit_barangay_edit").show();
               $("#submit_barangay_add").hide();
              }
        });
      });

      $("#submit_barangay_add").on("click", function() {
        var barangay = $("#barangay_input").val();
        var charge = $("#charge_input").val();
        var submit_add = $(this).val();

        if ((barangay == "" && charge =="") || (barangay == "" || charge =="")) {
          location.reload();
        } else {
          $.ajax({
            url: "include/setting-barangay.php",
            method: "POST",
            data: {
              barangay: barangay,
              charge: charge,
              submit_add: submit_add
            },
            success: function(data) {
             if (data == "Inserted") {
              location.reload();
             }
            }
          });
        }
      }); 

      $("#submit_barangay_edit").on("click", function() {
        var barangay = $("#barangay_input").val();
        var charge = $("#charge_input").val();
        var submit_edit = $(this).val();
        var bd_id_edit = $("#bd_id").val();

        if ((barangay == "" && charge =="") || (barangay == "" || charge =="")) {
          location.reload();
        } else {
          $.ajax({
            url: "include/setting-barangay.php",
            method: "POST",
            data: {
              barangay: barangay,
              charge: charge,
              submit_edit: submit_edit,
              bd_id_edit: bd_id_edit
            },
            success: function(data) {
             if (data == "Updated") {
              location.reload();
             }
            }
          });
        }
      }); 

      $(".delete_barangay").on("click", function() {
        var bd_id = $(this).attr("id");

         if (confirm("Are you sure?") == true) {
            $.ajax({
              url: "include/setting-barangay.php",
              method: "POST",
              data: {
                bd_id: bd_id
              },
              success: function(data){
                if (data == "Deleted") {
                  $("#removeRow"+bd_id).remove();
                }
              }
            });
         }        
      });
//End Barangay 

//Start category
      $("#submit_add_cat").on("click", function(){
        var food_categor = $("#food_categor").val();
        var submit = $(this).val();
        if (food_categor == "") {
          location.reload();
        } else {
          $.ajax({
            url: "include/setting-category.php",
            method: "POST",
            data: {
              food_categor: food_categor,
              submit: submit
            },
            success: function(data) {
              if (data == "Inserted") {
                location.reload();
              }
            }
          })
        }
      });
      $(".edit_category").on("click", function(){
        $("#submit_edit_cat").show();
        $("#submit_add_cat").hide();
        var submit_edit_cat = $("#submit_edit_cat").val();
        var cat_id = $(this).attr("id");
        var cat_id_hidden = $("#cat_id").val(cat_id);
        if (food_categor == "") {
          location.reload();
        } else {
          $.ajax({
            url: "include/setting-category.php",
            method: "POST",
            data: {
              submit_edit_cat: submit_edit_cat,
              cat_id: cat_id
            },
            success: function(data) {
              $("#food_categor").val(data);
            }
          })
        }
      });
      $("#submit_edit_cat").on("click", function(){
        var food_categor = $("#food_categor").val();
        var submit_edit = $(this).val();
        var cat_id = $("#cat_id").val();
        if (food_categor == "") {
          location.reload();
        } else {
          $.ajax({
            url: "include/setting-category.php",
            method: "POST",
            data: {
              food_categor: food_categor,
              submit_edit: submit_edit,
              cat_id: cat_id
            },
            success: function(data) {
              if (data == "Updated") {
                location.reload();
              }
            }
          })
        }
      });
     $(".delete_category").on("click", function(){
        var cat_id_delete = $(this).attr("id");
        if (confirm("Are you sure?") == true) {
          $.ajax({
            url: "include/setting-category.php",
            method: "POST",
            data: {
              cat_id_delete: cat_id_delete
            },
            success: function(data) {
              if (data == "Deleted") {
                $("#removeRowCat"+cat_id_delete).remove();
              }
            }
          });
        }
      });
//End category

//Start Food Type
      $(".delete_food_type").on("click", function(){
        var type_id = $(this).attr("id");

        if (confirm("Are you sure?") == true) {
          $.ajax({
            url: "include/setting-type.php",
            method: "POST",
            data: {type_id: type_id},
            success: function(data){
              if (data == "Deleted") {
                $("#removeRowType"+type_id).remove();
              }
            }
          })
        }
      });

  
      $("#submit_add_type").click(function(){
        var food_type = $("#food_type").val();
        var type_cat = $("#type_cat").val();
        var submitAdd = $(this).val();

        if (food_type == "" || type_cat == "") {
          location.reload();
        } else {
          $.ajax({
            url: "include/setting-type.php",
            method:"POST",
            data:{
              food_type: food_type,
              type_cat: type_cat,
              submitAdd: submitAdd
            },
            success: function(data){
              if (data == "Inserted") {
                location.reload();
              }
            }
          })
        }
      });


      $(".edit_food_type").click(function(){
        var type_id_edit = $(this).attr("id");

        $("#submit_add_type").hide();
        $("#submit_edit_type").show();
        $("#type_id_hidden").val(type_id_edit);

        $.ajax({
          url: "include/setting-type.php",
          method:"POST",
          dataType: "JSON",
          data:{
            type_id_edit: type_id_edit
          },
          success: function(data){
            $("#food_type").val(data.food_type);
            $("#type_cat").html(data.type_cat);
          } 
        });
      });

      $("#submit_edit_type").click(function(){

        var food_type = $("#food_type").val();
        var submitEdit = $(this).val();
        var type_id_edit = $("#type_id_hidden").val();

        if (food_type == "") {
          location.reload();
        } else {
          $.ajax({
            url: "include/special.php",
            method:"POST",
            data: {
              food_type: food_type,
              submitEdit: submitEdit,
              type_id_edit: type_id_edit
            },
            success: function(data){
              if (data == "Updated") {
                location.reload();
              }
            }
          });
        }
      });
//End Food Type 

//Start Downpayment

    $("#submit_downpayment").on("click", function(){

      var downpayment = $("#downpayment").val();

      $.ajax({
        url: "include/downpayment.inc.php",
        method: "POST",
        data: {downpayment: downpayment},
        success: function(data){
          if (data == "Updated") {
            alert("Update successfully!");
          }
        }
      });

    });
    
      });
    </script>
  </body>
</html>
