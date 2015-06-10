<?php

	require_once '../vendor/catfan/medoo/medoo.php';
	$db = new medoo();
	session_start();

	if ($_POST['usertype'] == 'restaurant') {
		$request = $_POST['keyword'];

		$list = $db->select("food", "*",
			["AND" => ["restaurant" => $_SESSION['userid'], "foodname[~]" => $request ]]
			
		);

	} else {

		$request = $_POST['keyword'];
		
		if (isset($_POST['table'])) {
			$list = $db->select("restaurant", "*",
				["name[~]" => $request]
			);

		} else {

			$list = $db->select("food", 
				["[<]restaurant" => ["restaurant" => "id"]], 
				[
					"food.id", 
					"food.foodname",
					"food.amount",
					"restaurant.name"
				],
				["food.foodname[~]" => $request ]
			);
		}
			
	}	

	//echo json_encode($foodlist);
	echo json_encode($list);
?>