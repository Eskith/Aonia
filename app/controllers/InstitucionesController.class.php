<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';

	require_once 'app/models/InstitucionesDAO.class.php';

	/**
	 * 
	 */
	class InstitucionesController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('instituciones.html', $request, 'administrador');
		}

		public function render(){

            if($this->request->methodIsGet()){
                $institucionesDAO = new InstitucionesDAO();
                $instituciones = $institucionesDAO->getInstituciones();
                //var_dump (json_encode($instituciones));
                $this->addArgument('instituciones', json_encode($instituciones));
				return parent::render();
			}else if($this->request->methodIsPost()){
				switch ($this->request->getParam("action")) {
					case 'getData';
							$result = (new InstitucionesDAO())->getInstituciones();
							return parent::renderJson(['ok' => true, 'data' => $result, 'msg' => 'Centros obtenidos correctamente']);
						break; 
					case 'save':
						$data = $this->request->getParam('data', false);
						if(isset($data['id'])){
							//update
							$result = (new InstitucionesDAO())->update($data);
							return parent::renderJson(['ok' => true, 'data' => ['id' => $result], 'msg' => 'Centro modificado correctamente']);
						}else{
							$result = (new InstitucionesDAO())->insert($data);
							return parent::renderJson(['ok' => true, 'data' => ['id' => $result], 'msg' => 'Centro añadido correctamente']);
						}
						return ;
					case 'remove':
						$result = (new InstitucionesDAO())->delete($this->request->getParam("id"));
						return parent::renderJson(['ok' => true, 'msg' => 'Institución eliminada correctamente']);
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