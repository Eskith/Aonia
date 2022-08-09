<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';
	require_once 'app/utils/Mail.class.php';

	/**
	 * 
	 */
	class ResetPassDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('resetpass');
		}

		public function getUserIdByPetitionId(string $peticion_id):array
		{
			$sql = "SELECT  usuario_id FROM $this->tablename WHERE peticion_id = :peticion_id AND fecha_hasta > NOW();";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ':peticion_id', $peticion_id, PDO::PARAM_STR );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}

		public function insertOrUpdatePeticion(int $usuario_id):string
		{
			$dias_valido = 1; // Numero de dias en los que el enlace es válido.
			$sql = "INSERT INTO  $this->tablename (`usuario_id`, `peticion_id`, `fecha_hasta`) VALUES (:usuario_id, :peticion_id, DATE_ADD(NOW(),INTERVAL $dias_valido DAY)) ON DUPLICATE KEY UPDATE peticion_id=:peticion_id, fecha=CURRENT_TIMESTAMP, fecha_hasta=DATE_ADD(NOW(),INTERVAL $dias_valido DAY)";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$peticion_id = bin2hex(random_bytes(25));
			$st->bindValue( ':usuario_id', $usuario_id, PDO::PARAM_INT );
			$st->bindValue( ':peticion_id', $peticion_id, PDO::PARAM_STR );
			//echo $sql; 
			/* Esto devuelve el último id insertado */
			if($st->execute()){
				$a = $st->rowCount(); 
				return $peticion_id;
			}else{
				return ''; 
			}

		}

	}


?>