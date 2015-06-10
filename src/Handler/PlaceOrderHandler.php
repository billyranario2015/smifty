<?php 

	/**
	*  @Router for payment
	*/
	class PlaceOrderHandler
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

		public function get($request = false)
		{

			//check if already has an order
			if (!isset($_SESSION['orderid'])) {
				$this->redirect('/');
			} else {
				// get orders

				$orderid = $_SESSION['orderid'];
				$clientid = $_SESSION['clientid'];

				$orders = $this->db->select("orders", "*", ["AND" => ["orderid" => $orderid, "clientid" => $clientid]]);

				// get total
				$total = $this->db->sum("orders", "amount", ["orderid" => $orderid]);

				// get client details
				$clientdetails = $this->db->select("clients", 
					[
						"firstname",
						"lastname",
						"phone",
						"email",
						"address",
						"city",
						"state",
						"country",
						"zip"
					], 
					[
						"id" => $clientid
					]);

				// get settings
				$currency = $this->db->get("settings", "value", ["fieldname" => "currency"]);
			}


			//set view
			$twig = $this->setEnvironment();
			$view = $request;

			try {
				echo $twig->render('payment.html.twig', 
					array(
						'orders' 				=> $orders,
						'currency'				=> $currency,
						'orderid' 				=> $orderid,
						'total'					=> $total,
						'client'				=> $clientdetails
					));

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array('name' => 'Fabien'));
			}
		}

		public function post()
		{

			$name 		= $_POST['order']['nameoncard'];
			$fname 		= $_POST['order']['firstname'];
			$lname 		= $_POST['order']['lastname'];
			$cardnum 	= $_POST['order']['cardnumber'];
			$address 	= $_POST['order']['b_address'];
			$amount 	= $_POST['order']['amount'];
			$expiry		= $_POST['order']['expiry'];
			$cvv 		= $_POST['order']['cvv'];

			$twig = $this->setEnvironment();

			require_once 'vendor/authorizenet/authorizenet/AuthorizeNet.php';

			define("AUTHORIZENET_API_LOGIN_ID", "4U9rK2V9Swn");
			define("AUTHORIZENET_TRANSACTION_KEY", "99rN9WVFmH943cv4");
			define("AUTHORIZENET_SANDBOX", true);
			$sale           	= new AuthorizeNetAIM;
			$sale->first_name   = $fname;
			$sale->last_name   	= $lname;
			$sale->address   	= $address;
			$sale->amount   	= $amount;
			$sale->card_num 	= $cardnum;
			$sale->card_code 	= $cvv;
			$sale->exp_date 	= '01/18';
			$response = $sale->authorizeAndCapture();

			//var_dump($response);

			$clientid = $_SESSION['clientid'];

			if ($response->approved) {
			    $transaction_id = $response->transaction_id;
			    $auth_code = $response->transaction_id;

			    // Now capture:
			    $capture = new AuthorizeNetAIM;
			    $capture_response = $capture->priorAuthCapture($auth_code);

			    // Now void:
			    //$void = new AuthorizeNetAIM;
			    //$void_response = $void->void($capture_response->transaction_id);

			    // send confirmation email
			    $customeremailadd = $this->db->get('clients', 'email', ['id' => $clientid]);
			    
			    $transport = Swift_MailTransport::newInstance();
			    $message = Swift_Message::NewInstance('Order Confirmation')
			    	->setFrom('order@swifty.com')
			    	->setTo($customeremailadd)
			    	->setBody("Total Order :" . $amount)
			    	;


			    echo $twig->render('complete.html.twig', 
				array(
					'logged' 	=> isset($_SESSION['clientid']),
					'authcode'	=> $auth_code,
					'response'	=> $response->response_reason_text,
					'invoicenum'=> $auth->invoice_num
				));
			} else {
				$orderid = $_SESSION['orderid'];

				$orders = $this->db->select("orders", "*", ["AND" => ["orderid" => $orderid, "clientid" => $clientid]]);

				// get total
				$total = $this->db->sum("orders", "amount", ["orderid" => $orderid]);

				// get client details
				$clientdetails = $this->db->select("clients", 
					[
						"firstname",
						"lastname",
						"phone",
						"email",
						"address",
						"city",
						"state",
						"country",
						"zip"
					], 
					[
						"id" => $clientid
					]);

				// get settings
				$currency = $this->db->get("settings", "value", ["fieldname" => "currency"]);

				echo $twig->render('payment.html.twig', 
				array(
					'error' 	=> true,
					'orders' 	=> $orders,
					'currency'	=> $currency,
					'orderid' 	=> $orderid,
					'total'		=> $total,
					'client'	=> $clientdetails,
					'logged' 	=> isset($_SESSION['clientid']),
					'response'	=> $response->response_reason_text,
					'error_message' => $response->error_message
				));
			}

/*
			
*/
		}
	}
?>