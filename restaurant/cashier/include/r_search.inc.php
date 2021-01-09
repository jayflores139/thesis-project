<?php  
	include '../../includes/connect.php';
	session_start();

	if (isset($_POST['submit_search'])) {
		
    $change_reservation = $_POST['change_reservation'];
    $datesasaass = $_POST['datesasaass'];
    $cu_name = $_POST['cu_name'];

    $date = date("Y-m-d", strtotime($datesasaass));

    if (!empty($change_reservation) && empty($datesasaass) && empty($cu_name)) { ?>
       
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

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_status = '$change_reservation' ");
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
      } elseif (empty($change_reservation) && !empty($datesasaass) && empty($cu_name)) { ?>
       
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
      } elseif (empty($change_reservation) && !empty($datesasaass) && !empty($cu_name)) { ?>
       
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
      } elseif (empty($change_reservation) && empty($datesasaass) && !empty($cu_name)) { ?>
       
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
      }elseif (!empty($change_reservation) && empty($datesasaass) && !empty($cu_name)) { ?>
       
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

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_status = '$change_reservation' and (cu_first like '%$cu_name%' or cu_last like '%$cu_name%') ");
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
      } elseif (!empty($change_reservation) && !empty($datesasaass) && empty($cu_name)) { ?>
       
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

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_status = '$change_reservation' and (r_date_from = '$date' or r_date_to = '$date') ");
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
      } elseif (!empty($change_reservation) && !empty($datesasaass) && !empty($cu_name)) { ?>
       
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

        $q = mysqli_query($conn,"SELECT * FROM reservation where r_status = '$change_reservation' and (r_date_from = '$date' or r_date_to = '$date') and (cu_first like '%$cu_name%' or cu_last = '%$cu_name%') ");
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
              <?php 

              if ($qq['r_status'] == "pending" || $qq['r_status'] == "approve") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
             <?php   
              } elseif ($qq['r_status'] == "cancel" || $qq['r_status'] == "finish") { ?>
              <a href="reservation_view.php?rid=<?php echo $qq['rid'] ?>">
                <button class="w3-light-grey w3-left w3-border-0 w3-hover-grey" style="height:35px;margin-right:3px;width:35px">
                  <i class="fas fa-eye"></i>
                </button>
              </a>
              <?php
              }

               ?>
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
?>