<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';

	/**
	 * 
	 */
	class UserDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('usuarios');
		}

		function hasRole(int $userId):string
		{
			$sql = 'SELECT role FROM user where id=:id'; 

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":id", $id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : "";
		}

		public static function getUserById(int $id):array
		{
			$sql = "SELECT * FROM user where id=:id";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":id", $id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];

		}

		

	}


?>