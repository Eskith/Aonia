<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';

	require_once 'app/models/TestCddDAO.class.php';

	/**
	 * 
	 */
	class Index extends Controller
	{	
		
		function __construct($request){
			parent::__construct('index.html', $request, '');
		}

		public function render(){

			// Enable debugging
			//phpCAS::setDebug();
			// Enable verbose error messages. Disable in production!
			//phpCAS::setVerbose(true);

			/* Esto se debe cambiar, el login ya no es con usuario y contraseña */
			if (	$this->request->methodIsPost() 
			  	&&  $this->request->getParam("action") === "login" 
			  	&&  $this->request->getParam("email") !== ""
			  	&&  $this->request->getParam("pass") !== ""
			) {
				if(!$this->user->login($this->request->getParam("email"), $this->request->getParam("pass"))){
					$this->addArgument("loginError", 'Usuario y/o contraseña incorrectos. Si no recuerdas la contraseña puedes recuperarla <a href="/resetPass">aquí</a>.');
					$this->user->logout();
				}
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
			/* fin del login con usuario y contraseña */

			if($this->user->isLogued()){
				$tests = (new TestCddDAO)->getCalificacionesByUsuarioId($this->user->getUserID());
				$this->addArgument("tests", json_encode($tests)); 
			}else{
				$this->changeView("login.html");
			}
			return parent::render();
			
		}

	}

 ?>