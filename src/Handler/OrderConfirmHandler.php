<?php 

	/**
	*  @Router for order confirmation
	*/
	class OrderConfirmHandler
	{
		private $db;
		private $twig;

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

		public function get()
		{

			$clientid = isset($_SESSION['customerid']);
			$orderid = isset($_SESSION['orderid']);

			// set view
			$twig = $this->setEnvironment();

			//get orders
			//$getorders = $this->db->select("orders", "*", ["orderid" => $_SESSION['orderid']]);
			$getorders = $this->db->select("orders", 
				["[>]restaurant" => ["restaurant_id" => "id"] ],
				[
					"orders.orderid", 
					"orders.foodname",
					"orders.quantity",
					"orders.amount",
					"restaurant.name"
				],
				["orders.orderid" => $_SESSION['orderid']]);

			//var_dump($this->db->last_query());
			//var_dump($getorders);

			try {
				echo $twig->render('order-confirmation.html.twig', 
					array(
						'orders' => $getorders
					));

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array('name' => 'Fabien'));
			}
		}
	}
?>