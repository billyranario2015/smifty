<?php 

	/**
	*  @Router for ordering
	*/
	class OrderHandler
	{
		private $db;
		private $twig;

		function __construct()
		{
			$this->db = new medoo();
		}

		private function setEnvironment()
		{
			$loader = new Twig_Loader_Filesystem('tpl');
			$twig = new Twig_Environment($loader, array());

			return $this->twig = $twig;
		}

		public function get($request = false)
		{
			// set view
			$twig = $this->setEnvironment();
			$view = $request;

			$userdetails = $this->db->select("clients",
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
				]
			);

			try {
				echo $twig->render('place-order.html.twig', 
					array(
						'userdetails' => $userdetails
					));

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array('name' => 'Fabien'));
			}
		}
	}
?>