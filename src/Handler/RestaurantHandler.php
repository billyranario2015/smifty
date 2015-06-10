<?php 

	/**
	*  @Router for restaurant
	*/
	class RestaurantHandler
	{

		private $db;
		private $twig;
		private $restaurant;
		private $orderid;
		private $orders;
		private $total;

		function __construct()
		{
			$this->db = new medoo();
		}

		private function redirect($url, $permanent = false)
		{
		    if (headers_sent() === false)
		    {
		        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
		    }

		    exit();
		}

		private function setEnvironment()
		{
			$loader = new Twig_Loader_Filesystem('tpl');
			$twig = new Twig_Environment($loader, array());

			return $this->twig = $twig;
		}

		
		public function get($request = false)
		{
			$this->restaurant = $request;

			//check if already has an order
			if (!isset($_SESSION['orderid'])) {
				$session_order_id = $_SESSION['orderid'] = date_timestamp_get(date_create());
				$addinitialorder = $this->db->insert("orders", ["orderid" => $session_order_id]);
			} else {
				// get orders
				$this->orderid = $_SESSION['orderid'];
				$this->orders = $this->db->select("orders", "*", ["orderid" => $this->orderid]);

				// get total
				$this->total = $this->db->sum("orders", "amount", ["orderid" => $this->orderid]);
			}

			//get food list from restaurants
			$restaurant_info = $this->db->select("restaurant", "*", ["id" => $request]);
			$foodlist = $this->db->select("food", "*", ["restaurant" => $this->restaurant, "ORDER" => "foodname ASC"]);

			// get settings
			$currency = $this->db->get("settings", "value", ["fieldname" => "currency"]);


			//set view
			$twig = $this->setEnvironment();
			$view = $request;

			try {
				echo $twig->render('place-order.html.twig', 
					array(
						'foodlist'				=> $foodlist,
						'restaurant_info' 		=> $restaurant_info,
						'orders' 				=> $this->orders,
						'currency'				=> $currency,
						'orderid' 				=> $this->orderid,
						'total'					=> $this->total
					));

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array('name' => 'Fabien'));
			}
		}

		public function post()
		{
			//get customer's orders
			$orders = $this->db->select("orders", "*", ["orderid" => $_POST['orderid']]);

			$twig = $this->setEnvironment();

			if (!isset($_SESSION['clientid'])) {
				echo 'here';
				$this->redirect('/customer-login');
			} else {
				$this->redirect('/order-confirmation');
			}

		}
	}
?>