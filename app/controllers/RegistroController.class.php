<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/DocenteDAO.class.php';

	/**
	 * 
	 */
	class RegistroController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('registro.html', $request, '');
		}

		public function render(){

			if($this->user->isLogued()){
				$this->login(); // Si está logueado, lo enviamos al index.
			}else{
				$error = ''; 
				if($this->request->methodIsPost()){
					switch ($this->request->getParam('action')) {
						case 'register':
							try {
								$result = $this->user->register($this->request->getParam('email'), $this->request->getParam('pass'));
								if($result){
									$centro = $this->request->getElement(1);
									if($centro){
										require_once 'app/models/CentrosDAO.class.php';
										$centro_id = (new CentrosDAO())->getCentroIdByLink($centro);
									}
									$centro_id = isset($centro_id) && $centro_id ? $centro_id : 1;
									$result = (new DocenteDAO())->insert(['usuario_id' => $result, 'centro_id' => $centro_id, 'estado' => 'Perfil incompleto']);
									$this->user->login($this->request->getParam('email'), $this->request->getParam('pass'));
									$this->redirectTo('perfil');
								}
								return; 
							} catch (\PDOException $ex) {
								if($ex->getCode() == 23000){
									$error = 'Este correo ya existe. ¿Deseas <a href="/">iniciar sesión</a>?. En caso de que no recuerdes la contraseña, puedes recuperarla <a href="/resetPass">aquí</a>.';
								}else{
									throw $ex; // Lanzamos la excepción para recuperarla en el index y que se guarde en el log
								}
								
							}
							
							break;
						default:
							# code...
							break;
					}
				}
				//$this->addArgument('etapas', (new DocenteDAO())->getEtapas());
				//$this->addArgument('areas', (new DocenteDAO())->getDefaultAreas());
				$this->addArgument('error', $error);
				return parent::render();
			}
		}

	}

 ?>