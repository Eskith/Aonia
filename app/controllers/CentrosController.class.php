<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/InstitucionesDAO.class.php';
	require_once 'app/models/CentrosDAO.class.php';
	require_once 'app/models/TestCddDAO.class.php';
	require_once 'app/utils/Informe_centro.php';
	require_once 'app/utils/ProcesaArchivos.php';

	/**
	 * 
	 */
	class CentrosController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('centros.html', $request, 'administrador');
		}

		public function render(){

            if($this->request->methodIsGet()){
				$this->addArgument('instituciones', (new InstitucionesDAO())->getInstituciones());
				return parent::render();
			}else if($this->request->methodIsPost()){
				switch ($this->request->getParam("action")) {
					case 'getData';
							$options = [];
							$options['all'] = $this->request->getParam("all");
							$result = (new CentrosDAO())->getCentros($options);
							//var_dump($centros);
							return parent::renderJson(['ok' => true, 'data' => $result, 'msg' => 'Centros obtenidos correctamente']);
						break; 
					case 'save':
						$data = $this->request->getParam('data', false);
						if(isset($data['id'])){
							//update
							$result = (new CentrosDAO())->update($data);
							return parent::renderJson(['ok' => true, 'data' => ['id' => $result], 'msg' => 'Centro modificado correctamente']);
						}else{
							$result = (new CentrosDAO())->insert($data);
							return parent::renderJson(['ok' => true, 'data' => ['id' => $result], 'msg' => 'Centro añadido correctamente']);
						}
						return ;
					case 'remove':
						try {
							$result = (new CentrosDAO())->delete($this->request->getParam("id"));
							return parent::renderJson(['ok' => true, 'msg' => 'Centro eliminado correctamente']);
						} catch (\PDOException $th) {
							if($th->getCode() === 23000)
								return parent::renderJson(['ok' => false, 'error' => 'El centro no pudo eliminarse porque hay alumnos ligados a él.']);
							else
								throw $th;
						}
						
						break;
					case 'generarInforme':
						$centro_id = $this->request->getParam("centro_id"); 
						$centro = (new CentrosDAO())->getById($centro_id, ['select' => 'nombre']);
						$calificaciones = (new TestCddDAO())->getCalificacionesByCentroId($centro_id);
						$nUsuarios = count($calificaciones);
						$hisgograma = generarHistograma($calificaciones);
						//json_encode($hisgograma);

						generarInformeCentro($hisgograma, $centro['nombre'], $nUsuarios);
						return parent::renderJson($hisgograma);

						return parent::renderJson(['ok' => true, 'msg' => 'Informe generado']);
						break;
					case 'subidaMasiva':
						$institucionId = $this->request->getParam("institucionId"); 
						$file = $_FILES['file'];
						$centros = ProcesaArchivos::ProcesaCSV($file['tmp_name']); 
						(new CentrosDAO())->bulkInsert($centros, ['institucionId' =>$institucionId]);
						return parent::renderJson(['ok' => true]); 
						break;
					default:
						# code...
						break;
				}
			}

            

			return $this->request->getParam("action");
			
		}

	}

 ?>