<?php

	require_once '../vendor/catfan/medoo/medoo.php';
	$db = new medoo();
	
	$intent = $_POST['intent'];
	

	switch ($intent) {
		case 'delete':

			if (isset($_POST['table'])) {
				$target = $_POST['restaurantid'];
				$result = $db->delete("restaurant", ["id" => $target]);

			} else {
				$target = $_POST['foodid'];
				$result = $db->delete("food", ["id" => $target]);
				//$result=$db->last_query();
			}
				

			break;

		case 'getrestaurants':
			$result = $db->select("restaurant",
				["id", "name"],
				["ORDER" => "name ASC"]
			);
			break;

		case 'getcities':
			$result = $db->select("city", "*",
				["ORDER" => "cityname ASC"]
			);

			

			break;

		case 'addnewfood':
		
			$name 			= $_POST['dataform']['name'];
			$restaurant 	= $_POST['dataform']['restaurant'];
			$amount			= $_POST['dataform']['amount'];
			$vegetarian		= $_POST['dataform']['vegetarian'];
			$availability 	= $_POST['dataform']['available'];


			$result = $db->insert("food",
				[
					"foodname"		=> $name,
					"restaurant"	=> $restaurant,
					"amount"		=> $amount,
					"availability" 	=> $availability,
					"vegetarian" 	=> $vegetarian
				]
			);
			
			$result = $_POST['dataform']['amount'];
			break;

		case 'addnewrestaurant':
			$name 		= $_POST['dataform']['name'];
			$city 		= $_POST['dataform']['city'];
			$address 	= $_POST['dataform']['address'];
			$phone 		= $_POST['dataform']['phone'];
			$email 		= $_POST['dataform']['email'];

			$result = $db->insert("restaurant",
				[
					"name" 		=> $name,
					"city"		=> $city,
					"logo"		=> '',
					"status"	=> '',
					"url"		=> '',
					"address"	=> $address,
					"phone"		=> $phone,
					"email" 	=> $email
				]	
			);
			break;

		case 'media-url':
			$fieldname 	= $_POST['fieldname'];
			$value 		= $_POST['value'];

			$result = $db->update("settings", ["value" => $value], ["fieldname" => $fieldname]);

			break;

		case 'media-active':
			$fieldname 	= $_POST['fieldname'];
			$value 		= $_POST['value'];

			$result = $db->update("settings", ["active" => $value], ["fieldname" => $fieldname]);
			break;

		case 'update-field':
			
			$table 		= $_POST['table'];
			$fieldname 	= $_POST['fieldname'];
			$rowname	= $_POST['rowname'];
			$valuefield	= $_POST['valuefield'];
			$value		= $_POST['value'];

			$result = $db->update($table, [ $valuefield => $value], [$fieldname => $rowname]);
			
			break;
		
		case 'update-status-order':
			$table 		= $_POST['table'];
			$status 	= $_POST['status'];
			$orderID	= $_POST['orderID'];

			$result = $db->update( $table, [ "status" => $status ] , ["orderid" => $orderID ] );
			break;
		
		case 'view-customer-order-info':
			$orderID = $_POST['orderID'];
			$orderInfo = $db->select('orders', [
					"[>]clients" => ["clientid" => "id"]
				    ],
				    [
					    "orders.orderid", 
					    "orders.foodname",
					    "orders.amount" , 
					    "clients.firstname", 
					    "clients.lastname", 
					    "clients.email"
				     ], 
				    [ "orders.orderid" => $orderID ]
				 );
			$amountOrder =  $db->sum("orders", "amount", [ "orders.orderid" => $orderID ]);
			$result = array( $orderInfo, $amountOrder );
			break;
		
		default:
			# code...
			break;
	}

	echo json_encode($result);
?>