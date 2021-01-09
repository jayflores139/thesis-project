$(document).ready(function(){

	$(".pendingtakeout").click(function(){
		var pendingtakeout = $(this).attr("id");

		$.ajax({
			url: "include/search_orderTake.php",
			method: "POST",
			data: {
				pendingtakeout: pendingtakeout
			},
			success: function(d) {
				$(".order_content_takeout").html(d);
			}
		});
	});

	$(".approvetakeout").click(function(){
		var approvetakeout = $(this).attr("id");

		$.ajax({
			url: "include/search_orderTake.php",
			method: "POST",
			data: {
				approvetakeout: approvetakeout
			},
			success: function(d) {
				$(".order_content_takeout").html(d);
			}
		});
	});

	$(".canceltakeout").click(function(){
		var canceltakeout = $(this).attr("id");

		$.ajax({
			url: "include/search_orderTake.php",
			method: "POST",
			data: {
				canceltakeout: canceltakeout
			},
			success: function(d) {
				$(".order_content_takeout").html(d);
			}
		});
	});

	$(".form_searchtakeout").submit(function(e){
		e.preventDefault();

		var submittakeout = $('.submittakeout').val();
		var search_inputtakeout = $(".search_inputtakeout").val();

		$.ajax({
			url: "include/search_orderTake.php",
			method: "POST",
			data: {
				search_inputtakeout: search_inputtakeout,
				submittakeout: submittakeout
			},
			success: function(d) {
				$(".order_content_takeout").html(d);
			}
		});

	});

});
