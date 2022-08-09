<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';
	require_once 'app/utils/testFunctions.php';
	require_once 'app/models/TempDataDAO.class.php';

	/*
	 *
	 * Ejemplo de como se trae un dato de la bd
	 * 			
			[
				["id" => 40, "nombre" => "Juan"]
			]
		
			
	 * 
	 *  
	 */
	class testcddDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('testcdd_media');
		}

		public function getMedia()
		{
			$sql = 'SELECT * FROM `testcdd_media` WHERE id=1';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		

		public function getAndUpdateLastUserMarkByUserId(int $docente_id, int $marksId):int
		{
			/*Obtenemos las últimas calificaciones antes de actualizarlas */
			$sql = 'UPDATE docentes SET testcdd_ultima_calificacion=:testcdd_ultima_calificacion WHERE usuario_id=:docente_id; ';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
			$st->bindValue( ":testcdd_ultima_calificacion", $marksId, PDO::PARAM_INT );
			$st->execute();

			return ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : -1;

		}

		/*private function updateMedias(array $newMark, array $lastMark)
		{
			
			//UPDATE testcdd_media SET count=count+1, area_1=((area_1*count) 4 )/(count+1) ,area_2=,area_3= WHERE id=1
			
			$sql = [];
			$firstElement = $lastMark[array_key_first($lastMark)];

			if($firstElement == '-1'){
				// Este usuario aun no ha hecho ningún test 
				foreach ($newMark as $area => $value) {
					$sql[] = "$area=(($area*count) + $value )/(count+1)";
				}
				$sql = 'UPDATE testcdd_media SET '.implode(',', $sql).', count=count+1 WHERE id=1; ';
			}else{
				foreach ($newMark as $area => $value) {
					$sql[] = "$area=(($area*count) + $value - $lastMark[$area] )/(count)";
				}
				$sql = 'UPDATE testcdd_media SET '.implode(',', $sql).' WHERE id=1; ';
			}

			//var_dump($mark); 

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->execute();
		}*/

		public function getTestByTestIdAndUserId(int $test_id, int $docente_id):array
		{
			$sql = 'SELECT * FROM `testcdd` WHERE docente_id=:docente_id AND id=:test_id ORDER BY id DESC';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
            $st->bindValue( ":test_id", $test_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		public function getCalificacionByIdAndUsuarioId(int $test_id, int $docente_id):array
		{
			$sql = 'SELECT id, docente_id, area_1, area_2, area_3, area_4, area_5, area_6, finalmark FROM `testcdd` WHERE docente_id=:docente_id AND id=:test_id';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
            $st->bindValue( ":test_id", $test_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		public function getRespuestasByUserId(int $docente_id):array
		{
			$sql = 'SELECT * FROM `testcdd` WHERE docente_id=:docente_id ORDER BY id DESC';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		public function getCalificacionesByUsuarioId(int $docente_id, int $limit = 0):array
		{
			$sql = 'SELECT id, area_1, area_2, area_3, area_4, area_5, area_6, finalmark, fecha FROM `testcdd` WHERE docente_id=:docente_id ORDER BY id DESC'. ($limit ? 'LIMIT ' . $limit : '');
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		public function getCalificacionesByCentroId(int $centro_id):array
		{
			$sql = "SELECT edad, area_1, area_2, area_3, area_4, area_5, area_6, finalmark FROM docentes d
			INNER JOIN testcdd c ON d.centro_id = :centro_id AND testcdd_ultimo_test = c.id";
	
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":centro_id", $centro_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : [];

		}

		/*public function getMarksByUserIdAndTestId(int $testId, int $docente_id):array
		{
			$sql = 'SELECT `id`, `fecha` FROM `testcdd_calificaciones` WHERE docente_id=:docente_id and ';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}*/

		public function insertMark(int $respuesta_id, array $marks, int $docente_id):int{
			$markKeys = array_keys($marks); 
			$sql = 'INSERT INTO `testcdd_calificaciones`(respuesta_id, docente_id, '.implode(', ', $markKeys).') VALUES (:respuesta_id, :docente_id, :'.implode(', :', $markKeys).')';

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":respuesta_id", $respuesta_id, PDO::PARAM_INT );
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );

			foreach ($marks as $key => $value) {
				$st->bindValue( ':'.$key, $value, PDO::PARAM_STR );
			}

			/* Esto devuelve el último id insertado */
			$result = ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : -1;

            return $result;

		}

		
		/* Inserción de un nuevo test CDD hecho por el usuaro */
		public function insert(array $data)
		{
			$docente_id = $data['docente_id'];
			$responses = $data['respuestas'];
			$area_0 = ''; 

			if(isset($responses['area0'])){
				$area_0 = is_string($responses['area0']) ? $responses['area0'] : json_encode($responses['area0']);

				$i = 1; 
				$respuesta = 'respuesta_0_'.$i;
				while (isset($responses[$respuesta])) {
					unset($responses[$respuesta]);
					$respuesta = 'respuesta_0_'.++$i;
				}

				unset($responses['area0']);
			}

			$keys = array_keys($responses);
			$marks = generateMarks($responses); 
			$markKeys = array_keys($marks);

			$sql = 'INSERT INTO `testcdd`(docente_id, area_0, '.implode(', ', $keys).', '.implode(', ', $markKeys).') VALUES (:docente_id, :area_0, :'.implode(', :', $keys).', :'.implode(', :', $markKeys).')';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
			$st->bindValue( ':area_0', $area_0, PDO::PARAM_STR );
			
			//echo $sql; 

			foreach ($responses as $key => $value) {
				$st->bindValue( ':'.$key, $value, PDO::PARAM_STR );
			}

			foreach ($marks as $key => $value) {
				$st->bindValue( ':'.$key, $value, PDO::PARAM_STR );
			}

			$id = ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : -1;

			if($id > 0){
				//$marksId = $this->insertMark($id, $marks, $docente_id); 

				//$lastMark = $this->getAndUpdateLastUserMarkByUserId($docente_id, $marksId); 

				if($id != -1){
					(new TempDataDAO)->deleteData($docente_id, 'testcdd');	// Eliminamos los datos temporales del test
					//$this->updateMedias($marks, $lastMark);  // Se hace por trigger 
				}
			}

            return $id;
		}

		public function update(array $data, array $options = [])
		{
			$sql = 'INSERT INTO `uncompleted_test`(`docente_id`, `data`) VALUES (:docente_id, :data) ON DUPLICATE KEY UPDATE `data`=:data';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
            $st->bindValue( ":data", $data, PDO::PARAM_STR );

            return ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : -1;
		}

		public function gettestcddIncompleto(int $usuario_id):string{
			
		}

		public function updateResponsesTable(string $colunName, string $sql)
		{
			$sql =  "ALTER TABLE testcdd_responses ADD $sql;"; 

			echo $sql; 
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->execute();
		

		}


	}


?>