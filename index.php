<?php
	//load all vendors

	ob_start();
	session_start();

	//admin & restaurant have $_session['userid'];
	//customer has $_session['clientid']

	require_once __DIR__.'/vendor/autoload.php';
	require_once __DIR__.'/src/Handler/Handlers.php';

	// session:  orderid / clientid
	//var_dump($_SESSION);
	//setup router
	ToroHook::add("404",  function() {
	    echo "404 - Not Found";
	});

	Toro::serve(array(
		"/"							=> "HomeHandler",
		"/page/:alpha" 				=> "PageHandler",
		"/city/:alpha" 				=> "CityHandler",
		"/restaurant/order/:alpha"	=> "RestaurantHandler",
		"/order/:alpha"				=> "OrderHandler",
		"/order-confirmation"		=> "OrderConfirmHandler",
		"/customer-login" 			=> "AuthHandler",
		"/place-order" 				=> "PlaceOrderHandler",
		"/user/:alpha"				=> "AuthHandler",
		"login/:alpha" 				=> "LoginHandler", // /logout, etc
		"/admin/:alpha" 			=> "AdminHandler"

	));
?>