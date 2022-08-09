<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/UsuariosDAO.class.php';
	require_once 'app/models/ResetPassDAO.class.php';
	//require_once 'app/models/DocenteDAO.class.php';

	/**
	 * 
	 */
	class ResetPassController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('resetpass.html', $request, false);
		}

		public function render(){

			if($this->request->methodIsGet()){
				$peticionCambioID = $this->request->getElement(1);
				if($peticionCambioID){
					$user_id = (new ResetPassDAO())->getUserIdByPetitionId($peticionCambioID);
					$estado = $user_id ? 2 : 3;
				}else{
					$estado = 0; 
				}

			}else{
				if($this->request->methodIsPost()){
					switch ($this->request->getParam('action')) {
						case 'resetPassRequest':
							$user = (new UsuariosDAO())->getUsuarioByEmail($this->request->getParam('email'));
							if($user){
								$peticion_id = (new ResetPassDAO())->insertOrUpdatePeticion($user['id']);
								if($peticion_id){
    								Mail::resetPassEmail($user['email'], $peticion_id);
								}
							}
							$estado = 1; 
							break;
						case 'updatePass':
							$peticionCambioID = $this->request->getElement(1);
							if($peticionCambioID){
								$user_id = (new ResetPassDAO())->getUserIdByPetitionId($peticionCambioID);
								if($user_id){
									UserControl::updatePass($user_id["usuario_id"], $this->request->getParam('pass'));
								}
							}
							$this->login(); // Lo redirigimos al login
							return; 
							break;
						default:
							# code...
							break;
					}
				}
				//$this->addArgument('etapas', (new DocenteDAO())->getEtapas());
				//$this->addArgument('areas', (new DocenteDAO())->getDefaultAreas());
				
			}
			$this->addArgument("estado", $estado);

				return parent::render();
		}

	}

 ?>