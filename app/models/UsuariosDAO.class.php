<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';

	/**
	 * 
	 */
	class UsuariosDAO extends DataBasePDO
	{
		//private static $tableName = "usuarios";
		function __construct()
		{
			parent::__construct('usuarios');
		}

		public function hasRole(int $userId):string
		{
			$sql = 'SELECT role FROM usuarios where id=:id'; 

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":id", $userId, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : "";
		}

		public function getUsuarioById(int $id):array
		{
			$sql = "SELECT * FROM usuarios where id=:id";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":id", $id, PDO::PARAM_INT );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];

		}

		public function getUsuarioByEmail(string $email):array
		{
			$sql = "SELECT * FROM usuarios where email=:email";
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":email", $email, PDO::PARAM_STR );
			$st->execute();
			$result = $st->fetch(PDO::FETCH_ASSOC);
			return $result ? $result : [];
		}

		public function updatePass()
		{
			# code...
		}

		/*public function insert(array $data)
		{

			$sql = "insert into usuarios (`email`, `pass`, `rol`) values (:email, :pass, :role);";

			$email = $data["email"];
			$pass = $data["pass"];
			$role = isset($data["role"]) ? $data["role"] : 'docente';

			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->bindValue( ":email", $email, PDO::PARAM_STR );
			$st->bindValue( ":pass", Usercontrol::generateHashPass($pass), PDO::PARAM_STR );
			$st->bindValue( ":role", $role, PDO::PARAM_STR );
			$st->execute();
			//$result = $st->fetch(PDO::FETCH_ASSOC);

			return $result ? $result : [];
		}*/


	}


?>