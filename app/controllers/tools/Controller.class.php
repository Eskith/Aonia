<?php  

	require_once 'app/controllers/tools/UserControl.class.php'; 

	abstract class Controller {
		private static $loader;
		private static  $twig;
		private static $templatesPath = "./app/html/";
		protected $view;
		protected $arguments = [];
		protected $request;
		protected $user; 
		protected $docente; 

		protected $userControl;
		private static $allowedLoginPaths = [""];


		function __construct(string $view,  Request $request, string $role = "docente")
		{
			$this->view 		 = $view;
			$this->request 		 = $request;
			$this->user 		 = new UserControl();
			$this->docente 		 = null;

			if( ($role && !$this->user->isLogued()) || !$this->user->hasRole($role) ){
				//if(!$this->user->isLogued() && $mustBeLogued){
				$this->login();
			}elseif(	$this->request->methodIsPost() 
					&&  $this->request->getParam("action") === "logout" ) {
					$this->user->logout();
					$this->login();
			}



			// Aquí ya sabemos que cumple con los permisos de usuario para ver la vista.
			if($this->user->hasRole('docente')){
				require_once 'app/models/DocenteDAO.class.php';
				$this->docente = (new DocenteDAO())->getById($this->user->getUserId());
				// Si aún no ha completado el perfil, lo obligamos a que termine el registro
				if($this->docente['estado'] == 'Perfil incompleto'){
					$this->redirectTo('perfil'); // Lo obligamos a que complete el pertil.
				}elseif($this->docente['estado'] == 'Hacer Area 0 TestCDD' || $this->docente['estado'] == 'Hacer TestCDD'){
					//Estado 1 tiene que hacer el Area 0
					//Estado 2 no tiene que hacer el Area 0
					$this->redirectTo('testCDD'); // Lo obligamos a que haga el TestCDD
				}
			}
			

		}

		public function addArgument(string $argument, $value)
		{
			$this->arguments[$argument] = $value;
		}

		protected function notFound()
		{
			require_once 'app/controllers/Index.class.php';
			$aux = new Index($this->request); 
			return $aux->render(); 
		}

		protected function redirectTo(string $url):void 	
		{
			if(strtolower($this->request->getElement(0)) !== strtolower($url)){
				header("Location: /$url");
				die();
			}
		}

		protected function login():void
		{	
			$this->redirectTo('');
		}

		protected function forbiden(string $text = "Forbiden"):void
		{
			/*header('Location: /');
			exit;*/
			header("HTTP/1.1 403 $text.");
			exit("403 $text.");
		}

		/* Checks the origen request */
		protected function origenAllowed(array $acceptedOrigins = []):bool{
			//self::$acceptedOrigins[] = $this->getSiteConfig()["urlIndex"];
			$acceptedOrigins[] = "http://localhost";
			$acceptedOrigins[] = substr(getSiteConfig()["urlIndex"], 0,strlen(getSiteConfig()["urlIndex"])-1);
			if (isset($_SERVER['HTTP_ORIGIN'])) {
				// same-origin requests won't set an origin. If the origin is set, it must be valid.
				if (in_array($_SERVER['HTTP_ORIGIN'], $acceptedOrigins)) {
					header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
					return true;
				} else {
					$this->forbiden("Origin Denied");
				}
			}else{
				$this->forbiden("Origin doesn't found");
			}
		}

		protected function userLoguedOrBlock():bool
		{
			if ($this->userControl->isLogued()) {
				return true;
			}else{
				$this->forbiden("User not allowed");
			}
		}

		protected function userAdminOrBlock():bool
		{
			if ($this->userControl->isAdmin()) {
				return true;
			}else{
				$this->forbiden("User not allowed");
			}
		}

		protected function changeView(String $view)
		{
			$this->view = $view; 
		}

		private static function getTwig(){
			if(!isset(self::$twig)){
				require_once 'app/dependencies/vendor/autoload.php';
				if(!isset(self::$loader))
					self::$loader = new \Twig\Loader\FilesystemLoader(self::$templatesPath.'/'.Config::getValue('template'));
				self::$twig = new \Twig\Environment(self::$loader);
			}
			return self::$twig;
		}

		public function render(){
			$this->addArgument("user", $this->user);
			return self::getTwig()->load($this->view)->render($this->arguments);
			
		}

		public function renderJson($data):string{ 
			header('Content-Type: application/json');
			return json_encode($data);
		}
	}

?>