<?php 
	require_once 'app/models/UsuariosDAO.class.php'; 

    session_cache_expire(60);
    session_start();
    //session_regenerate_id(true);

	/**
	 * 
	 */
	class UserControl 
	{
		
		private $user = null;

		function __construct()
		{
            //abrimos la sesión
            if (isset($_SESSION["userID"]) && $_SESSION["userID"]) {//El usuario está registrado
                //$this->getUserData($_SESSION["userID"]);
                $this->user = (new UsuariosDAO())->getUsuarioById($_SESSION["userID"]);
			}
        }
        public function isLogued():bool
		{
			return isset($this->user) && $this->user;
        }
        public function isAdmin():bool
		{
			return $this->isLogued() && $this->isAdmin();
		}

        public function getUserId():string
        {
            /* La primera e sla buena una vez que esté todo implementado */
            //return $this->isLogued() ? $this->user->getId(): "";
            return $this->isLogued() ? $this->getUser()['id'] : 0;
        }

        public function getUser():array 
        {
            return $this->user;
        }

        /*private function getUserData($userID)
        {
            $this->userID = $userID;
            $this->user = true; 
        }*/

        public function hasRole(string $role)
        {
            if(!$role){
                return true; 
            }else{
                if(!$this->isLogued()){
                    return false; 
                }
                return $this->user['rol'] == $role;
            }
        }

        public function login(string $user, string $pass): bool
        {
            //

            /* Aquí ira el login de ceibal con el protocolo cast */
            $user = (new UsuariosDAO())->getUsuarioByEmail($user);

            if($user && password_verify($pass, $user['pass'])){              
                $_SESSION["userID"] = $user['id']; 
                $this->user = $user;
                return true;
            }else{
                $this->logout(); 
                return false;
            }

            return $user === "gsdfgsdfg" && $pass === "sdfgdsf";
        }

        public function logout() : void
		{
            unset($this->userID);
            $this->user = null;
			if (session_status()==PHP_SESSION_NONE)
			session_start();
			// Borrar variables de sesión
			session_unset(); 
			// Obtener parámetros de cookie de sesión
			$param = session_get_cookie_params();
            // Borrar cookie de sesión si existe
            if(isset($_COOKIE[session_name()])){
                setcookie(session_name(), $_COOKIE[session_name()], time()-2592000,
			    $param['path'], $param['domain'], $param['secure'], $param['httponly']);
            }
			// Destruir sesión
			session_destroy();
		}

        public static function register(string $user, string $pass)
        {
            return (new UsuariosDAO())->insert(['email' => $user, 'pass' =>  self::generateHashPass($pass)]);
        }

        public static function updatePass(int $id, string $pass)
        {
            return (new UsuariosDAO())->update(['id' => $id, 'pass' =>  self::generateHashPass($pass)]);
        }

        public static function updateEmail(int $id, string $email)
        {
            return (new UsuariosDAO())->update(['id' => $id, 'email' =>  $email]);
        }

        public static function generateHashPass(string $pass)
        {
            $timeTarget = 0.075; // 75 milisegundos 
            $coste = 8;
            do {
                $coste++;
                $inicio = microtime(true);
                $hashPass = password_hash($pass, PASSWORD_BCRYPT, ["cost" => $coste]);
                $fin = microtime(true);
            } while (($fin - $inicio) < $timeTarget);

            return $hashPass; 

        }


	}


 ?>