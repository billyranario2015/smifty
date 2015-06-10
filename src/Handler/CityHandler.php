<?php 

	/**
	*  @Router for pages
	*/
	class CityHandler
	{

		private $db;
		private $twig;
		private $resta;

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
			

			//get restaurants
			$restaurants = $this->db->select("restaurant", "*", ["status" => 1, "ORDER" => "name ASC"]);



			//set view
			$twig = $this->setEnvironment();
			$view = $request;

			//get files from directory
			//$dir = './assets/images/restaurants/';
			//$files = array_diff(scandir($dir), array('..', '.', '.DS_Store'));

			try {
				echo $twig->render('/restaurant.html.twig', 
					array(
						//'files' 		=> $files,
						'restaurant'	=> $restaurants
					));

			} catch (Exception $e) {

				echo $twig->render('/404.html.twig', array('name' => 'Fabien'));
			}
		}
	}
?>