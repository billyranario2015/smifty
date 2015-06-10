<?php 

	/**
	*  @Router for Authentication
	*/
	class AuthHandler
	{
		private $db;
		private $twig;
		private $salt;
		private $islogged;

		function __construct()
		{
			$this->db = new medoo();

			$this->islogged = isset($_SESSION['clientid']);
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

		public function get($type = false)
		{

			$twig = $this->setEnvironment();

			$view = 'login';

			switch ($type) {
				case 'logout':
					session_unset();
					session_destroy();

					$this->redirect('/');
					break;
				
				default:
					# code...
					break;
			}

			try {
				echo $twig->render($view.'.html.twig', 
					array(
					
					)
				);

			} catch (Exception $e) {

				echo $twig->render('customer-login.html.twig', array());
			}
		}

		public function post()
		{
			$user = $_POST['login']['username'];
			$pass = $_POST['login']['password'];

			$hashpass = $this->getHash($pass);

			$twig = $this->setEnvironment();

			$checklogin = $this->db->select("clients", "*", 
				["AND" => 
					[
						"username" => $user,
						"password" => $hashpass
					]
				]);

			if (!$checklogin) {
				echo $twig->render('customer-login.html.twig', 
					array(
						'error' 	=> true
					)
				);
			} else { // proceed to order confirmation
				
				$_SESSION['clientid'] = $checklogin[0]['id'];
				$this->db->update("orders", 
					[
						"clientid" => $_SESSION['clientid']
					],
					["orderid" => $_SESSION['orderid']]
				);
				$this->redirect('/order-confirmation', false);
			}
		}
	}

?>