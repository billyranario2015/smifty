<?php 

	/**
	*  @Router for Homepage
	*/
	class HomeHandler
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
			
			//get cities
			$cities = $this->db->select("city", "*", ["ORDER" => "city.order ASC"]);
			
			$getSettings = $this->db->select("settings", "*");

			$appSetting = array();

			foreach ($getSettings as $key => $value) {
				$appSetting[$value['fieldname']]['url'] = $value['value'];
				$appSetting[$value['fieldname']]['active'] = $value['active'];
			}


			//set view
			$view = !$request ? 'home' : $request;

			$twig = $this->setEnvironment();

			try {
				echo $twig->render($view.'.html.twig', 
					array(
						'cities' => $cities,
						'settings' => $appSetting,
						'logged' => isset($_SESSION['clientid'])
					)
				);

			} catch (Exception $e) {

				echo $twig->render('404.html.twig', array('name' => 'Fabien'));
			}
		}

	}

?>