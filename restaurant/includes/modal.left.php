<div class="modal-left">
  <div class="modal-content">
    <div class="ready">
      <h2>Joemy's Account</h2>
    <span class="modal-close">&times;</span>
    </div>
    <div class="set">
      <a href="#">My Account</a>
      <a href="#">My Order</a></li>
      <a href="#">My Reservation</a>
      <a href="logout.php">Log out</a>
    </div>

  </div>
</div>
<script>
$(document).ready(function(){


  $("#left-modal").click(function(){
    $(".modal-left").css("display","block");
    $(".modal-left .modal-content").css("width", "300px");
  });

  $(".modal-close").click(function(){
    $(".modal-left").css("display","none");
    $(".modal-left .modal-content").css("width", "0");
  });
});
</script>
