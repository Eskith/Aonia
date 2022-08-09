<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/TestCddDAO.class.php';

	/**
	 * 
	 */
	class AdminController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('admin.html', $request, "administrador");
		}

		public function render(){

			if (	$this->request->methodIsPost() 
			  	&&  $this->request->getParam("action") === "login" 
			  	&&  $this->request->getParam("email") !== ""
			  	&&  $this->request->getParam("pass") !== ""
			) {
				if(!$this->user->login($this->request->getParam("email"), $this->request->getParam("pass"))){
					$this->addArgument("loginError", "Usuario y/o contraseña incorrectos");
					$this->user->logout();
				}
			}

			// Controlamos que el usuario esté logueado
			if(!$this->user->isLogued()){
				$this->changeView("login.html");
				return parent::render();
			}

			if($this->request->methodIsPost() && $this->user->isLogued()){
					switch ($this->request->getParam("action")) {
						case 'searchUser':
							$tests = (new TestDAO)->getMarkssByUserId(intval($this->request->getParam("userId")));
							$this->addArgument("tests", $tests);
							return parent::renderJson($tests);
							break;
						case 'insert':
							$result = (new TestDAO)->insert( json_decode($this->request->getParam("responses", false), true), 1); 
							return parent::renderJson($result);
							break;
						
						default:
							# code...
							break;
					}
			}

			return parent::render();

		}


	}

 ?>