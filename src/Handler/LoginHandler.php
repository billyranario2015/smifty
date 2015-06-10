<?php 

	/**
	*  @Router for Logging in
	*/
	class LoginHandler
	{
		private $db;
		private $twig;
		private $salt;
		private $usertype;
		private $islogged;
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

		public function get($type = false)
		{

			switch ($type) {
				case 'admin':
					break;

				case 'customer':

					break;
				
				default:
					# code...
					break;
			}

			$this->usertype = $type;

			$twig = $this->setEnvironment();

			try {
				echo $twig->render('user-login.html.twig', 
					array(
						'usertype' => $this->usertype
					)
				);

			} catch (Exception $e) {

				echo $twig->render('customer-login.html.twig', array());
			}
		}
		public function post($usertype)
		{

			$username = $_POST['login']['username'];
			$password = $this->getHash($_POST['login']['password']);

			$twig = $this->setEnvironment();

			switch ($usertype) {
				case 'admin':
					$checkuser = $this->db->get("admin", "id", 
						["AND" =>
							[
								"username" => $username,
								"password" => $password
							]
						]
					);
					

					if ($checkuser) {
						$_SESSION['userid'] = $checkuser;
						$view = '/admin/dashboard';
						$this->redirect($view);
					} else {
						echo $twig->render('user-login.html.twig', array(
							"error" 	=> true
						));
					}
					break;

				case 'customer':
					$checkuser = $this->db->get("clients", "id", 
						["AND" =>
							[
								"username" => $username,
								"password" => $password
							]
						]
					);
					

					if ($checkuser) {
						$_SESSION['clientid'] = $checkuser;
						$view = '/';
						$this->redirect($view);
					} else {
						echo $twig->render('user-login.html.twig', array(
							"error" 	=> true
						));
					}
					break;

				case 'restaurant':
					$checkuser = $this->db->get("admin", "id", 
						["AND" =>
							[
								"username" => $username,
								"password" => $password
							]
						]
					);
					

					if ($checkuser) {
						$_SESSION['userid'] = $checkuser;
						$view = '/admin/restaurant';
						$this->redirect($view);
					} else {
						echo $twig->render('user-login.html.twig', array(
							"error" 	=> true
						));
					}

					break;
				
				default:
					# code...
					break;
			}
		}
	}

?>