<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';

	/**
	 * 
	 */
	class CentrosDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('centros');
		}

		function getCentros(array $options = [])
		{
			$all = $options['all'] ?? false; 
			$sql = "SELECT c.*, i.nombre institucion, i.id id_institucion, COUNT(d.usuario_id) nDocentes FROM centros c
			LEFT JOIN instituciones i ON c.institucion_id = i.id
			LEFT JOIN docentes d ON d.centro_id = c.id
			GROUP BY c.id ".($all ? '' : 'HAVING nDocentes >  0');
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);
			return $result ? $result : [];

		}

		public function getByCodigoPostal(string $codigoPostal):array
		{
			$sql = "SELECT id, nombre FROM centros c where codigoPostal = :codigoPostal";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ':codigoPostal', $codigoPostal, PDO::PARAM_STR );
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		public function getCentroIdByLink(string $link):int
		{
			$sql = "SELECT id FROM centros c where link = :link";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ':link', $link, PDO::PARAM_STR );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result['id'] : 0;
		}

		public function insert(array $data)
		{	
			$data = $this->normaliceData($data); 
			$data['link'] = uniqid(); //Generamos un link para el id de centro único
			return parent::insert($data);
		}

		public function update(array $data, array  $options = [])
		{
			return parent::update($this->normaliceData($data));
		}


		private function normaliceData(array $data):array
		{
			if(isset($data['link'])){unset($data['link']);} //Si se ha especificado un link, lo eliminamos
			return $data;
		}

		public function bulkInsert(array $centros, array $options = [])
		{

			$batch = $options['batch'] ?? 100; 
			$showProgress = $options['showProgress'] ?? false;
			$institucionId = $options['institucionId'] ?? false;

			$sqlBase = 'INSERT INTO centros (institucion_id, codigoPostal, nombre, codigo, provincia, localidad, direccion, telefono, email, link) VALUES '; 

			$sqlArr = []; 
			foreach (array_keys($centros) as $centrosIndex) {
				$sqlArr[] = "(:institucion_id$centrosIndex, :codigoPostal$centrosIndex, :nombre$centrosIndex, :codigo$centrosIndex, :provincia$centrosIndex, :localidad$centrosIndex, :direccion$centrosIndex, :telefono$centrosIndex, :email$centrosIndex, '".uniqid()."')";

				if($centrosIndex%$batch == 0){
					$conn = $this->getConnection();
					$sql = $sqlBase.implode(', ', $sqlArr);
					$st = $conn->prepare($sql);

					for ($i=max($centrosIndex-$batch+1, 0); $i <= $centrosIndex; $i++) { 
						if($showProgress) var_dump($i);
						$st->bindValue( ':institucion_id'.$i, isset($centros[$i]['institucionId']) ? $centros[$i]['institucionId'] : $institucionId, PDO::PARAM_INT );
						$st->bindValue( ':codigoPostal'.$i, isset($centros[$i]['codigoPostal']) ? $centros[$i]['codigoPostal'] : '', PDO::PARAM_STR );
						$st->bindValue( ':nombre'.$i, isset($centros[$i]['nombre']) ? ucwords(strtolower($centros[$i]['nombre'])) : '', PDO::PARAM_STR );
						$st->bindValue( ':codigo'.$i, isset($centros[$i]['codigo']) ? $centros[$i]['codigo'] : '', PDO::PARAM_STR );
						$st->bindValue( ':provincia'.$i, isset($centros[$i]['provincia']) ? ucwords(strtolower($centros[$i]['provincia'])) : '', PDO::PARAM_STR );
						$st->bindValue( ':localidad'.$i, isset($centros[$i]['localidad']) ? ucwords(strtolower($centros[$i]['localidad'])) : '', PDO::PARAM_STR );
						$st->bindValue( ':direccion'.$i, isset($centros[$i]['direccion']) ? ucwords(strtolower($centros[$i]['direccion'])) : '', PDO::PARAM_STR );
						$st->bindValue( ':telefono'.$i, isset($centros[$i]['telefono']) ? $centros[$i]['telefono'] : '', PDO::PARAM_STR );
						$st->bindValue( ':email'.$i, isset($centros[$i]['email']) ? strtolower($centros[$i]['email']) : '', PDO::PARAM_STR );
					}

					$st->execute();
					$sqlArr = []; 
				}
			}
		}
	}


?>