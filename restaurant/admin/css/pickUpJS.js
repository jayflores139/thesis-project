$(document).ready(function(){

	$(".pendingpickup").click(function(){
		var pendingpickup = $(this).attr("id");

		$.ajax({
			url: "include/search_orderPick.php",
			method: "POST",
			data: {
				pendingpickup: pendingpickup
			},
			success:function(d){
				$(".order_contentpickup").html(d);
			}
		});
	});

	$(".approvepickup").click(function(){
		var approvepickup = $(this).attr("id");

		$.ajax({
			url: "include/search_orderPick.php",
			method: "POST",
			data: {
				approvepickup: approvepickup
			},
			success:function(d){
				$(".order_contentpickup").html(d);
			}
		});
	});

	$(".cancelpickup").click(function(){
		var cancelpickup = $(this).attr("id");

		$.ajax({
			url: "include/search_orderPick.php",
			method: "POST",
			data: {
				cancelpickup: cancelpickup
			},
			success:function(d){
				$(".order_contentpickup").html(d);
			}
		});
	});

	$(".form_searchpickup").submit(function(e) {
		e.preventDefault();

		var search_inputpickup = $(".search_inputpickup").val();
		var submitpickup = $(".submitpickup").val();

		$.ajax({
			url: "include/search_orderPick.php",
			method: "POST",
			data: {
				search_inputpickup: search_inputpickup,
				submitpickup: submitpickup
			},
			success:function(d){
				$(".order_contentpickup").html(d);
			}
		});
	});
});
