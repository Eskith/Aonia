<?php

class Config  
{
    private static $values = [
        "template" =>  "aonia",
        "template" =>  "aonia",
    ];

    private static $configFileReaded = false; 


    public static function getValue(string $value)
    {
        if(!self::$configFileReaded){
            // Sólo leemos el archivo de configuración una vez. 
            self::$values = array_merge(self::$values, parse_ini_file('app/config/databaseCredentials.config.php'));
            self::$values = array_merge(self::$values, parse_ini_file('app/config/email.config.php'));
            self::$values['hostname'] = DIRECTORY_SEPARATOR == "\\" ? 'http://testcdd.test/' : 'https://demotestcdd.aonialearning.com/';
            self::$configFileReaded = true;
        }

        return isset(self::$values[$value]) ? self::$values[$value] : null; 
    }
}


?>