$(document).ready(function(){
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

	$(".pending").click(function(){
		var pending = $(this).attr("id");

		$.ajax({
	  		url: "include/search_order.php",
	  		method:"POST",
	  		data:{
	  			pending: pending
	  		},
	  		success: function(d){
	  			$(".order_content").html(d);
	  		}
	  	});
	});

	$(".approve").click(function(){
		var approve = $(this).attr("id");

		$.ajax({
	  		url: "include/search_order.php",
	  		method:"POST",
	  		data:{
	  			approve: approve
	  		},
	  		success: function(d){
	  			$(".order_content").html(d);
	  		}
	  	});
	});

	$(".cancel").click(function(){
		var cancel = $(this).attr("id");

		$.ajax({
	  		url: "include/search_order.php",
	  		method:"POST",
	  		data:{
	  			cancel: cancel
	  		},
	  		success: function(d){
	  			$(".order_content").html(d);
	  		}
	  	});
	});

	$(".all").click(function(){
		location.reload();
	});

	$(".form_search_de").submit(function(e){
		e.preventDefault();

		var search_input_date = $(".search_input_date").val();
		var submit = $(".submit").val();

		$.ajax({
			url: "include/search_order.php",
			method: "POST",
			data: {
				search_input_date: search_input_date,
				submit: submit
			},
			success: function(da) {
				$(".order_content").html(da);
			}
		});
	});

});
 function printElem() {
    var content = document.getElementById('printFields').innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=1000');

    mywindow.document.write('<html><head><title>Print</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
