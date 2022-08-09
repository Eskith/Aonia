<?php 
	
	require_once 'app/controllers/tools/Controller.class.php';
	require_once 'app/models/TestDAO_SQL_PDO.class.php';

	/**
	 * 
	 */
	class UserController extends Controller
	{	
		
		function __construct($request){
			parent::__construct('user.html', $request);
		}

		public function render(){
			
			$tests = (new TestDAO)->getTestsByUserId($this->user->getUserID());
			$this->addArgument("tests", $tests);
			return parent::render();
		}

	}

 ?>