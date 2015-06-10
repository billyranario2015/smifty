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
				//console.log(data);
			},
			error: function(data) {
				//console.log(data.responseText);
			}
		});

	});
});







