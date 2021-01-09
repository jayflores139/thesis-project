<?php 
include '../../includes/connect.php';
	if (isset($_POST['name'])) {
		$name = $_POST['name'];

		$search = mysqli_query($conn,"SELECT * FROM users where firstname like '%$name%' or lastname like '%$name%'") or die(mysqli_error($conn));

		if (mysqli_num_rows($search) > 0) {
			echo '
			<tr class="w3-text-blue">
	            <th>Full name</th>
	            <th>Gender</th>
	            <th>Address</th>
	            <th width="13%">Contact #</th>
	            <th width="13%">Date registered</th>
	            <th>Username</th>
	            <th width="14%">Action</th>
	        </tr>
			';
			while ($row = mysqli_fetch_array($search)) {
			echo '
				<tr class="t-body">
	                <td>'.$row['firstname'].' '. $row['lastname'].'</td>
	                <td>'.$row['gender'].'</td>
	                <td>'.$row['address'].'</td>
	                <td>'.$row['contact'].'</td>
	                <td>'.date("M d, Y", strtotime($row['dateadded'])).'</td>
	                <td>'.$row['username'].'</td>
	                <td width="18%">
	                  <a href="uview.php?view='.$row['id'].'">
	                    <button class="btn btn-default" ><i class="fas fa-search"></i> view</button>
	                  </a>
	                  <input type="hidden" id="deleteinfo'.$row['id'].' value="'.$row['id'].'">
                    <button class="action delete btn btn-default w3-left" id="'.$row['id'].'"><i class="fas fa-trash-alt"></i> delete</button>
	                </td>

	                <?php
	            }
	                ?>
                </tr>
			';
			}
		} else {
			echo '
				<tr class="t-body">
	                <td>No user like "'.$name.'".</td>
                </tr>
			';
		}
	}

 ?>
 <script>
 	 $(".delete").click(function(){
      var del = $(this).attr("id");
      var del_id = $("#deleteinfo"+del).val();

      if (confirm("Are you sure?") == true) {
        $.ajax({
          url: "include/user_search.inc.php",
          method: "POST",
          data: {
            del: del,
            del_id: del_id
          },
          success: function(data){
            if (data == "Deleted") {
              window.location.reload();
            }
          }
        });
      }
    });
 </script>