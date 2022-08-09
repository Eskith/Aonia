<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';

	require_once 'app/models/CentrosDAO.class.php';
	require_once 'app/utils/subidaMasivaDocentes.php';
	require_once 'app/utils/ProcesaArchivos.php';

	/**
	 * 
	 */
	class DocentesController extends Controller
	{	
		
		function __construct($request){

			parent::__construct('docentes.html', $request, 'administrador');
		}

		public function render(){

            if($this->request->methodIsGet()){
				return parent::render();
			}else if($this->request->methodIsPost()){
				switch ($this->request->getParam("action")) {
					case 'getData':
						$docente_id = $this->request->getElement(1);
						$centro_id = $this->request->getElement(2);
						$docentes = null;
						if($docente_id == 'centro' && $centro_id){
							require_once 'app/models/CentrosDAO.class.php';
							$docentes = (new DocenteDAO())->getByCentroId($centro_id);
						}else{
							$docentes = (new DocenteDAO())->getAll();
						}
						return $this->renderJson(['ok' => true, 'data' => ($docentes ? $docentes : '')]);
						break;
					case 'subidaMasiva':
						$centroId = $this->request->getParam("centroId"); 
						$file = $_FILES['file'];
						$docentes = ProcesaArchivos::ProcesaCSV($file['tmp_name']); 
						$result = importarDocentes($docentes, $centroId, ['enviarMailBienvenida' => true]);
						return parent::renderJson($result); 
						break;
					case 'save':
						$data = $this->request->getParam('data', false);
						if(isset($data['id']) && !isset($data['usuario_id'])){
							$data['usuario_id'] = $data['id'];
							unset($data['id']);
						}
						if(!isset($data['usuario_id'])){// Es un nuevo usuario
							$userId  = UserControl::register($data["email"], $data["pass"]);
							$data['usuario_id'] = $userId;
							$result = (new DocenteDAO())->insert($data);
							return parent::renderJson(['ok' => true, 'data' => ['id' => $result], 'msg' => 'Centro añadido correctamente']);
						}else{// Se va a actualizar el usuario
							if($data['pass'] && isset($data['usuario_id'])){UserControl::updatePass($data["usuario_id"], $data["pass"]);} // La contraseña sólo se puede actualizar al modificar un usuario, no al crearlo
							$result = (new DocenteDAO())->update($data);
							return parent::renderJson(['ok' => true, 'data' => ['id' => $result], 'msg' => 'Centro modificado correctamente']);
						}
						break;
						
					case 'searchCentros':
						$text = $this->request->getParam("text");
						echo json_encode((new CentrosDAO())->get(['select' => "id value, nombre text", 'where' => "nombre like ('%$text%')"]));
						break;
					case 'remove':
						echo json_encode(['ok' => (new DocenteDAO())->delete($this->request->getParam("id"))]);
						break;
					default:
						return parent::renderJson(['ok' => false]);
						break;
				}
			}

		}

	}

 ?>