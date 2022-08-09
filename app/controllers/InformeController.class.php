<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/TestCddDAO.class.php';
	require_once 'app/utils/testFunctions.php';
	require_once 'app/utils/Informe_individual.php';

	/**
	 * 
	 */
	class InformeController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('informe.html', $request);
		}

		public function render(){
			$isInform = $this->request->getElement(1) !== "";
			$this->addArgument("isInform", $isInform);
			if(!$isInform){
				$tests = (new TestCddDAO)->getCalificacionesByUsuarioId($this->user->getUserID());
				$this->addArgument("tests", json_encode($tests)); 
			}else{
				$test_id = $this->request->getElement(1); 
				if($test_id && is_int(($test_id = intval($test_id))) && $test_id > 0){ // Check de seguridad 
					$testDAO = new TestCddDAO();
					$mark 	= $testDAO->getCalificacionByIdAndUsuarioId($test_id, $this->user->getUserID());
					$medias = $testDAO->getMedia();
					$count = $medias['count'];

					unset($mark["id"]);
					unset($mark["docente_id"]);
					unset($medias["id"]);
					unset($medias['count']); 
					$letterMark 	= replaceMarkNumberToString($mark);

					$finalmark = isset($letterMark["finalmark"]) ? $letterMark["finalmark"] : "";
					unset($letterMark["finalmark"]);
					unset($mark["finalmark"]);
					unset($medias["finalmark"]);


					$this->addArgument("finalMark", $finalmark);
					$this->addArgument("letterMark", $letterMark);
					$this->addArgument("mark", $mark);
					$this->addArgument("descriptores", getDescriptores($letterMark));
					$this->addArgument("recomendaciones", getRecomendaciones($letterMark));
					$this->addArgument("globalMark", $medias);
					$this->addArgument("count", $count);
				}
			}
			if($this->request->methodIsPost()){
				switch ($this->request->getParam("action")) {
					case 'generarInformeIndividual':
						if($test_id && is_int(($test_id = intval($test_id))) && $test_id > 0){ // Check de seguridad 
							$testDAO = new TestCddDAO();
							$calificacionesNumero 	= $testDAO->getCalificacionByIdAndUsuarioId($test_id, $this->user->getUserID());
							unset($calificacionesNumero["id"]);
							unset($calificacionesNumero["docente_id"]);

							$calificacionesLetra 	= replaceMarkNumberToString($calificacionesNumero);
							$calificacionFinal = isset($calificacionesLetra["finalmark"]) ? $calificacionesLetra["finalmark"] : "";
							unset($calificacionesNumero["finalmark"]);
							unset($calificacionesLetra["finalmark"]);
    						$descriptores= getDescriptores($calificacionesLetra);

							$medias = $testDAO->getMedia();
							return generarInformeIndividual($calificacionesLetra, $calificacionesNumero, $calificacionFinal, $medias, $descriptores);
						}
						return parent::renderJson(['ok' => true, 'msg' => 'Informe generado']);
						break;
				}
			}
			return parent::render();
			
		}

	}

 ?>