<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';
	require_once 'app/models/UsuariosDAO.class.php';
	
	/**
	 * 
	 */
	class DocenteDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('docentes');
		}
		/*
		
		SELECT d.usuario_id, d.nombre, d.apellidos, d.estado, c.nombre centro, c.id centro_id, a.nombre AREA, GROUP_CONCAT(e.nombre) etapas, GROUP_CONCAT(e.id) etapas_id
		FROM docentes d
			INNER JOIN centros c ON c.id = d.centro_id
			INNER JOIN areas a ON a.id = d.area_id
			INNER JOIN docentes_etapas de ON de.docente_id = d.usuario_id
			INNER JOIN etapas e ON e.id = de.etapa_id
		GROUP BY usuario_id
		ORDER BY d.nombre, d.apellidos

		*/
		public function getById(int $id, array $options = []):array
		{	
			$options['select']= 'docentes.*, GROUP_CONCAT(de.etapa_id) as etapas_id';
			$options['where'] = 'usuario_id = '.$id;
			$options['joins'][] = ['type' => 'LEFT JOIN', 'tabla' => 'docentes_etapas de', 'on' => 'usuario_id = de.docente_id'];
			//$options['joins'][] = ['type' => 'LEFT JOIN', 'tabla' => 'etapas e', 'on' => 'e.id = de.etapa_id'];
			
			$docente = $this->get($options)[0];
			if($docente){
				$docente['etapas_id'] = explode(',', $docente['etapas_id']);
			}
			return $docente;

		}

		public function getAll()
		{
			$sql = "SELECT u.email, d.usuario_id id, d.nombre, d.apellidos, d.estado, c.nombre centro, c.id centro_id, t.fecha fechaUltimoTest
			FROM docentes d
				INNER JOIN usuarios u ON u.id =d.usuario_id
				INNER JOIN centros c ON c.id = d.centro_id
				LEFT JOIN testcdd t ON t.id = d.testCdd_ultimo_test
			GROUP BY usuario_id
			ORDER BY d.usuario_id ASC";

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);
			return $result ? $result : [];
		}

		public function getByCentroId(int $centro_id)
		{	
			$sql = "SELECT u.email, d.usuario_id id, d.nombre, d.apellidos, d.estado, c.nombre centro, c.id centro_id, t.fecha fechaUltimoTest
			FROM docentes d
				INNER JOIN usuarios u ON u.id =d.usuario_id
				INNER JOIN centros c ON c.id =:centro_id AND c.id = d.centro_id
				LEFT JOIN testcdd t ON t.id = d.testCdd_ultimo_test
			GROUP BY usuario_id
			ORDER BY d.usuario_id ASC";

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindParam( ":centro_id", $centro_id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);
			return $result ? $result : [];
		}

		public function getEtapas():array
		{
			  return $this->get(["select" => "id, nombre", "table" => "etapas", "order" => 'id ASC']);
		}

		private function normaliceData(array $data):array
		{
			if(isset($data['link'])){unset($data['link']);} //Si se ha especificado un link, lo eliminamos
			return $data;
		}

		private function manageEstados($docenteId)
		{
			# code...
		}
		
		public function insert(array $data)
		{	
			//var_dump($data);
			if(isset($data['etapas'])){
				$etapas = $data['etapas'];
				unset($data['etapas']);
			}
			
			if(!isset($data['centro_id'])){
				$data['centro_id'] = 1; 
			}
			if(!isset($data['estado'])){
				$data['estado'] = 1; // Por defecto tiene estado = 1 ==> Perfil completado
			}
			//var_dump($data);
			$docenteId = parent::insert($data);
			if($docenteId){
				$this->setUserEtapas($docenteId, $etapas);
			}

			return $docenteId;
		}

		public function update(array $data, array $options =[])
		{	
			if(isset($data['centro'])){
				unset($data['centro']);
			}
			
			if(isset($data['etapas'])){
				$etapas = $data['etapas'];
				unset($data['etapas']);
			}

			if(isset($data['pass'])){
				unset($data['pass']);
			}
			$docenteId = parent::update($data, ['id' => $data['usuario_id'], 'id_field_name' => 'usuario_id']);
			if(isset($options['updateEtapas']) && $options['updateEtapas']){
				$this->setUserEtapas($data['usuario_id'], $etapas);
			}
			return $docenteId;

			//$this->removeUserEtapas($data['usuario_id']);
		}

		public function cambiarEstado(int $estado, int $docente_id)
		{
			return $this->update(['estado' => $estado, 'usuario_id' => $docente_id]);
		}

		private function removeUserEtapas(int $docente_id):void
		{
			$sql = 'DELETE FROM `docentes_etapas` WHERE docente_id = :docente_id';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindParam( ":docente_id", $docente_id, PDO::PARAM_INT );
			$st->execute();
		}

		private function setUserEtapas(int $docente_id, array $etapas):void
		{	
			//Eliminamos las etapas que hay préviamente para después añadirlas. 
			$this->removeUserEtapas($docente_id);
			if($etapas){ // Puede venir el array vacio.
				$sql = 'insert into `docentes_etapas` (`docente_id`, `etapa_id`)
				values '.implode(',', array_map(function (int $etapaNumber):string{return "(:docente_id, :etapa$etapaNumber)";}, array_keys($etapas)));
				$conn = $this->getConnection();
				$st = $conn->prepare($sql);
				$st->bindParam( ":docente_id", $docente_id, PDO::PARAM_INT );
				foreach ($etapas as $key => $etapa) {
					$st->bindValue( ":etapa$key", $etapa, PDO::PARAM_INT );
				}
				$st->execute();
			}
			
		}

		public function getDefaultAreas():array
		{
			  return $this->get(["select" => "id, nombre", 
			  "table" => "areas", 
			  "where" =>  "id IN (1,2,3,4,5,6,7)",
			  "order" => 'id ASC']);
		}

		public function delete(int $id)
		{

			$this->update(['usuario_id' => $id, 'testCdd_ultimo_test' => null]); // Sino hacemos hesto y tiene un test falla una FK circular
			return (new UsuariosDAO)->delete($id);
		}

	}


?>