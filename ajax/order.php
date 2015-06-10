<?php

	require_once '../vendor/catfan/medoo/medoo.php';
	$db = new medoo();

	session_start();

	$name = null;
	$id = null;
	$amount = null;
	$result = null;

	if (isset($_POST['intent'])) {

		switch ($_POST['intent']) {
			case 'add':
				$foodid 		= $_POST['foodid'];
				$orderid 		= $_SESSION['orderid'];
				$clientid 		= isset($_SESSION['clientid']) ? $_SESSION['clientid'] : null;
				$foodname 		= $_POST['name'];
				$amount 		= $_POST['amount'];
				$restaurantid	= $_POST['restid'];

				$addorder = $db->insert("orders", 
					[
						"orderid" 		=> $orderid,
						"quantity" 		=> 1,
						"clientid"		=> $clientid,
						"foodid" 		=> $foodid,
						"foodname"		=> $foodname,
						"amount" 		=> $amount,
						"restaurant_id"	=> $restaurantid
					]
				);
				$thereareorders = true;

				$result = $addorder;
				break;

			case 'delete':
				$foodid 	= $_POST['foodid'];
				$orderid 	= $_POST['orderid'];

				$removeorder = $db->delete("orders", ["id" => $foodid, ]);
				$checkotherorders = $db->get("orders", "id", ["orderid" => $orderid]);

				$thereareorders = $checkotherorders ? true : false;
				$result = $removeorder;
				break;
			
		}

		$total = $db->sum("orders", "amount", ["orderid" => $_POST['orderid']]);
			
	}

	echo json_encode(array(
		'result' 	=> $result,
		'orders' 	=> $thereareorders,
		'total' 	=> $total,
		'session' 	=> $_SESSION
	));

?>