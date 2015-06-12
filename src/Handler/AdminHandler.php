<?php 

	/**
	*  @Router for Admin
	*/
	class AdminHandler
	{
		private $db;
		private $twig;
		//clientid

		function __construct()
		{
			$this->db = new medoo();
		}

		private function getHash($pass)
		{
			return hash('md5', $pass);
		}

		private function setEnvironment()
		{
			$loader = new Twig_Loader_Filesystem('tpl');
			$twig = new Twig_Environment($loader, array());

			return $this->twig = $twig;
		}

		private function redirect($url, $permanent = false)
		{
		    if (headers_sent() === false)
		    {
		        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
		    }

		    exit();
		}

		public function get($request = false)
		{
			$twig = $this->setEnvironment();
			$getRestaurantInfo = null;
			$restaurantID = null;
			$count_orders = null;

			switch ($request) {
				case 'dashboard':
					$getorders = $this->db->select("orders", "*",  ["GROUP" => "orderid", "LIMIT" => 5 , "status" => NULL], ["ORDER" => "dateordered ASC"]);
					$getPlacedOrders = $this->db->select( "orders", "*" , ["GROUP" => "orderid" , "status[!]" => NULL ] );
					$getrestaurants = $this->db->select("restaurant", "*", ["ORDER" => "name ASC"]);
					$getSettings = $this->db->select("settings", "*");

					$currency = $this->db->get("settings", "value", ["fieldname" => "currency"]);

					$appSetting = array();

					foreach ($getSettings as $key => $value) {
						$appSetting[$value['fieldname']]['url'] = $value['value'];
						$appSetting[$value['fieldname']]['active'] = $value['active'];
					}

					//var_dump($appSetting);
					$view = 'dashboard';

					break;

				case 'restaurant':
					$user_id = $_SESSION['userid'];
					$getSettings = $this->db->select("settings", "*");
					$getRestaurantInfo = $this->db->select( "restaurant", "*", ["user_id" => $user_id ]);

					// Add session for restaurant id
					$_SESSION['restaurant_id'] = $getRestaurantInfo[0]['id'];
					$restaurantID = $_SESSION['restaurant_id'];
					
					$getorders = $this->db->select("orders", "*",  ["GROUP" => "orderid", "LIMIT" => 5 , "status" => NULL], ["ORDER" => "dateordered ASC" , "restaurant_id" => $_SESSION['restaurant_id'] ]);
					$getPlacedOrders = $this->db->select( "orders", "*" , ["GROUP" => "orderid" , "status[!]" => NULL ] );
					
					$currency = $this->db->get("settings", "value", ["fieldname" => "currency"]);

					$appSetting = array();

					foreach ($getSettings as $key => $value) {
						$appSetting[$value['fieldname']]['url'] = $value['value'];
						$appSetting[$value['fieldname']]['active'] = $value['active'];
					}
					// var_dump($_SESSION);
					$view = 'restaurant';
					break;
				
				default:
					# code...
					break;
			}


			try {
				echo $twig->render('/admin/'.$view.'.html.twig', 
					array(
						'logged' 			=> '1',
						'orders' 			=> $getorders,
						'placed_orders' 	=> $getPlacedOrders,
						"activepanel" 		=> 'dashboard',
						"userid" 			=> $_SESSION['userid'],
						"restaurantid"		=> $restaurantID,
						"settings" 			=> $appSetting,
						"currency" 			=> $currency,
						"restaurant_info"	=> $getRestaurantInfo,
						"countOnProgressOrders" => $count_orders
					)
				);

			} catch (Exception $e) {
				echo $twig->render('404.html.twig', array());
			}
		}

		public function post()
		{
			$intent = $_POST['intent'];

			$twig = $this->setEnvironment();

			$getorders = $this->db->select("orders", "*", ["GROUP" => "orderid"], ["ORDER" => "dateordered ASC"]);
			$getrestaurants = $this->db->select("restaurant", "*", ["ORDER" => "name ASC"]);

			switch ($intent) {
				case 'add-restaurant':
					$name = $_POST['restaurant']['name'];
					$city = $_POST['restaurant']['city'];
					$address = $_POST['restaurant']['address'];
					$phone = $_POST['restaurant']['phone'];

					$addrestaurant = $this->db->insert("restaurant", 
						[
							"name" => $name,
							"city" => $city,
							"address" => $address,
							"phone" => $phone,
						]
					);

					if ($addrestaurant) {
						echo $twig->render('/admin/dashboard.html.twig', 
							array(
								'logged' => '1',
								'orders' => $getorders,
								"restaurants" => $getrestaurants,
								"activepanel" => 'restaurants',
								"result" 	=> 'Restaurant Added!'
							)
						);
					}
					break;
				
				default:
					# code...
					break;
			}
		}
	}

?>