<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/DocenteDAO.class.php';
	require_once 'app/models/CentrosDAO.class.php';

	/**
	 * 
	 */
	class PerfilController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('perfil.html', $request);
		}

		public function render(){

				if($this->request->methodIsPost()){
					
					switch ($this->request->getParam('action')) {
						case 'save':
							$data = $this->request->getParam('data', false);
							$data['usuario_id'] = $this->user->getUserId();
							if($this->docente['estado'] == 'Perfil incompleto'){
								$data['estado'] = 'Hacer Area 0 TestCDD'; // Si venía del estado 0, le añadimos el estado = 1 que implica que ya ha completado el perfil.
							}
							$result = (new DocenteDAO())->update($data, ['updateEtapas' => true]);
							$data['id'] = $result; 
							return parent::renderJson(['ok' => true, 'data' => $data, 'msg' => 'Perfil modificado correctamente']);
							break;
						case 'getCentros':
							$data = $this->request->getParam('data', false);
							$centros = (new CentrosDAO())->getByCodigoPostal($data['codigoPostal']);
							return parent::renderJson(['ok' => true, 'centros' => $centros, 'msg' => 'Perfil modificado correctamente']);
							break;
						default:
							# code...
							break;
					}
				}else if($this->request->methodIsGet()){
					$docenteDAO = new DocenteDAO(); 
					$centro = (new CentrosDAO())->getById($this->docente['centro_id'], ['select' => 'id, nombre']);
					$this->addArgument('docente', $this->docente);
					$this->addArgument('centro', $centro);
					$this->addArgument('etapas', $docenteDAO->getEtapas());
					$this->addArgument('cambioDeCentro', $centro && $centro['id'] > 1 ? 'false': 'true'); // Si ya tienes un centro seleccionado, ya no se puede cambiar de centro. 
					$this->addArgument('areas', $docenteDAO->getDefaultAreas());

					return parent::render();
				}
				
			
		}

	}

 ?>