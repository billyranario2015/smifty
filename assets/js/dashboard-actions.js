$(function() {
	var MIN_LENGTH = 3;
	$("#jobname").keyup(function() {

		var keyword = $("#jobname").val();
		var usertype = $(this).attr('data-usertype');

		// auto complete food search
		if (keyword.length >= MIN_LENGTH) {
		  	$.ajax({
		  		dataType : 'json',
		  		type: 'post',
		  		url: '/ajax/autocomplete.php',
		  		data: { keyword: keyword, usertype : usertype },
		  		success: function(data) {
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
		  			console.log(data);
		  		}
		  	});
		} // end autocomplate
	}); // end keyup


	//keyup for restaurant
	$("#restaurantname").keyup(function() {

		var keyword = $("#restaurantname").val();
		var usertype = $(this).attr('data-usertype');

		// auto complete restaurant search
		if (keyword.length >= MIN_LENGTH) {
		  	$.ajax({
		  		dataType : 'json',
		  		type: 'post',
		  		url: '/ajax/autocomplete.php',
		  		data: { keyword: keyword, usertype : usertype, table : 'restaurant' },
		  		success: function(data) {
		  			console.log(data);
		  			if (data == '') {
		  				$('#emptyrestaurant').show();
		  				$('#add-a-restaurant').show();
		  			} else {
		  				$('#restaurantsearchresults').empty().show();
			  			$.each(data, function(key, value) {   
						    $('#restaurantsearchresults')
						        .append($("<option></option>")
						        .attr({
						        	"value" 		: value['id'],
						        	"data-name" 	: value['name'],
						        	"data-city" 	: value['city'],
						        	"data-logo" 	: value['logo'],
						        	"data-phone" 	: value['phone'],
						        })
						        .text(value['name'])); 
						});

						// DELETE : event listener
						$('#restaurantactions button').click(function(e) {

							var intent = $(this).attr('data-intent');
							var target = $(this).attr('data-target');
							var table = $(this).attr('data-for');

							if (intent == 'delete') {
								$.ajax({
									type: 'post',
									dataType: 'json',
									url : '/ajax/dashboard-actions.php',
									data: { restaurantid : target, intent : 'delete', table : table },
									success: function(data) {
										//console.log(data);

										$('#restaurantsearchresults option[value='+target+']').remove();
										$('.restaurantactions').hide();
										$('#restaurantsearchresults').hide();
										$('#restaurantname').val("");
										$('#restaurantalert').show().text('Restaurant successfully deleted');
									},
									error: function(data) {
										//console.log(data.responseText);
									}
								});
							} else if (intent == 'edit') {

							}
						});
			  			

						// add options
						$('#restaurantsearchresults option').click(function(e) {
							e.preventDefault();
							
							$('.restaurantactions').show();

							var id = $(this).val();
							var name = $(this).attr('data-name');
							var city = $(this).attr('data-city');
							var logo = $(this).attr('data-logo');
							var address = $(this).attr('data-address');
							var phone = $(this).attr('data-phone');
							var email = $(this).attr('data-email');

							$('.resta .val').text(name);
							$('.city .val').text(city);
							$('.logo .val').text(logo);
							$('#restaurantactions button').attr('data-target', id);
						});
		  			}
			  			
		  		},
		  		error: function(data) {
		  			//console.log(data.responseText);
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
				//console.log('data'+data);
				$.each(data, function(key, value) {
					$('#restaurantlist')
						.append($('<option></option>')
						.attr('value', value['id'])
						.text(value['name']));
				});
			},
			error: function(data) {
				//console.log(data.responseText);
			}
		});
	});

	$('#add-a-restaurant').click(function(e) {
		//get input value
		var newname = $('#restaurantname').val();

		$('#addrestaurant-b').show();
		$('#newretaurantname').val(newname);

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent : 'getcities'},
			success: function(data) {
				console.log(data);
				$.each(data, function(key, value) {
					$('#citylist')
						.append($('<option></option>')
						.attr('value', value['id'])
						.text(value['cityname']));
				});
			},
			error: function(data) {
				console.log(data.responseText);
			}
		});
	});

	//add a food form submit
	$('#add-food-form').submit(function(e) {
		e.preventDefault();

		var formData = {
			'name'  		: $('#newfoodname').val(),
			'restaurant'	: $('#restaurantlist').find(":selected").val(),
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
				//console.log(data);
			},
			error: function(data) {
				//console.log(data.responseText);
			}
		});

	});

	//add a restaurant form submit
	$('#add-restaurant-form').submit(function(e) {
		e.preventDefault();

		var formData = {
			'name'  		: $('#newretaurantname').val(),
			'city'			: $('#citylist').find(":selected").val(),
			'address'		: $('#restaddress').val(),
			'phone'			: $('#restphone').val(),
			'email'			: $('#restemail').val()
		};

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent: 'addnewrestaurant', dataform : formData },
			encode: true,
			success: function(data) {
				$('#addrestaurant-b').hide();
				$('#restaurantname').val('');
				$('#emptyrestaurant').hide();
				$('#restaurantsearchresults').hide();
				$('#restaurantalert').show().text('Restaurant successfully added');
				//console.log(data);
			},
			error: function(data) {
				//console.log(data.responseText);
			}
		});

	});


	//setup before functions for settings update
	var typingTimer;                //timer identifier
	var doneTypingInterval = 800;  //time in ms, 8 second for example

	//on keyup, start the countdown
	$('#fb_url, #twit_url, #pint_url, #google_url').keyup(function(){
		$('#filler').val($(this).attr('id'));

	    clearTimeout(typingTimer);
	    typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	//on keydown, clear the countdown 
	$('#fb_url, #twit_url, #pint_url, #google_url').keydown(function(){
	    clearTimeout(typingTimer);
	});

	//button pressed
	$('.media-url-trigger button').click(function(e) {
		var fname = $(this).attr('data-type');
		var fval = $(this).attr('data-value');

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent: 'media-active', fieldname : fname, value : fval },
			success: function(data) {
				$('#dashboard-notice').text('Settings saved...').show();
			    setTimeout(function(){
			    	$('#dashboard-notice').hide();
			    }, 3000);

			    
			},
			error: function(data) {
				console.log(data.responseText);
			}
		});

	});

	//user is "finished typing," do something
	function doneTyping () {
	    var fieldname = $('#filler').val();
	    var value = $('#'+fieldname).val();
	    var intent = 'media-url';

	    $.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent: intent, fieldname : fieldname, value : value },
			success: function(data) {
				$('#dashboard-notice').text('Settings saved...').show();
			    setTimeout(function(){
			    	$('#dashboard-notice').hide();
			    }, 3000);
			},
			error: function(data) {
				console.log(data.responseText);
			}
		}); 
	}

	// currency change
	$('#currencySelector').on('change', function(e){
		var currVal = $('#currencySelector option:selected').val();
		var successMsg = "Currency successfully changed";

		console.log(currVal);

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/ajax/dashboard-actions.php',
			data: { intent 	: 'update-field', table: 'settings', fieldname: 'fieldname', rowname: 'currency', valuefield: 'value', value: currVal },
			success: function(data) {
				showHideAlert(successMsg);
			},
			error: function(data) {
				console.log(data.responseText);
			}
		});
	});

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



	function showHideAlert(text)
	{
		$('#dashboard-notice').text(text).show();

	    setTimeout(function(){
	    	$('#dashboard-notice').hide();
	    }, 3000);
	}
});







