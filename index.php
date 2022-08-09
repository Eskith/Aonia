<?php
    $testServer = 'demotestcdd.aonialearning.com'; 
    if(DIRECTORY_SEPARATOR == "\\" || $_SERVER['SERVER_NAME'] === $testServer){
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        ini_set('display_errors', 'On');
    }else{

    }
    if (!function_exists('str_contains')) {
        function str_contains(string $haystack, string $needle): bool
        {
            return '' === $needle || false !== strpos($haystack, $needle);
        }
    }

    //var_dump($_SERVER['SERVER_NAME']);
    //var_dump($_SERVER['HTTP_HOST']);
    
    require_once 'app/controllers/tools/ControllerFactory.class.php';
    require_once 'app/config/Config.class.php';
    try {
        //throw new Exception("Error Processing Request", 1);
        echo ControllerFactory::createController()->render(); 
    } catch (\Throwable $th) {
        // Evitamos que se muestre una excepcion al usuario.
        if(DIRECTORY_SEPARATOR == "\\" || $_SERVER['SERVER_NAME'] === $testServer){
            throw $th;
        }else{
            echo file_get_contents('app\html\aonia\500Error.html'); 
        }
    }
    
//
    ?>