<?php 
    require_once 'app/config/Config.class.php';

class DataBasePDO
{

	private $connection;
	private $host;
	private	$user;
	private	$password;
	private	$name;


	public function __construct(string $tablename)
	{	
		$this->tablename = $tablename;

		/*
		$credentials 	= parse_ini_file('app/config/databaseCredentials.config.php');
		
		$this->host 			= $credentials["db_host"];
		$this->name 			= $credentials["db_name"];
		$this->user 			= $credentials["db_user"];
		$this->password 		= $credentials["db_pass"];
		*/

		// $this->host 			= Config::getValue('db_host');
		// $this->name 			= Config::getValue('db_name');
		// $this->user 			= Config::getValue('db_user');
		// $this->password 		= Config::getValue('db_pass');

		$this->host 			= "localhost";
		$this->name 			= "kxlmbgoc_testcdd";
		$this->user 			= "root";
		$this->password 		= "";
// Aqui  borrar credenciales y desxcomentar

	}

	

	public function getConnection() {

		if(!$this->connection){
			try { 
				//echo "$this->dbType:host=$this->host;dbname=$this->name;charset=utf8";
				$this->connection = new PDO( "mysql:host=$this->host;dbname=$this->name;charset=utf8", $this->user, $this->password); 
				$this->connection->setAttribute( PDO::ATTR_PERSISTENT, true ); //Keep alive the db connection
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} catch ( PDOException $e ) { 
				throw new Exception("DataBaseMySQL connection fail (".$e->getCode()."): " . $e->getMessage());
			}
		}
		
		return $this->connection; 

	}


	/*
		Lo uso para saber si existe o no un ID en una tabla.
	*/
	public function existsId(int $id, array $options = []):bool
	{
		$sql = "SELECT COUNT(*) n FROM ".( isset($options['tabla']) ? $options['tabla'] : $this->tablename)." WHERE ".( isset($options['id_field_name']) ? $options['id_field_name'] : ' id ')." = :id";

		$conn = $this->getConnection();
		$st = $conn->prepare($sql);
		$st->bindValue( ':id', $id, PDO::PARAM_STR );
		$st->execute();
		$result = $st->fetch(PDO::FETCH_ASSOC);

		return $result && $result['n'];
	}

	public function getById(int $id, array $options = []):array
	{
		$options['where'] = 'id = '.$id;
		return ($this->get($options)[0]); 
	}

	public function get(array $options = [])
	{
		$select = 'SELECT '.(isset($options['select']) ? $options['select'] : ' * ');
		$table = ' FROM '.(isset($options['table']) ? $options['table'] : $this->tablename);
		$where = isset($options['where']) ? ' WHERE '.$options['where'] : '';
		
		$joins = '';
		if(isset($options['joins'])){
			foreach ($options['joins'] as $join) {
				$joins .= "\n\t ".(isset($join['type']) ? $join['type'] : 'INNER JOIN').' '.$join['tabla'].' ON '.$join['on'];
			}
		}

		$limit = isset($options['limit']) ? ' LIMIT '. intval($options['limit']) : '';
		$offset = isset($options['offset']) ? ' OFFSET '. intval($options['offset']) : '';
		$order = isset($options['order']) ? ' ORDER BY '. $options['order'] : '';

		$sql = $select.$table.$joins.$where.$limit.$offset.$order;
		//echo $sql; 
		$conn = $this->getConnection();
		$st = $conn->prepare($sql);
		$st->execute();
		$result = $st->fetchAll(PDO::FETCH_ASSOC);

		return $result ? $result : [];

	}

	public function insert(array $data) 
	{
		$data = $this->cleanData($data);
		$keys = array_keys($data); 
		$sql = 'INSERT INTO '.$this->tablename.'('.implode(', ', $keys).') VALUES (:'.implode(', :', $keys).')';
		$conn = $this->getConnection();
		$st = $conn->prepare($sql);
		foreach ($data as $key => $value) {
			$st->bindValue( ':'.$key, $value, PDO::PARAM_STR );
		}
		//echo $sql; 
		/* Esto devuelve el último id insertado */

		$result = ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : 0;
        return $result;
	}

	public function update(array $data, array $options = [])
	{
		$data = $this->cleanData($data);
		$id = isset($options['id']) ? $options['id'] : $data['id'];

		if(isset($data['id'])){unset($data['id']);};

		$sql = 'UPDATE '.$this->tablename.' SET '.implode(', ', array_map(function (string $valueName):string{return $valueName. ' = :'.$valueName;
		}, array_keys($data))).' WHERE '.( isset($options['id_field_name']) ? $options['id_field_name'] : ' id ').' =:id';
		//echo $sql; 

		$conn = $this->getConnection();
		$st = $conn->prepare($sql);
		$st->bindValue( ':id', $id, PDO::PARAM_INT );
		foreach ($data as $key => $value) {
			$st->bindValue( ':'.$key, $value, PDO::PARAM_STR );
		}
		$result = ($st->execute() && $st->rowCount() == 1) ? $conn->lastInsertId() : 0;
        return $result;
	}

	public function delete(int $id)
	{
		$sql = 'DELETE FROM '.$this->tablename.' WHERE id=:id';
		$conn = $this->getConnection();
		$st = $conn->prepare($sql);
		$st->bindValue( ':id', $id, PDO::PARAM_INT );
		$result = ($st->execute() && $st->rowCount());
        return $result;
	}

	private function cleanData(array $data): array{
		$sql = "EXPLAIN $this->tablename;";
		$conn = $this->getConnection();
		$st = $conn->prepare($sql);
		$st->execute();
		$columns = $st->fetchAll(PDO::FETCH_ASSOC);
		$columns = array_column($columns, 'Field');
		return array_filter($data, function ($dataColumn) use ($columns) {return in_array($dataColumn, $columns);}, ARRAY_FILTER_USE_KEY);

	}


}


 ?>