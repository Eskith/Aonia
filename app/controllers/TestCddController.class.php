<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/TestCddDAO.class.php';
	require_once 'app/models/TempDataDAO.class.php';


	/**
	 * 
	 */
	class TestCddController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('testCdd.html', $request);
		}

		public function render(){
			require_once 'app/config/questions.php';


			if($this->request->methodIsGet()){
				$this->addArgument("questionGroups", $questions);
				$data = (new TempDataDAO)->getData($this->user->getUserID(), 'testCdd');

				$this->addArgument("data", $data);
				//$this->addArgument('area0', $this->docente['estado'] == 'Hacer Area 0 TestCDD');// Indica si tiene que hacer (o no) en Área 0
				$this->addArgument('area0', true);// El área 0 siempre se tiene que hacer
				return parent::render();
			}else if($this->request->methodIsPost()){
				switch ($this->request->getParam("action")) {
					case 'update':
						//file_put_contents("prueba.txt", $this->request->getParam("data", false));  // Permite hacer un dbugueo mínimo cuando no funciona lo de guardar las respuestas al cerrar el navegador
						//$result = (new TestCddDAO)->update($this->request->getParam("data", false), $this->user->getUserID());
						$data = $this->request->getParam("data", false);
						if($data){
							$result = (new TempDataDAO)->setData($this->user->getUserID(), 'testCdd', $data);
						}else{
							$result = 0; 
						}
						return parent::renderJson($result);
						break;
					case 'insert':
						$respuestas = json_decode($this->request->getParam("responses", false), true);
						/*if($this->request->getParam("area0", false)){
							$comentario = $respuestas['comentario'];
							$respuestasArea0 = [];
							for ($i=1; $i < 5; $i++) {
								$respuesta = 'respuesta_0_'.$i;
								$respuestasArea0[] = $respuestas[$respuesta];
								unset($respuestas[$respuesta]);
							}
							unset($respuestas['comentario']);
						}*/

						$result = (new TestCddDAO)->insert(['docente_id' => $this->user->getUserID(), 'respuestas' => $respuestas]);
						if($this->docente['estado'] == 'Hacer Area 0 TestCDD' || $this->docente['estado'] == 'Hacer TestCDD'){
							$data = [];
							$data['usuario_id'] = $this->user->getUserId();
							$data['estado'] = 'Completo'; // Si venía del estado 0, le añadimos el estado = 1 que implica que ya ha completado el perfil.
							(new DocenteDAO())->update($data);
						}
						return parent::renderJson($result);
						break;
					
					default:
						# code...
						break;
				}
			}
			
		}

	}

 ?>