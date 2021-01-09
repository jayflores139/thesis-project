$(document).ready(function(){

	$(".pendingdinein").click(function(){
		var pendingdinein = $(this).attr("id");

		$.ajax({
			url: "include/search_orderDine.php",
			method: "POST",
			data: {
				pendingdinein: pendingdinein
			},
			success:function(d){
				$(".order_contentdinein").html(d);
			}
		});
	});

	$(".approvedinein").click(function(){
		var approvedinein = $(this).attr("id");

		$.ajax({
			url: "include/search_orderDine.php",
			method: "POST",
			data: {
				approvedinein: approvedinein
			},
			success:function(d){
				$(".order_contentdinein").html(d);
			}
		});
	});

	$(".canceldinein").click(function(){
		var canceldinein = $(this).attr("id");

		$.ajax({
			url: "include/search_orderDine.php",
			method: "POST",
			data: {
				canceldinein: canceldinein
			},
			success:function(d){
				$(".order_contentdinein").html(d);
			}
		});
	});

	$(".form_searchdinein").submit(function(e) {
		e.preventDefault();

		var search_inputdinein = $(".search_inputdinein").val();
		var submitdinein = $(".submitdinein").val();

		$.ajax({
			url: "include/search_orderDine.php",
			method: "POST",
			data: {
				search_inputdinein: search_inputdinein,
				submitdinein: submitdinein
			},
			success:function(d){
				$(".order_contentdinein").html(d);
			}
		});
	});
});
