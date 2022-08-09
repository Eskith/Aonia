<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';

	/**
	 * 
	 */
	class tempdataDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('tempdata');
		}

		public function setData(int $docente_id, string $key, string $data)
		{
			$sql = 'INSERT INTO `tempdata`(`docente_id`, `key`,`data`) VALUES (:docente_id, :key, :data) ON DUPLICATE KEY UPDATE `data`=:data';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
            $st->bindValue( ":key", $key, PDO::PARAM_STR );
            $st->bindValue( ":data", $data, PDO::PARAM_STR );

            return ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : -1;
		}

		public function getData(int $docente_id, string $key):string
		{
			$sql = 'SELECT `data` FROM `tempdata` WHERE docente_id=:docente_id AND `key`=:key';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
            $st->bindValue( ":key", $key, PDO::PARAM_STR );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result["data"] : ""; 
		}

		public function deleteData(int $docente_id, string $key):bool
		{
			$sql = 'DELETE FROM `tempdata` WHERE docente_id=:docente_id AND `key`=:key';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
            $st->bindValue( ":docente_id", $docente_id, PDO::PARAM_INT );
            $st->bindValue( ":key", $key, PDO::PARAM_STR );
			return $st->execute();
		}


		

	}


?>