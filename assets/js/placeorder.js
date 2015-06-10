$(function(){

	//is checkout shown
	var showncheckout = false;
	var orderid = $('#currentorderid').val();

	//add to cart
	$('.add-to-cart').click(function(e) {
		var id 			= $(this).attr('data-id');
		var amount 		= $(this).attr('data-amount');
		var foodname 	= $(this).attr('data-name');
		var orderid 	= $('#currentorderid').val();
		var restid 		= $('#restaurant_id').val();

		$.ajax({
			url: '/ajax/order.php',
			type: 'POST',
			dataType: 'json',
			data: {
				"intent" 	: 'add',
				"foodid" 	: id,
				"orderid"	: orderid,
				"name" 		: foodname,
				"amount" 	: amount,
				"restid"	: restid
			},
			success: function(data) {
				$('.basket-slim').removeClass('collapsed');
				updateTotal(data.total);

				$('#current-basket').append('<li id="'+data.result+'">'+
						'<button class="removefood btn btn-default" data-foodid="'+data.result+'"><i class="fa fa-minus"></i></button>'+foodname+
						'<span class="amount"> $ '+amount+'</span>'+
					'</li>'
				);

				$('.removefood').click(function(e) {
					e.preventDefault();

					var foodid = $(this).attr('data-foodid');

					$.ajax({
						url: '/ajax/order.php',
						type: 'POST',
						dataType: 'json',
						data: {
							"intent" 	: 'delete',
							"foodid"	: foodid,
							"orderid" 	: orderid
						},
						success: function(data) {
							if (!data.orders) $('.basket-slim').addClass('collapsed');
							$('#'+foodid).remove();
							updateTotal(data.total);
						},
						error: function(data) {
							console.log(data.responseText);
						}
					});
					
					return false;
				});

			},
			error: function(data) {
				$('#warnings').show().text('There is something wrong placing your order.  Please try again!');
				console.log(data.responseText);
			}
		});
	});


	// remove food from order
	$('.removefood').click(function(e) {
		e.preventDefault();

		var foodid = $(this).attr('data-foodid');

		$.ajax({
			url: '/ajax/order.php',
			type: 'POST',
			dataType: 'json',
			data: {
				"intent" 	: 'delete',
				"foodid"	: foodid,
				"orderid" 	: orderid
			},
			success: function(data) {
				if (!data.orders) $('.basket-slim').addClass('collapsed');
				$('#'+foodid).remove();
				updateTotal(data.total);
			},
			error: function(data) {
				//console.log(data.responseText);
			}
		});
		return false;
	});

	function updateTotal(t)
	{
		//console.log(t);
		$('.overall-total .amount').html('$ '+t);
		return false;
	}
});