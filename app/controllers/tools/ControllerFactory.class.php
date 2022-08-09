<?php 
	require_once 'app/controllers/tools/Request.class.php';
	
/**
 * 
 */
final class ControllerFactory
{
	private function __construct(){}

	public static function createController()
	{	
		$request = new Request(); 
		//echo $request->getPath();
		switch ($request->getNextElement()) {
			case '':
			case 'index':
				require_once 'app/controllers/Index.class.php';
				return new Index($request); 
				break;
			case 'login':
				require_once 'app/controllers/Login.class.php';
				return new Login($request); 
				break;
			case 'user':
				require_once 'app/controllers/UserController.class.php';
				return new UserController($request); 
				break;
			case 'testcdd':
				require_once 'app/controllers/TestCddController.class.php';
				return new TestCddController($request); 
				break;
			case 'informe':
				require_once 'app/controllers/InformeController.class.php';
				return new InformeController($request); 
				break;
			case 'instituciones':
				require_once 'app/controllers/InstitucionesController.class.php';
				return new InstitucionesController($request); 
				break;
			case 'centros':
				require_once 'app/controllers/CentrosController.class.php';
				return new CentrosController($request); 
				break;
			case 'docentes':
				require_once 'app/controllers/DocentesController.class.php';
				return new DocentesController($request); 
				break;
			case 'registro':
				require_once 'app/controllers/RegistroController.class.php';
				return new RegistroController($request); 
				break;
			case 'perfil':
				require_once 'app/controllers/PerfilController.class.php';
				return new PerfilController($request); 
				break;
			case 'resetpass':
				require_once 'app/controllers/ResetPassController.class.php';
				return new ResetPassController($request); 
				break;
			
			case 'admin':
				require_once 'app/controllers/AdminController.class.php';
				return new AdminController($request); 
				break;
			default:
				//require_once 'app/controllers/NotFound.class.php';
				//return new NotFound($request);
				header('Location: /');

				break;
		}
	}

}


?>