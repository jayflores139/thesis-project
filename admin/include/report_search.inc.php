<?php 
session_start();
include '../../includes/connect.php';

	if (isset($_POST['submit_filter'])) {
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];


		if (!empty($date_to) && !empty($date_from)) {
			$date_from = date("Y-m-d", strtotime($date_from));
			$date_to = date("Y-m-d", strtotime($date_to));

			$date_to_str_from = date("F d, Y", strtotime($date_from));
			$date_to_str_to = date("F d, Y", strtotime($date_to));

		echo  '
		<table class="w3-striped w3-text-black w3-centered">
			<tr class="w3-text-blue">
			  <td class="w3-padding-medium">Date</td>
			  <td>Food Menu</td>
			  <td>Price</td>
			  <td>Total Quantity</td>
			  <td align="center" style="padding-right:5px;">Amount</td>
			</tr>
		';
 
    $now = date("Y-m-d");
    $nowto = date("Y-m-d", strtotime($now."+ 30 days"));

    $q = mysqli_query($conn,"SELECT * FROM food_menu order by food_name");

    $grand = 0;
    while ($qq = mysqli_fetch_array($q)) { 
    	echo '<tr>';

      $w = mysqli_query($conn,"SELECT sum(food_order_details.food_qty) as totalQty, food_order.curr_order_date FROM food_order_details inner join food_order 
                  where food_order.order_id=food_order_details.order_id 
                  and ( food_order.status='approve' and (food_order.curr_order_date between '$date_from' and '$date_to')) 
                  and food_order_details.food_id='".$qq['food_id']."' ") or die(mysqli_error($conn));

      if (mysqli_num_rows($w) > 0) {
        $total = 0;
        while ($ww = mysqli_fetch_array($w)) { 
        	echo '
        		<td class="w3-padding-medium">'.date("M d, Y", strtotime($date_from)).date(" - M d, Y", strtotime($date_to)).'</td>
		        <td>'.$qq['food_name'].'</td>
		        <td>P '.number_format($qq['price'],2).'</td>  
		        <td> '.'('.$ww['totalQty'].')'.'</td> 
        	';

      $total += $qq['price'] * $ww['totalQty'];
        } 
        echo '<td>P '.number_format($total,2).'</td>';     
      }
      $grand += $total;
      echo '</tr>';
    }
    echo '
    	<tr class=" w3-flat-midnight-blue">
	      <td colspan="6" class="w3-padding" style="text-align:right;font-size:19px">GRAND TOTAL: P '.number_format($grand,2).'</td>
	    </tr>
	    </table>
    ';    

    	/*$array = array(
    		'table' => $table,
    		'date_to' => $date_to_str_to,
    		'date_from' => $date_to_str_from
    	);
    	echo json_encode($array); */
    		
		} elseif (!empty($date_from)) {
			$date_from_sp = date("Y-m-d", strtotime($date_from));

		echo '
		<table class="w3-striped w3-text-black w3-centered">
			<tr class="w3-text-blue">
			  <td class="w3-padding-medium">Date</td>
			  <td>Food Menu</td>
			  <td>Price</td>
			  <td>Total Quantity</td>
			  <td align="center" style="padding-right:5px;">Amount</td>
			</tr>
		';
 
    $now = date("Y-m-d");
    $nowto = date("Y-m-d", strtotime($now."+ 30 days"));

    $q = mysqli_query($conn,"SELECT * FROM food_menu order by food_name");

    $grand = 0;
    while ($qq = mysqli_fetch_array($q)) { 
    	echo '<tr>';

      $w = mysqli_query($conn,"SELECT sum(food_order_details.food_qty) as totalQty, food_order.curr_order_date FROM food_order_details inner join food_order 
                  where food_order.order_id=food_order_details.order_id 
                  and ( food_order.status='approve' and food_order.curr_order_date='$date_from_sp') 
                  and food_order_details.food_id='".$qq['food_id']."' ") or die(mysqli_error($conn));

      if (mysqli_num_rows($w) > 0) {
        $total = 0;
        while ($ww = mysqli_fetch_array($w)) { 
        	echo '
        		<td class="w3-padding-medium">'.date("M d, Y", strtotime($date_from)).'</td>
		        <td>'.$qq['food_name'].'</td>
		        <td>P '.number_format($qq['price'],2).'</td>  
		        <td> '.'('.$ww['totalQty'].')'.'</td> 
        	';

      $total += $qq['price'] * $ww['totalQty'];
        } 
        echo '<td>P '.number_format($total,2).'</td>';     
      }
      $grand += $total;
      echo '</tr>';
    }
    echo '
    	<tr class=" w3-flat-midnight-blue">
	      <td colspan="6" class="w3-padding" style="text-align:right;font-size:19px">GRAND TOTAL: P '.number_format($grand,2).'</td>
	    </tr>
	    </table>
    ';

    /*$array = array(
    		'table' => $table,
    		'date_from' => $date_to_str_from
    	);
    	echo json_encode($array);*/
    		
		} elseif (!empty($date_to)) {
			$date_from_sp = date("Y-m-d", strtotime($date_to));

		echo '
		<table class="w3-striped w3-text-black w3-centered">
			<tr class="w3-text-blue">
			  <td class="w3-padding-medium">Date</td>
			  <td>Food Menu</td>
			  <td>Price</td>
			  <td>Total Quantity</td>
			  <td align="center" style="padding-right:5px;">Amount</td>
			</tr>
		';
 
    $now = date("Y-m-d");
    $nowto = date("Y-m-d", strtotime($now."+ 30 days"));

    $q = mysqli_query($conn,"SELECT * FROM food_menu order by food_name");

    $grand = 0;
    while ($qq = mysqli_fetch_array($q)) { 
    	echo '<tr>';

      $w = mysqli_query($conn,"SELECT sum(food_order_details.food_qty) as totalQty, food_order.curr_order_date FROM food_order_details inner join food_order 
                  where food_order.order_id=food_order_details.order_id 
                  and ( food_order.status='approve' and food_order.curr_order_date='$date_from_sp') 
                  and food_order_details.food_id='".$qq['food_id']."' ") or die(mysqli_error($conn));

      if (mysqli_num_rows($w) > 0) {
        $total = 0;
        while ($ww = mysqli_fetch_array($w)) { 
        	echo '
        		<td class="w3-padding-medium">'.date("M d, Y", strtotime($date_to)).'</td>
		        <td>'.$qq['food_name'].'</td>
		        <td>P '.number_format($qq['price'],2).'</td>  
		        <td> '.'('.$ww['totalQty'].')'.'</td> 
        	';

      $total += $qq['price'] * $ww['totalQty'];
        } 
        echo '<td>P '.number_format($total,2).'</td>';     
      }
      $grand += $total;
      echo '</tr>';
    }
    echo '
    	<tr class=" w3-flat-midnight-blue">
	      <td colspan="6" class="w3-padding" style="text-align:right;font-size:19px">GRAND TOTAL: P '.number_format($grand,2).'</td>
	    </tr>
	    </table>
    ';	
		}
	}

#========================================ORDERS INCLUDE FILE============================================#
  if (isset($_POST['submit_filter_orers'])) {
    
    $from = $_POST['from'];
    $to = $_POST['to'];

    $from_date = date("Y-m-d", strtotime($from));
    $to_date = date("Y-m-d", strtotime($to));

    if (!empty($from) && !empty($to)) { ?>
        <table class="w3-striped w3-text-black w3-centered">
      <tr class="w3-text-blue">
        <td class="w3-padding-medium">Food Menu</td>
        <td>Date Order</td>
        <td align="center" style="padding-right:5px;">Remarks</td>
      </tr>

      <?php  
        $q = mysqli_query($conn, "SELECT * FROM food_menu");
       while ($qq = mysqli_fetch_array($q)) { ?>

      <tr>
        <td><?php echo $qq['food_name'] ?></td>
        <td>
          <?php 
          $n = mysqli_query($conn,"SELECT food_order.curr_order_date from food_order inner join food_order_details where food_order.status='approve' and food_order_details.food_id='".$qq['food_id']."' ");
          $nn = mysqli_fetch_array($n);
          echo date("M d, Y", strtotime($from)).' - '.date("M d, Y", strtotime($to));
           ?>
        </td>
        <td class="w3-padding"><br>
          <span class='circlee'>
          Delivery - <?php 
            $w = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where (food_order.curr_order_date between '$from_date' and '$to_date' ) and food_order.order_type='delivery' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
            $ww = mysqli_fetch_array($w);
            echo $ww['remarkCount']." times</span><br>";
           ?>
           <span class='circlee1'>
          Dine-in - <?php 
            $y = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details 
              where (food_order.curr_order_date between '$from_date' and '$to_date' ) and food_order.order_type='dinein' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
            $yy = mysqli_fetch_array($y);
            echo " ".$yy['remarkCount']." times</span><br>";
           ?>
           <span class='circlee2'>
          Take out - <?php 
            $m = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where 
              (food_order.curr_order_date between '$from_date' and '$to_date' ) and food_order.order_type='takeout' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
            $mm = mysqli_fetch_array($m);
            echo " ".$mm['remarkCount']." times</span><br>";
           ?>
           <span class='circlee3'>
          Pick up - <?php 
            $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where 
              (food_order.curr_order_date between '$from_date' and '$to_date' ) and food_order.order_type='pickup' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
            $gg = mysqli_fetch_array($g);
            echo " ".$gg['remarkCount']." times</span><br>";
           ?>
           <span class='circlee3'>
          Walk in - <?php 
            $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where 
              (food_order.curr_order_date between '$from_date' and '$to_date' ) and food_order.order_type='walk in' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
            $gg = mysqli_fetch_array($g);
            echo " ".$gg['remarkCount']." times</span>";
           ?>
           <br><br>
        </td>
      </tr>
    </table>
  <?php 
      }
    } elseif (!empty($from) && empty($to)) { ?>
    <table class="w3-striped w3-text-black w3-centered">
      <tr class="w3-text-blue">
        <td class="w3-padding-medium">Food Menu</td>
        <td>Date Order</td>
        <td align="center" style="padding-right:5px;">Remarks</td>
      </tr>

      <?php  
        $q = mysqli_query($conn, "SELECT * FROM food_menu");
         while ($qq = mysqli_fetch_array($q)) { ?>    
        <tr>
          <td><?php echo $qq['food_name'] ?></td>
          <td>
            <?php 
            $n = mysqli_query($conn,"SELECT food_order.curr_order_date from food_order inner join food_order_details where food_order.status='approve' and food_order_details.food_id='".$qq['food_id']."' ");
            $nn = mysqli_fetch_array($n);
            echo date("M d, Y", strtotime($from));
             ?>
          </td>
          <td class="w3-padding"><br>
            <span class='circlee'>
            Delivery - <?php 
              $w = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$from_date' and food_order.order_type='delivery' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $ww = mysqli_fetch_array($w);
              echo $ww['remarkCount']." times</span><br>";
             ?> 
             <span class='circlee1'>
            Dine-in - <?php 
              $y = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date ='$from_date' and food_order.order_type='dinein' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $yy = mysqli_fetch_array($y);
              echo " ".$yy['remarkCount']." times</span><br>";
             ?>
             <span class='circlee2'>
            Take out - <?php 
              $m = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$from_date' and food_order.order_type='takeout' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $mm = mysqli_fetch_array($m);
              echo " ".$mm['remarkCount']." times</span><br>";
             ?> 
             <span class='circlee3'>
            Pick up - <?php 
              $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$from_date' and food_order.order_type='pickup' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $gg = mysqli_fetch_array($g);
              echo " ".$gg['remarkCount']." times</span><br>";
             ?>
             <span class='circlee3'>
            Walk in - <?php 
              $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$from_date' and food_order.order_type='walk in' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $gg = mysqli_fetch_array($g);
              echo " ".$gg['remarkCount']." times</span>";
             ?>
             <br>
             <br>
          </td>
        </tr>
        </table>
      <?php 
      }
    }elseif (empty($from) && !empty($to)) { ?>
    <table class="w3-striped w3-text-black w3-centered">
      <tr class="w3-text-blue">
        <td class="w3-padding-medium">Food Menu</td>
        <td>Date Order</td>
        <td align="center" style="padding-right:5px;">Remarks</td>
      </tr>

      <?php  
        $q = mysqli_query($conn, "SELECT * FROM food_menu");
         while ($qq = mysqli_fetch_array($q)) { ?>    
        <tr>
          <td><?php echo $qq['food_name'] ?></td>
          <td>
            <?php 
            $n = mysqli_query($conn,"SELECT food_order.curr_order_date from food_order inner join food_order_details where food_order.status='approve' and food_order_details.food_id='".$qq['food_id']."' ");
            $nn = mysqli_fetch_array($n);
            echo date("M d, Y", strtotime($to));
             ?>
          </td>
          <td class="w3-padding"><br>
            <span class='circlee'>
            Delivery - <?php 
              $w = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$to_date' and food_order.order_type='delivery' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $ww = mysqli_fetch_array($w);
              echo $ww['remarkCount']." times</span><br>";
             ?> 
             <span class='circlee1'>
            Dine-in - <?php 
              $y = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date ='$to_date' and food_order.order_type='dinein' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $yy = mysqli_fetch_array($y);
              echo " ".$yy['remarkCount']." times</span><br>";
             ?> 
             <span class='circlee2'>
            Take out - <?php 
              $m = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$to_date' and food_order.order_type='takeout' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $mm = mysqli_fetch_array($m);
              echo " ".$mm['remarkCount']." times</span><br>";
             ?> 
             <span class='circlee3'>
            Pick up - <?php 
              $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$to_date' and food_order.order_type='pickup' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $gg = mysqli_fetch_array($g);
              echo " ".$gg['remarkCount']." times</span><br>";
             ?>
             <span class='circlee3'>
            Walk in - <?php 
              $g = mysqli_query($conn,"SELECT count(food_order.order_type) as remarkCount from food_order inner join food_order_details where food_order.curr_order_date = '$to_date' and food_order.order_type='walk in' and food_order.status = 'approve' and food_order.order_id=food_order_details.order_id and food_order_details.food_id = '".$qq['food_id']."' ") or die(mysqli_error($conn));
              $gg = mysqli_fetch_array($g);
              echo " ".$gg['remarkCount']." times</span>";
             ?>
             <br><br>
          </td>
        </tr>
        </table>
      <?php 
      }
    }
  }
#========================================END ORDERS INCLUDE FILE============================================#

#=======================================Reservation include file==============================================#
if (isset($_POST['submit_filter_reser'])) {
    $date_from_reser = $_POST['date_from_reser'];
    $date_to_reser = $_POST['date_to_reser'];
    
    $from_date_reser = date("Y-m-d", strtotime($date_from_reser));
    $to_date_reser = date("Y-m-d", strtotime($date_to_reser));
    
    ?>
    <table class="w3-text-back w3-striped w3-centered" id="table__ble">
    <tr class="w3-text-blue">
      <td class="w3-padding-medium">Date</td>
      <td>Occasion</td>
      <td>Remarks</td>
    </tr>
    <?php  

    $q = mysqli_query($conn,"SELECT * FROM catering");
    while ($qq = mysqli_fetch_array($q)) { ?>
      <tr class="w3-text-black">
      <?php                                     
      $w = mysqli_query($conn,"SELECT count(cater_id) as countCatering FROM reservation where 
        (r_date_from between '$from_date_reser' and '$to_date_reser')  and (r_status='approve' || r_status='finish') and cater_id = '".$qq['cater_id']."' ");
      $ww = mysqli_fetch_array($w);
      ?>
      <td class="w3-padding-medium"><?php echo date("M d, Y", strtotime($date_from_reser))."--".date("M d, Y", strtotime($to_date_reser)) ?></td>
      <td><?php echo $qq['event_name']; ?></td>
      <td>Reserve <?php echo $ww['countCatering']; ?> times</td>

      </tr>
    <?php
    }
    ?>
  </table>
  
  <?php
}
 ?>