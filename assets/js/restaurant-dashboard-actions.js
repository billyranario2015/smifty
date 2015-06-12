$(function() {
	var MIN_LENGTH = 3;
	$("#jobname").keyup(function() {

		var keyword = $("#jobname").val();

		// auto complete food search
		if (keyword.length >= MIN_LENGTH) {
		  	$.ajax({
		  		dataType : 'json',
		  		type: 'post',
		  		url: '/ajax/autocomplete.php',
		  		data: { keyword: keyword, usertype : 'restaurant' },
		  		success: function(data) {
		  			//console.log(data);
		  			if (data == '') {
		  				$('#emptyfood').show();
		  				$('#add-a-food').show();
		  			} else {
		  				$('#foodsearchresults').empty().show();
			  			$.each(data, function(key, value) {   
						    $('#foodsearchresults')
						        .append($("<option></option>")
						        .attr({
						        	"value" :value['id'],
						        	"data-restaurant" : value['name'],
						        	"data-amount" : value['amount'],
						        	"data-name" : value['foodname']
						        })
						        .text(value['foodname'])); 
						});

						// DELETE : event listener
						$('#foodactions button').click(function(e) {
							var intent = $(this).attr('data-intent');
							var target = $(this).attr('data-target');

							if (intent == 'delete') {
								$.ajax({
									type: 'post',
									dataType: 'json',
									url : '/ajax/dashboard-actions.php',
									data: { foodid : target, intent : 'delete'},
									success: function(data) {
										//console.log(data);

										$('#foodsearchresults option[value='+target+']').remove();
										$('.foodactions').hide();
										$('#foodsearchresults').hide();
										$('#jobname').val("");
										$('#foodalert').show().text('Food item successfully deleted');
									},
									error: function(data) {
										//console.log(data);
									}
								});
							} else if (intent == 'edit') {

							}
						});
			  			

						// add options
						$('#foodsearchresults option').click(function(e) {
							e.preventDefault();
							
							$('.foodactions').show();

							var id = $(this).val();
							var resta = $(this).attr('data-restaurant');
							var amount = $(this).attr('data-amount');
							var name = $(this).attr('data-name');

							$('.resta .val').text(resta);
							$('.name .val').text(name);
							$('.amount .val').text(amount);
							$('#foodactions button').attr('data-target', id);
						});
		  			}
			  			
		  		},
		  		error: function(data) {
		  			console.log(data.responseText);
		  		}
		  	});
		} // end autocomplate
	}); // end keyup

	// ADD FOOD button click
	$('#add-a-food').click(function(e) {
		//get input value
		var newname = $('#jobname').val();

		$('#newfoodbox').show();
		$('#newfoodname').val(newname);

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent : 'getrestaurants'},
			success: function(data) {

			},
			error: function(data) {
				//console.log(data.responseText);
			}
		});
	});

	//add a food form submit
	$('#add-food-form').submit(function(e) {
		e.preventDefault();

		var formData = {
			'name'  		: $('#newfoodname').val(),
			'restaurant'	: $('#restaurantlist').val(),
			'amount'		: $('#foodamount').val(),
			'vegetarian'	: $('#vegetarian').find(":checked").val(),
			'available'		: $('#available').find(":checked").val()
		};

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent: 'addnewfood', dataform : formData },
			encode: true,
			success: function(data) {
				$('#newfoodbox').hide();
				$('#emptyfood').hide();
				$('#jobname').val('');
				$('#foodalert').show().text('Food item successfully added to the database');
				console.log(data);
			},
			error: function(data) {
				console.log(data.responseText);
			}
		});

	});

	// Show edit form for restaurants
	$( "body" ).delegate( ".action" , "click" , function() {
		var action = $( this ).attr( "id" );
		var restaurantInfo = {
			'intent'			: 'update-restaurant',
			'restaurantID' 		: $("#restaurantID").val() ,
			'restaurantName' 	: $("#restaurantName").val() ,
			'restaurantEmail' 	: $("#restaurantEmail").val() ,
			'restaurantPhone' 	: $("#restaurantPhone").val() ,
			'restaurantAddress' : $("#restaurantAddress").val()
		};
		if ( action == 'edit' ) {
			// console.log(restaurantInfo);
			$( ".hide-info" ).hide();
			$( ".text-details label" ).css( "padding-top" , "7px" );
			$( ".update-input input[type=text]" ).show();
			$( this ).hide();
			$( "#save" ).show();
			$( "#close" ).show();
		}else if( action == 'save' ){
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: '/ajax/dashboard-actions.php',
				data: restaurantInfo,
				encode: true,
				success: function(data) {
					// console.log(data);
					$("#preload").show();
					setTimeout(function() {
						$("#preload").hide();
						$(".check").show();
						$( "#name" ).text(data.name);
						$( "#email" ).text(data.email);
						$( "#phone" ).text(data.phone);
						$( "#address" ).text(data.address);
						$( ".hide-info" ).show();
						$( ".text-details label" ).css( "padding-top" , "0px" );
						$( ".update-input input[type=text]" ).hide();
						$( "#edit" ).show();
						$( "#save" ).hide();
						$( "#close" ).hide();
						setTimeout(function() {
							$(".check").fadeOut();
						}, 1500);		

					}, 1500);	
				},
				error: function(data) {

				}
			});		

		}else if ( action == 'close' ){
			$( ".hide-info" ).show();
			$( ".text-details label" ).css( "padding-top" , "0px" );
			$( ".update-input input[type=text]" ).hide();
			$( "#edit" ).show();
			$( "#save" ).hide();
			$( "#close" ).hide();
		} 

	} );

	// Update Order Status
	$(".order-status-row").change(function(){
		var orderData = {
			'intent'	: 'update-status-order',
			'table'		: 'orders',
			'status'	: $( this ).val(),
			'orderID'	: $( this ).attr('id')
	 	}
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: orderData,
			success: function(data) {
				$("#preload").show();
				setTimeout(function() {
					$("#preload").hide();
					$(".check").show();
					setTimeout(function() {	
						$(".check").hide();
					}, 3000);
				}, 1500);
				$(".check").hide();
			},
			error: function(data) {
				
			}
		});		
	});

	// View Customer Order Status
	$( "body" ).delegate( '.view-info' , 'click' , function() {
		var customerOrderInfo = {
			'intent'	: 'view-customer-order-info',
			'orderID'	: $(this).text()
	 	}

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: customerOrderInfo,
			success: function(data) {
				$( "ul#food-name li" ).empty();
				var counter = 1;
				for( var x in data[0] ) {
					var fullname = data[0][x].firstname + ' ' +data[0][x].lastname;
					var foodInfo = "<li>"+ counter++ +") <span class='text-info'>"+ data[0][x].foodname +"</span> - $ "+ data[0][x].amount +"</li>";
					$( "#customer-name" ).text(fullname);
					$( "#customer-email" ).text(data[0][x].email);
					$( "ul#food-name" ).append( foodInfo );
					$( "#total-amount" ).text(data[1]);
					$( "#order-id" ).text( data[0][x].orderid );
					console.log(data[x]);
				}
			},
			error: function(data) {
				console.log('ERROR: '+data);
			}
		});		 	
	});

	// Count Orders 
	var countOrders = $( "#countOrders" ).val();
	$( ".ordersCount" ).text( countOrders );
	var countPlacedOrders = $( "#countPlacedOrders" ).val();
	$( ".countPlacedOrders" ).text( countPlacedOrders );
});







