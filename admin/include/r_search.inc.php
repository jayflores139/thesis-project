<?php  
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['submit_search'])) {
		
    $datesasaass = $_POST['datesasaass'];
    $cu_name = $_POST['cu_name'];

    $date = date("Y-m-d", strtotime($datesasaass));

  if (!empty($datesasaass) && empty($cu_name)) { ?>
       
       <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_date_from = '$date' or r_date_to = '$date' ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">
              
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>
              
            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
          }
      } elseif (!empty($datesasaass) && !empty($cu_name)) { ?>
       
       <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where (r_date_from = '$date' or r_date_to = '$date') and (cu_first like '%$cu_name%' or cu_last = '%$cu_name%') ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">
             
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>

            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
          }
      } elseif (empty($datesasaass) && !empty($cu_name)) { ?>
       
       <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where cu_first like '%$cu_name%' or cu_last like '%$cu_name%' ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">
                
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>

            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
          }
      }elseif (empty($datesasaass) && !empty($cu_name)) { ?>
       
       <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where cu_first like '%$cu_name%' or cu_last like '%$cu_name%' ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">
                
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>

            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
          }
      } elseif ( !empty($datesasaass) && empty($cu_name)) { ?>
       
       <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_date_from = '$date' or r_date_to = '$date' ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">
              
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>

            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
          }
      } elseif (!empty($datesasaass) && !empty($cu_name)) { ?>
       
       <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where (r_date_from = '$date' or r_date_to = '$date') and (cu_first like '%$cu_name%' or cu_last = '%$cu_name%') ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">

             <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>

            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
          }
      } 
	}

  if (isset($_POST['status'])) {
      $status = $_POST['status']; ?>

      <tr class="w3-border w3-text-blue">
          <td class="w3-padding-medium">Date Reserved</td>
          <td>Customer</td>
          <td>Occasion</td>
          <td colspan="2">Booking Date</td>
          <td>Payable</td>
          <td>Downpayment</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php  

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_status='$status' ");
        if (mysqli_num_rows($q) > 0) {
          while ($qq = mysqli_fetch_array($q)) { ?>
        
           <tr class="w3-border" id="removeRow2<?php echo $qq['rid'] ?>">
            <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($qq['date_reserved'])) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['cu_first'].' '.$qq['cu_last'] ?></td>
            <td class="w3-padding-medium">
              <?php  
              $w = mysqli_query($conn,"SELECT * FROM catering where cater_id = '".$qq['cater_id']."' ");
              $ww = mysqli_fetch_array($w);
              echo $ww['event_name'];
              ?>
            </td>
            <td class="w3-padding-medium" colspan="2"><?php echo date("M d, Y", strtotime($qq['r_date_from'])).' -- '.date("M d, Y", strtotime($qq['r_date_to'])) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['payable'],2) ?></td>
            <td class="w3-padding-medium">P <?php echo number_format($qq['downpayment'],2) ?></td>
            <td class="w3-padding-medium"><?php echo $qq['r_status'] ?></td>
            <td class="w3-padding-medium">

              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="btn btn-default">
                  <i class="fas fa-search"></i> view
                </button>
              </a>
              <input type="hidden" id="rid<?php echo $qq['rid'] ?>" value="<?php echo $qq['rid'] ?>" >
              <button id="<?php echo $qq['rid'] ?>" class="delete btn btn-default">
                <i class="fas fa-trash-alt"></i> delete
              </button>

            </td>
          </tr>

          <?php
          }
        } else {
            echo '
            <tr>
            <td class="w3-padding" colspan="9">No reservation found.</td>
            </tr>
            ';
        }
  }
?>

<script>
  $(".delete").click(function(){
    var delelte = $(this).attr("id");

    if (confirm("Are you sure?") == true) {
      $.ajax({
        url: "include/r_delete.inc.php",
        method:"POST",
        data:{delelte: delelte},
        success:function(data){
          if (data == "Deleted") {
            $("#removeRow2"+delelte).remove();
          }
        }
      });
    }
  });
</script>