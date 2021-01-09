<?php  
include '../../includes/connect.php';

if (isset($_POST['pendingdinein'])) { ?>

		<table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Dine Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' and status='pending' order by order_date ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) {
                  echo '<tr class="reMove'.$qq['order_id'].'">';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
          <?php	
	}

	if (isset($_POST['approvedinein'])) { ?>

		<table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Dine Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' and status='approve' order by order_date ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) {
                  echo '<tr class="reMove'.$qq['order_id'].'">';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
          <?php	
	}

	if (isset($_POST['canceldinein'])) { ?>

		<table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Dine Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' and status='cancel' order by order_date ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) {
                  echo '<tr class="reMove'.$qq['order_id'].'">';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
          <?php	
	}

	if (isset($_POST['submitdinein'])) {
		$search_inputdinein = date("Y-m-d", strtotime($_POST['search_inputdinein'])); ?>

		<table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Dine Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' and order_date='$search_inputdinein' order by order_date ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) {
                  echo '<tr class="reMove'.$qq['order_id'].'">';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
          <?php	
	}

	if (isset($_POST['today_dinein'])) {
		$today_dinein = date("Y-m-d", strtotime($_POST['today_dinein']));


		?>
		<table class="w3-border w3-striped">

            <tr class="w3-text-black">
              <td class="w3-padding">Name</td>
              <td class="w3-padding">Dine Date / time</td>
              <td class="w3-padding">Total</td>
              <td class="w3-padding">Status</td>
              <td class="w3-padding">Action</td>
            </tr>

            <?php  
              $q = mysqli_query($conn,"SELECT * FROM food_order where order_type = 'dinein' and order_date = '$today_dinein' ");
              if (mysqli_num_rows($q) > 0) {
                while ($qq = mysqli_fetch_array($q)) {
                  echo '<tr class="reMove'.$qq['order_id'].'">';
                  $w = mysqli_query($conn,"SELECT * FROM pick_up_details WHERE order_id = '".$qq['order_id']."' ");
                  if (mysqli_num_rows($w) > 0) {
                    while ($ww = mysqli_fetch_array($w)) {
                     echo '<td class="w3-padding">'.$ww['p_to_pick'].'</td>';
                    }
                  } else {
                    $user = mysqli_query($conn,"SELECT * FROM users where id = '".$qq['user_id']."' ");
                    $users = mysqli_fetch_array($user);
                    echo '<td class="w3-padding">'.$users['firstname'].' '.$users['lastname'].'</td>';
                  }
                  
                ?>          
                    <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['order_date'])).' / '.date("h:i A", strtotime($qq['order_time'])) ?></td>
                    <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                    <td class="w3-padding"><?php echo $qq['status'] ?></td>
                    <td class="w3-padding" width="19%">
                      <div class="w3-right">
                        <a href="?i=<?php echo $qq['order_id'] ?>">
                          <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                        </a>
                        <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                      </div>
                    </td>
                  </tr>

                <?php    
                }
              } else {
                echo '<tr><td class="w3-padding" colspan="5" align="center">No Orders Found</td></tr>';
              }
            ?>

          </table>
      <?php
	}

?>
<script>
	$(".delete").click(function(){
	  var id = $(this).attr("id");

	  if (confirm("Are you sure?") == true) {
	  	$.ajax({
	  		url: "include/order_delete.inc.php",
	  		method:"POST",
	  		data:{
	  			id: id
	  		},
	  		success: function(d){
	  			if (d == "Deleted") {
	  				$(".reMove"+id).remove();
	  			}
	  		}
	  	});
	  }
	});
</script>