<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';

	/**
	 * 
	 */
	class InstitucionesDAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('instituciones');
		}

		function getInstituciones()
		{
			$sql = "SELECT * FROM instituciones";
            //$sql = 'SELECT * FROM `testCDD_calificaciones` WHERE docente_id=:docente_id AND id=:test_id';
			$conn = $this->getConnection();
			$st = $conn->prepare($sql);
			$st->execute();
			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			return $result ? $result : [];

		}

		/*public function insert()
		{
			parent::insert(['nombre' => 'Prueba']);
		}*/

	}


?>