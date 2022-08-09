<?php 


require_once "app/dependencies/vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as Eloquent;

//$credentials 	= parse_ini_file('app/config/databaseCredentials.config.php');

$capsule = new Capsule;

$capsule->addConnection([
    "driver" => "mysql",
    /*
    "host"      => $credentials["db_host"],
    "database"  => $credentials["db_name"],
    "username"  => $credentials["db_user"],
    "password"  => $credentials["db_pass"]
    */

    "host"      => Config::getValue('db_host'),
    "database"  => Config::getValue('db_name'),
    "username"  => Config::getValue('db_user'),
    "password"  => Config::getValue('db_pass')

 ]);
 
$capsule->setAsGlobal();
$capsule->bootEloquent();

abstract class DataBaseEloquent extends Eloquent
{
    protected function __construct() {
        $this->table = strtolower(str_replace('Eloquent', '', get_class($this)));
    }
}
