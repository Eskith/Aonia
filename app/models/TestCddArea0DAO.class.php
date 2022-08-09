<?php 
	require_once 'app/models/tools/DataBasePDO.class.php';

	/**
	 * 
	 */
	class TestCddArea0DAO extends DataBasePDO
	{
		
		function __construct()
		{
			parent::__construct('testCDD_area0');
		}

		public function getEtapas():array
		{
			  return $this->get(["select" => "id, nombre", "table" => "etapas", "order" => 'id ASC']);
		}

		public function getDefaultAreas():array
		{
			  return $this->get(["select" => "id, nombre", "table" => "etapas", "order" => 'id ASC']);
		}
		
	}


?>