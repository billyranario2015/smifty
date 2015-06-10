<?php 

	/**
	*  @Router for pages
	*/
	class PageHandler
	{
		private $db;
		private $twig;

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

		public function get($request = false)
		{

			$view = !$request ? 'home' : $request;

			$twig = $this->setEnvironment();

			try {
				echo $twig->render($view.'.html.twig', array());

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array());
			}
		}

		public function post($request = false)
		{
			$twig = $this->setEnvironment();
			$data = array();

			if (isset($_POST['intent'])) {
				$username  	= $_POST['signup']['username'];
				$password  	= $_POST['signup']['password'];
				$password2 	= $_POST['signup']['password2'];
				$firstname 	= $_POST['signup']['firstname'];
				$lastname 	= $_POST['signup']['lastname'];
				$phone 		= $_POST['signup']['phone'];
				$email 		= $_POST['signup']['email'];
				$address 	= $_POST['signup']['address'];
				$city 		= $_POST['signup']['city'];
				$state 		= $_POST['signup']['state'];
				$country 	= $_POST['signup']['country'];
				$zip 		= $_POST['signup']['zip'];

				if ($password == $password2) {
					$insertuser = $this->db->insert("clients", 
						[
							"username" 	=> $username,
							"password" 	=> $this->getHash($password),
							"firstname"	=> $firstname,
							"lastname" 	=> $lastname,
							"phone" 	=> $phone,
							"email" 	=> $email,
							"address" 	=> $address,
							"city" 		=> $address,
							"state" 	=> $state,
							"country" 	=> $country,
							"zip" 		=> $zip
						]
					);

					if ($insertuser) {
						$success = true;
						$error = false;
						$request = '/';
					} else {
						$success = false;
						$error = true;
					}
				} else {

					$data['error_password'] = true;
					$error = true;
					$success = false;
				}
			} else {
				$error = true;
				$success = false;
			}

			try {
				echo $twig->render($request.'.html.twig', 
					array(
						'error' => $error,
						'success' => $success,
						'data' 		=> $data
					));

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array());
			}
		}
	}

?>