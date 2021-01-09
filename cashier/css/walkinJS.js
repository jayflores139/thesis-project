$(".form_searchwalk").submit(function(e) {
		e.preventDefault();

		var search_inputwalk = $(".search_inputwalk").val();
		var submitwalk = $(".submitwalk").val();

		$.ajax({
			url: "include/search_orderWalk.php",
			method: "POST",
			data: {
				search_inputwalk: search_inputwalk,
				submitwalk: submitwalk
			},
			success:function(d){
				$(".order_content").html(d);
			}
		});
	});