<?php 

include '../../includes/connect.php';
if (isset($_POST['submitwalk'])) {
		$search_inputwalk = $_POST['search_inputwalk'];

		$date = date("Y-m-d", strtotime($search_inputwalk));

		$q = mysqli_query($conn,"SELECT * FROM food_order where curr_order_date = '$date' and order_type = 'walk in' "); ?>

		<table class="w3-border w3-striped">
	        <tr class="w3-text-black">
	          <td class="w3-padding">Date</td>
	          <td class="w3-padding">Total</td>
	          <td class="w3-padding">Action</td>
	        </tr>

	       <?php

	       if (mysqli_num_rows($q) > 0) {
	       	while ($qq = mysqli_fetch_array($q)) { ?>
                  <tr style="color:#474242" class="reMove<?php echo $qq['order_id'] ?>">      
                <td class="w3-padding"><?php echo date("m-d-y", strtotime($qq['curr_order_date'])) ?></td>
                <td class="w3-padding">P <?php echo number_format($qq['order_amount'], 2) ?></td>
                <td class="w3-padding" width="19%">
                  <div class="w3-right">
                    <a href="order_view.php?id=<?php echo $qq['order_id'] ?>">
                      <button class="btn btn-default"><i class="fas fa-search"></i> view</button>
                    </a>
                    <button class="btn btn-default delete" id="<?php echo $qq['order_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                  </div>
                </td>
              </tr>
              <?php
			}
	       } else {
	       	echo '<tr>
	       		<td colspan="3" align="center" class="w3-padding">No Orders Found.</td>
	       	</tr>';
	       }
		echo "</table>";	
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